<?php

namespace App\Entity;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * @OGM\Node(label="Course")
 */
class Course
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
     * @var User[]|Collection
     *
     * @OGM\Relationship(type="CREATED_BY", direction="INCOMING", collection=true, mappedBy="users", targetEntity="User")
     */
    protected $users;

    public function __construct()
    {
        $this->users = new Collection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
