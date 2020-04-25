<?php

    namespace App\Services;

    use App\Classes\S3Helper;
    use App\Repository\LearningResourceRepository;
    use NextActive;

    class NextActiveFirstItem implements NextActive
    {

        private array $courseInformation;
        private array $courseDetails;
        private LearningResourceRepository $learningResourceRepository;

        public function __construct(LearningResourceRepository $learningResourceRepository)
        {
            $this->learningResourceRepository = $learningResourceRepository;
        }

        public function getCourseInformation(): array
        {
            return $this->courseInformation;
        }

        public function findLatestCourseItem(array $courseInformation)
        {
            $firstMatchingCourses = $this->learningResourceRepository->matchFirstUnion(
                $this->courseDetails['email'],
                $this->courseDetails['courseName']
            );
            $repositionFirstCourseArray = $this->filterHelper->repositionedArray($firstMatchingCourses);

            if($courseName['image']){
                $courseUrl = $this->s3->getS3($courseName['name'], $courseName['image']);
            }

            $this->courseInformation[] = [
                'course' => $courseName['name'],
                'course_image' => $courseUrl ?? null,
                'shortest_path' => $this->analyzeWhichIsFirst($repositionFirstCourseArray, $topCategory),
            ];

            $this->courseInformation = $this->filterToAddS3Info->filter($this->courseDetails['index'], $courseName['name'], $firstCourse);
        }

        public function addUrl(array $courseInformation)
        {
            // TODO: Implement addUrl() method.
        }


        /**
         * matches the first course when the top category
         *
         * @param $repositionedCourseArray
         * @param $topCategory
         *
         * @return mixed
         */
        private function analyzeWhichIsFirst($repositionedCourseArray, $topCategory)
        {
            foreach ($repositionedCourseArray as $key => $value) {
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

        public function setRequiredCourseDetails(array $requiredCourseDetails)
        {
            $requiredDetails = [
                'email' => null,
                'courseName' => null,
                'topCategory' => null,
                'courseInterationNumber' => null
            ];

            $this->courseDetails = array_combine($requiredDetails, $requiredCourseDetails);
        }
    }