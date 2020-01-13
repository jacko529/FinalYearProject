<?php

namespace App\Entity;

use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 *
 * @OGM\Node(label="User")
 */
class User
{
    /** @OGM\GraphId() */
    protected $id;

    /** @OGM\Property(type="string") */
    protected $name;

    /** @OGM\Property(type="int") */
    protected $age;

    /** @OGM\Property(type="string") */
    protected $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
