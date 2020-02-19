<?php


namespace App\Entity;

use GraphAware\Neo4j\OGM\Common\Collection;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 * @OGM\Node(label="LearningResource")
 */
class LearningResource
{

    /**
    /* @OGM\GraphId()
     */
    private $id;

    /**
     * @OGM\Property(type="string")
     */
    private $name_of_file;

    /**
     * @OGM\Property(type="string")
     */
    private $date_uploaded;

    /**
     * @OGM\Property(type="string")
     */
    private $learning_type = [];
    /**
     * @OGM\Property(type="string")
     */
    private $name_of_resource;

    /**
     * @OGM\Property(type="string")
     */
    private $stage;

    public function __construct()
    {
        $this->users = new Collection();

    }

    /**
     * @return mixed
     */
    public function getNameOfResource()
    {
        return $this->name_of_resource;
    }

    /**
     * @param mixed $name_of_resoruce
     */
    public function setNameOfResource($name_of_resource): self
    {
        $this->name_of_resource = $name_of_resource;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNameOfFile(): string
    {
        return $this->name_of_file;
    }

    /**
     * @param mixed $name_of_file
     */
    public function setNameOfFile($name_of_file): self
    {
        $this->name_of_file = $name_of_file;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateUploaded(): string
    {
        return $this->date_uploaded;
    }

    /**
     * @param mixed $date_uploaded
     */
    public function setDateUploaded($date_uploaded): void
    {
        $this->date_uploaded = $date_uploaded;
    }

    /**
     * @return mixed
     */
    public function getLearningType(): string
    {
        return $this->learning_type;
    }

    /**
     * @param mixed $learning_type
     */
    public function setLearningType($learning_type): void
    {
        $this->learning_type = $learning_type;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * @param mixed $stage
     */
    public function setStage($stage): void
    {
        $this->stage = $stage;
    }


}