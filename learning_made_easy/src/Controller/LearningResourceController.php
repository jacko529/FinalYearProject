<?php

namespace App\Controller;

use App\Classes\JaccardIndex;
use App\Classes\ShortestPath;
use App\Entity\Course;
use App\Entity\LearningResource;
use App\Entity\User;
use App\Repository\LearningResourceRepository;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class LearningResourceController extends AbstractController
{
    protected S3Client $s3;
    protected EntityManagerInterface $entityManager;
    protected TokenStorageInterface $tokenStorage;
    protected LearningResourceRepository $learningResourceRepo;
    protected $learningRecords;
    protected $itemsC;
    protected ShortestPath $shortestPath;
    protected JaccardIndex $jaccardIndex;

    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        LearningResourceRepository $learningResourceRepo,
        ShortestPath $shortestPath,
        JaccardIndex $jaccardIndex
    ) {
        $this->shortestPath = $shortestPath;
        $this->jaccardIndex = $jaccardIndex;
        $this->entityManager = $entityManager;
        $this->s3 = new S3Client(
            [
                'region' => 'eu-west-2',
                'version' => 'latest',
                'credentials' => [
                    'key' => 'AKIAIUGAFHIOCSCQJZTQ',
                    'secret' => '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',
                ]
            ]
        );
        $this->tokenStorage = $tokenStorage;
        $this->learningResourceRepo = $learningResourceRepo;
    }

    /**
     * @param $file
     *
     * @return string
     */
    public function upload($file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $originalExtension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $filePath = pathinfo($file, PATHINFO_EXTENSION);
        $originalName = $originalFilename . '.' . $originalExtension;
        $mimeType = mime_content_type('/tmp/swoole.upfile.' . $filePath);
        try {
            $this->s3->putObject(
                [
                    'Bucket' => 'networking',
                    'Key' => $originalName,
                    'ContentType' => $mimeType,
                    'SourceFile' => '/tmp/swoole.upfile.' . $filePath,
                ]
            );
        } catch (S3Exception $s3Exception) {
            $s3Exception->getMessage();
        }
        return $originalName;
    }

    /**
     *
     *   {
     *       "resourceName: networking 102",
     *       "stage": "2",
     *       "time": "5",
     *       "learning_style": "third"
     *       }
     *    }
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $requests = $request->request->all();

        $file = $request->files->get('file');
        if ($file) {
            $fileName = $this->upload($file);
        } else {
            $fileName = $request->files->get('link');
        }
        $json = json_decode($requests['json'], true);
        $timestamp = date("Y-m-d H:i:s");
        $learningResource = new LearningResource(
            $json['resourceName'],
            $fileName,
            $timestamp,
            $json['learning_style'],
            $json['stage']
        );
        $this->entityManager->persist($learningResource);
        $this->entityManager->flush();
        $stage = intval($json['stage']);
        $previousStage = $stage - 1;
        if ($stage <= 1) {
            $this->learningResourceRepo->connectWithFirstLearningResource(
                $json['time'],
                $json['selectedCourse'],
                $json['resourceName']

            );
        } elseif ($stage > 1) {
            $this->learningResourceRepo->connectWithPreviousLearningResource(
                $json['resourceName'],
                $previousStage,
                $json['time']
            );
        }
        return $this->json('successful');
    }


    /**
     * @param $bucket
     * @param $key
     *
     * @return string|string[]
     */
    public function getS3($bucket, $key)
    {
        $plainUrl = $this->s3->getObjectUrl($bucket, $key);
        $url = str_replace('minio', 'localhost', $plainUrl);
        return $url;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function userFindFirst(Request $request)
    {
        $user = $this->getUser();
        // get the first user
        $usersEmail = $user->getEmail();
        $userEntity = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $usersEmail]);
        $learningStyles = [];
        foreach ($userEntity->getLearningStyles() as $styles) {
            $learningStyles['verbal'] = $styles->getVerbal();
            $learningStyles['intuitive'] = $styles->getIntuitive();
            $learningStyles['reflective'] = $styles->getReflector();
            $learningStyles['global'] = $styles->getGlobal();
            break;
        }
        $lastConsumableItem = 0;
        if (!empty($learningStyles)) {
            $absoluteArr = array_map('abs', array_unique($learningStyles));
            arsort($absoluteArr);
            $topCategory = array_keys($absoluteArr);
            // match with first if it is the first
            $latestConsumedItem = $this->learningResourceRepo->findLatestConsumedItem($usersEmail);
            $latestStage = $this->learningResourceRepo->findLatestStage(array_key_first($absoluteArr));
            if ($latestConsumedItem->records()) {
                $lastConsumableItem = $this->filterNeo4jResponse($latestConsumedItem, 'max');
            }

            $stage = $this->filterNeo4jResponse($latestStage, 'stage');

        // if this is nothing then do the first
        // @todo get the course name and case statement to sort this shit out
        if ($lastConsumableItem === 0) {
            $firstCourse[] = $this->learningResourceRepo->matchFirst(
                $topCategory[0],
                $usersEmail,
                'networking'
            );

            if (empty($firstCourse)) {
                $this->learningRecords = $this->learningResourceRepo->matchFirst(
                    $topCategory[1],
                    $usersEmail,
                    'networking'
                );

                if (empty($firstCourse)) {
                    $this->learningRecords = $this->learningResourceRepo->matchFirst(
                        $topCategory[2],
                        $usersEmail,
                        'networking'
                    );

                    if (empty($firstCourse)) {
                        $this->learningRecords = $this->learningResourceRepo->matchFirst(
                            $topCategory[3],
                            $usersEmail,
                            'networking'
                        );
                    }
                }
            }

        } elseif ($lastConsumableItem < $stage) {
            foreach ($latestConsumedItem->records() as $itemsConsumed) {
                $this->itemsC[] = ($itemsConsumed->get('name'));
                $this->itemsC[] = ($itemsConsumed->get('max'));
            }

            $this->shortestPath->setAll(
                $stage,
                $user->getTime(),
                $topCategory[0],
                $usersEmail,
                'networking',
                $this->itemsC[0]
            );
            $firstCourse['shortest_path'][] = $this->shortestPath->findShortestPath();
            $firstCourse['explain_short_path'][]= $this->shortestPath->explainShortPath();
            $this->shortestPath->emptyReturn();
//            dd($firstCourse);
            $this->jaccardIndex->setAll($usersEmail, 'networking');
            $firstCourse['jarrard'][] = $this->jaccardIndex->findIndex();
        } else {
            $firstCourse = ['none' => ['No more course items left']];
        }
        // get the learning resource item array
        if (!array_key_exists('jarrard', $firstCourse) && array_key_exists('shortest_path', $firstCourse)) {
            $url = $this->getS3('networking', $firstCourse['shortest_path'][0]['name_of_file']);
            $firstCourse['shortest_path'][0]['url'] = $url;
        } elseif (array_key_exists('jarrard', $firstCourse) && array_key_exists('shortest_path', $firstCourse)) {
            $shortestPathUrl = $this->getS3('networking', $firstCourse['shortest_path'][0]['name_of_file']);
            $jarrardPathUrl = $this->getS3('networking', $firstCourse['jarrard'][0]['name_of_file']);
            $firstCourse['shortest_path'][0]['url'] = $shortestPathUrl;
            $firstCourse['jarrard'][0]['url'] = $jarrardPathUrl;
        } elseif (!array_key_exists('shortest_path', $firstCourse) && array_key_exists('jarrard', $firstCourse)) {
            $url = $this->getS3('networking', $firstCourse['jarrard'][0]['name_of_file']);
            $firstCourse['jarrard'][0]['url'] = $url;
        }
        }else {
            $firstCourse = ['none' => ['Needs more information ']];
        }
        return JsonResponse::create($firstCourse)->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }


    public function getJarrardIndex($email)
    {
        $this->learningResourceRepo->deleteSimlarReltionships();
        $this->learningResourceRepo->reRunMatchingProcess();
        $topIndexs = $this->learningResourceRepo->jaradCollabortiveFiltering($email);
        foreach ($topIndexs->records() as $newItem) {
            $returnedArrays[] = $newItem->get('name');
            $returnedArrays[] = $newItem->get('index');
        }

        return $returnedArrays;
    }



    public function consumeLearningResource(Request $request)
    {
        $this->learningResourceRepo->consumeItem($request->get('email'), $request->get('name_of_resource'));
        return $this->json('success');
    }

    /**
     * @param $records
     * @param $get
     *
     * @return array
     */
    public function filterNeo4jResponse($records, $get)
    {
        foreach ($records->records() as $newItem) {
            $returnedArray = $newItem->get($get);
        }
        return $returnedArray;
    }

}
