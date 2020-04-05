<?php


namespace App\Classes;


use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;

class S3Helper
{
    protected S3Client $s3;

    public function __construct()
    {

        $this->s3 = new S3Client(
            [
                'region' => 'eu-west-2',
                'version' => 'latest',
                'endpoint' => 'http://minio:9000/',
                'use_path_style_endpoint' => true,
                'credentials' => [
                    'key' => 'AKIABUVWH1HUD7YQZQAR',
                    'secret' => 'PVMlDMep3/jLSz9GxPV3mTvH4JZynkf2BFeTu+i8',
                ]
            ]
        );
    }


    public function upload($file, $bucket)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $originalExtension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $filePath = pathinfo($file, PATHINFO_EXTENSION);
        $originalName = $originalFilename . '.' . $originalExtension;
        $mimeType = mime_content_type('/tmp/swoole.upfile.' . $filePath);
        try {
            $this->s3->putObject(
                [
                    'Bucket' => $bucket,
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



    public function checkBucketsAgainstCourse($course): void
    {
        $new = str_replace(' ', '', $course);
        if (!$this->s3->doesBucketExist(strtolower($new))) {
            $this->s3->createBucket(['ACL' => 'public-read', 'Bucket' => strtolower($new)]);
        }
    }


    /**
     * @param $bucket
     * @param $key
     *
     * @return string|string[]
     */
    public function getS3($bucket, $key)
    {
        $trimmedBucket = str_replace(' ', '', strtolower($bucket));

        $response = $this->s3->doesObjectExist($trimmedBucket, $key);
        if ($response) {
            $plainUrl = $this->s3->getObjectUrl($trimmedBucket, $key);
            $url = str_replace('minio', 'localhost', strtolower($plainUrl));
        } else {
            $url = null;
        }
        return $url;
    }



}