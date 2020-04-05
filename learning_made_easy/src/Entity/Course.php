<?php

namespace App\Entity;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * @OGM\Node(label="Course")
 */
class Course implements \Serializable
{
    /**
    /* @OGM\GraphId()
     */
    private $id;

    /**
     * @OGM\Property(type="string")
     *
     */
    private $name;

    /**
     * @OGM\Property(type="string")
     *
     */
    private $image;

    /**
     * @var \DateTime
     *
     * @OGM\Property()
     *
     */
    protected $dateTime;

    /**
     * @var User[]|Collection
     *
     * @OGM\Relationship(type="CREATED_BY", direction="INCOMING", collection=true, mappedBy="course", targetEntity="User")
     */
    protected $user;
    /**
     * @var User[]|Collection
     *
     * @OGM\Relationship(type="CREATED_BY", direction="OUTGOING", collection=true, mappedBy="course", targetEntity="LearningResource")
     */
    protected $learningResource;

    public function __construct()
    {
        $this->user = new Collection();
        $this->learningResource = new Collection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getImage()
    {
        return $this->image;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->dateTime;
    }
    /**
     * @return User[]|Collection
     */
    public function getUsers()
    {
        return $this->user;
    }

    /**
     * @return LearningResource[]|Collection
     */
    public function getLearningResource()
    {
        return $this->learningResource;
    }

    public function setDateCreated( $dateTime): self
    {
        $this->dateTime = $dateTime;
        return $this;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function serialize()
    {
        return serialize(array(
                             $this->id,
                             $this->name,
                             $this->dateTime,
                             $this->image
                         )
        );
    }

    /**
     * Constructs the object
     * @link https://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->name,
            $this->dateTime,
            $this->image
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }
}
