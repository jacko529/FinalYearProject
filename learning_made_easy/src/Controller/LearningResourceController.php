<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\LearningResource;
use App\Entity\User;
use App\Repository\LearningResourceRepository;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use GraphAware\Neo4j\Client\ClientInterface;
use GraphAware\Neo4j\OGM\EntityManager;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
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

    public function __construct(EntityManagerInterface $entityManager,
                                TokenStorageInterface $tokenStorage,
                                LearningResourceRepository $learningResourceRepo
                                )
    {
        $this->entityManager = $entityManager;
        $this->s3 = new S3Client([
            'region' => 'eu-west-2',
            'version' => 'latest',
            'endpoint' => 'http://minio:9000/',
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => 'AKIABUVWH1HUD7YQZQAR',
                'secret' => 'PVMlDMep3/jLSz9GxPV3mTvH4JZynkf2BFeTu+i8',
            ]
        ]);
        $this->tokenStorage = $tokenStorage;
        $this->learningResourceRepo = $learningResourceRepo;
    }


    public function upload( $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $originalExtension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $originalName = $originalFilename . '.' . $originalExtension;

        try{
            $this->s3->putObject([
                'Bucket' => 'networking',
                'Key' => $originalName,
                'SourceFile' => $file,
                'Metadata' => array(
                    'Foo' => 'abc',
                    'Baz' => '123'
                )
            ]);
        }catch (S3Exception $s3Exception){
            $s3Exception->getMessage();
        }
        return $originalName;
    }

    /**
     *
     *   {
     *       "resourceName: networking 102",
     *       "stage": "2",
     *       "previous":["networking 101"],
     *       "time": "5",
     *       "learning_style": "third"
     *       }
     *    }
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $requests = $request->request->all();

        $file = $request->files->get('file');

            if($file){
                $fileName = $this->upload($file);
            }else{
                $fileName = $request->files->get('link');
            }
             $json = json_decode($requests['json'], true);
            $timestamp = date("Y-m-d H:i:s");
            $learningResource = new LearningResource();
            $learningResource->setNameOfResource($json['resourceName']);
            $learningResource->setNameOfFile($fileName);
            $learningResource->setDateUploaded($timestamp);
            $learningResource->setLearningType($json['learning_style']);
            $learningResource->setStage($json['stage']);
            $this->entityManager->persist($learningResource);
            $this->entityManager->flush();
            if($json['stage'] === '1'){
                $this->learningResourceRepo->connectWithFirstLearningResource(
                    $json['time'],
                    $json['selectedCourse'],
                    $json['resourceName']

                );
            }else{
                $this->learningResourceRepo->connectWithPreviousLearningResource(
                                                                $json['resourceName'],
                                                                $json['previous'],
                                                                $json['time']
                );
            }



            return $this->json('successful');
    }




    public function getS3($bucket, $key)
    {

        $plainUrl = $this->s3->getObjectUrl($bucket, $key);
        $url = str_replace('minio', 'localhost', $plainUrl);


        return $url;

    }


    public function userFindFirst(Request $request)
    {
//        $user = $this->getUser();

        $userEntity = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'churchillj54@gmail.com']);
        // find initial
        // find all which are
        foreach ($userEntity->getLearningStyles() as $styles) {
            $learningStyles['verbal'] = $styles->getVerbal();
            $learningStyles['intuitive'] = $styles->getIntuitive();
            $learningStyles['reflector'] = $styles->getReflector();
            $learningStyles['global'] = $styles->getGlobal();
            break;
        }
        arsort($learningStyles, SORT_REGULAR);

        $topCategory = max(array_keys($learningStyles));

        $learning = $this->learningResourceRepo->matchFirst($topCategory);

        foreach($learning->records()    as $items){
            dd($items);
            $finalValues = ($items->get('first')); // nodes returned are automatically hydrated to Node objects
        }
        dd($finalValues);
        if($finalValues){
            $firstCourse = $finalValues->values();
        }else{
            $firstCourse = [];

        }
        $this->learningResourceRepo->connectUserAndLo($firstCourse['name_of_resource'],$userEntity->getEmail());
        $url = $this->getS3($firstCourse['name_of_file'], 'networking');
        $firstCourse['url'] = $url;
        return JsonResponse::create($firstCourse)->setEncodingOptions( JSON_UNESCAPED_SLASHES);
    }


}
