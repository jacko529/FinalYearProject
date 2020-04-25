<?php

namespace App\Controller;

use App\Classes\FilterHelper;
use App\Classes\FilterToAddS3Information;
use App\Classes\JaccardIndex;
use App\Classes\S3Helper;
use App\Classes\ShortestPath;
use App\Entity\LearningResource;
use App\Repository\LearningResourceRepository;
use App\Repository\UserRepository;
use App\Validation\CourseContentValidator;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class LearningResourceController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected TokenStorageInterface $tokenStorage;
    protected LearningResourceRepository $learningResourceRepo;
    protected $itemsC;
    protected ShortestPath $shortestPath;
    protected JaccardIndex $jaccardIndex;
    protected UserRepository $userRepository;
    protected FilterToAddS3Information $filterToAddS3Info;
    protected FilterHelper $filterHelper;
    protected $s3;
    protected CourseContentValidator $contentUpload;
    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        LearningResourceRepository $learningResourceRepo,
        ShortestPath $shortestPath,
        JaccardIndex $jaccardIndex,
        UserRepository $userRepository,
        FilterToAddS3Information $filterToAddS3Info,
        FilterHelper $filterHelper,
        CourseContentValidator $contentValidator
    ) {
        $this->shortestPath = $shortestPath;
        $this->jaccardIndex = $jaccardIndex;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->filterToAddS3Info = $filterToAddS3Info;
        $this->filterHelper = $filterHelper;
        $this->s3 = new S3Helper();
        $this->tokenStorage = $tokenStorage;
        $this->learningResourceRepo = $learningResourceRepo;
        $this->contentUpload = $contentValidator;
    }

    /**
     *
     *   {
     *       "resourceName: networking 102",
     *       "stage": 2,
     *       "time": 5,
     *       "learning_style": "third"
     *
     *    }
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $user = $this->getUser();
        $requests = $request->request->all();
        $json = json_decode($requests['json'], true);
        $file = $request->files->get('file');


        if ($file) {
            $fileName = $this->s3->upload($file, strtolower($json['selectedCourse']));
        } else {
            $fileName = $json['link'];
        }
        $validate = $this->contentUpload->validate($json,  $user->getUsername(), $file);

        if($validate !== false){
            return  $this->json(['error' => $validate], 401);
        }
        $this->s3->checkBucketsAgainstCourse($json['selectedCourse']);

        $timestamp = date("Y-m-d H:i:s");
        $learningResource = new LearningResource(
            $json['resourceName'],
            $fileName,
            $timestamp,
            $json['learning_style'],
            intval($json['stage'])
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
                $json['selectedCourse'],
                $json['resourceName'],
                $previousStage,
                ($stage + 1),
                $json['time']
            );
        }
        return $this->json('successful');
    }



    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function userFindFirst(Request $request)
    {
        // make a loop through all courses
        $user = $this->getUser();
        $this->itemsC = [];
        // get the first user
        $usersEmail = $user->getEmail();
        $courses = $this->learningResourceRepo->findCourseStudiedByUser($usersEmail);

        $learningStyles = $this->userRepository->getLearningStyles($usersEmail);

        unset($learningStyles['active']);

        $lastConsumableItem = 0;

        $comparingCourse = (empty($courses) ? ['resource' => ['name' => 'No course information']] : $courses);

        foreach ($comparingCourse as $index => $courseName) {

            $lastStageOfCourse = $this->learningResourceRepo->findLastStageOfCourse($courseName['name']);

            if (!empty($learningStyles) && $lastStageOfCourse > 0) {

                arsort($learningStyles);
                $topCategory = array_keys($learningStyles);
                // match with first if it is the first
                $latestConsumedItem = $this->learningResourceRepo->findLatestConsumedItem($courseName['name'], $usersEmail);
                $stage = $this->learningResourceRepo->findPreferredLatestStage(
                    $usersEmail,
                    $courseName['name'],
                    $learningStyles
                );

                if ($latestConsumedItem->records() && is_array($stage)) {
                    $lastConsumableItem = intval($this->filterNeo4jResponse($latestConsumedItem, 'max'));
                }
                // if this is nothing then do the first

                if ($lastConsumableItem === 0) {
                    $firstMatchingCourses = $this->learningResourceRepo->matchFirstUnion(
                        $usersEmail,
                        $courseName['name']
                    );
                    $repositionFirstCourseArray = $this->filterHelper->repositionedArray($firstMatchingCourses);

                    if($courseName['image']){
                        $courseUrl = $this->s3->getS3($courseName['name'], $courseName['image']);
                    }

                    $firstCourse[] = [
                        'course' => $courseName['name'],
                        'course_image' => $courseUrl ?? null,
                        'shortest_path' => $this->analyzeWhichIsFirst($repositionFirstCourseArray, $topCategory),
                    ];

                    $firstCourse = $this->filterToAddS3Info->filter($index, $courseName['name'], $firstCourse);
                } elseif ($lastConsumableItem < $lastStageOfCourse) {
                    if ($lastConsumableItem < $stage['stage']) {

                        foreach ($latestConsumedItem->records() as $itemsConsumed) {
                            $this->itemsC[] = ($itemsConsumed->get('name'));
                            $this->itemsC[] = ($itemsConsumed->get('max'));
                        }

                        $this->shortestPath->setAll(
                            $stage['stage'],
                            $user->getTime(),
                            $stage['style'],
                            $usersEmail,
                            $courseName['name'],
                            $this->itemsC[0]
                        );
                        $this->jaccardIndex->setAll($usersEmail, $courseName['name'], $this->itemsC[0]);

                        if($courseName['image']){
                            $courseUrl = $this->s3->getS3($courseName['name'], $courseName['image']);
                        }

                        $firstCourse[] = [
                            'course' => $courseName['name'],
                            'course_image' => $courseUrl ?? null,
                            'shortest_path' => $this->shortestPath->findShortestPath(),
                            'explain_short_path' => $this->shortestPath->explainShortPath(),
                            'jarrard' => $this->jaccardIndex->findIndex()
                        ];
                        $this->jaccardIndex->clearAll();
                        $this->shortestPath->emptyReturn();

                        $firstCourse = $this->filterToAddS3Info->filter($index, $courseName['name'], $firstCourse);
                    } else {
                        foreach ($latestConsumedItem->records() as $itemsConsumed) {
                            $this->itemsC[] = ($itemsConsumed->get('name'));
                            $this->itemsC[] = ($itemsConsumed->get('max'));
                        }
                        $this->shortestPath->setAll(
                            $lastStageOfCourse,
                            $user->getTime(),
                            $stage['style'],
                            $usersEmail,
                            $courseName['name'],
                            $this->itemsC[0]
                        );
                        $this->jaccardIndex->setAll($usersEmail, $courseName['name'], $this->itemsC[0]);
                        $courseUrl = $this->s3->getS3($courseName['name'], $courseName['image']);

                        $firstCourse[] = [
                            'course' => $courseName['name'],
                            'course_image' => $courseUrl ?? null,
                            'shortest_path' => $this->shortestPath->findShortestPath(true),
                            'explain_short_path' => $this->shortestPath->explainShortPath(),
                            'jarrad' => $this->jaccardIndex->findIndex()
                        ];
                        $this->jaccardIndex->clearAll();
                        $this->shortestPath->emptyReturn();
                        // if there are no other users in the system then this cannot work

                        $firstCourse = $this->filterToAddS3Info->filter($index, $courseName['name'], $firstCourse);
                    }
                } else {
                    $firstCourse[] = ['none' => ['No more course items left']];
                }
            } else {
                // when it is a new user with no information on them
                $firstCourse[] = $this->courseWrap(['none' => ['Needs more information']], $courseName['name']);
            }
        }

        return JsonResponse::create($firstCourse)->setEncodingOptions(JSON_UNESCAPED_SLASHES);
    }


    public function courseWrap($resources, $courses)
    {
        foreach ($resources as $i => $resource) {
            $wrappedArray = ['course' => $courses, 'resource' => $resources];
        }
        return $wrappedArray;
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
     * matches the first course when the top category
     *
     * @param $firstCourse
     * @param $topCategory
     *
     * @return mixed
     */
    private function analyzeWhichIsFirst($firstCourse, $topCategory)
    {
        foreach ($firstCourse as $key => $value) {
            foreach ($value as $keys => $values) {
                foreach ($values as $keyss) {
                    if ($keyss === $topCategory[0]) {
                        $matchingCourse[] = $value;
                    } elseif ($keyss === $topCategory[1]) {
                        $matchingCourse[] = $value;
                    } elseif ($keyss === $topCategory[2]) {
                        $matchingCourse[] = $value;
                    } elseif ($keyss === $topCategory[3]) {
                        $matchingCourse[] = $value;
                    }
                }
            }
        }

        return $matchingCourse[0];
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
