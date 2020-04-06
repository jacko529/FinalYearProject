<?php


namespace App\Entity;

use GraphAware\Neo4j\OGM\Common\Collection;
use GraphAware\Neo4j\OGM\Annotations as OGM;

/**
 * @OGM\Node(label="LearningStyle")
 */
class LearningStyle implements \Serializable
{

    /**
    /* @OGM\GraphId()
     */
    private $id;

    /**
     * @OGM\Property(type="string")
     */
    private $reflective;

    /**
     * @OGM\Property(type="string")
     */
    private $intuitive;

    /**
     * @OGM\Property(type="string")
     */
    private $verbal;

    /**
     * @OGM\Property(type="string")
     */
    private $global;

    /**
     * @OGM\Property(type="boolean")
     */
    private $active;

    /**
     * @var User[]|Collection
     *
     * @OGM\Relationship(type="HAS", direction="INCOMING", collection=true, mappedBy="learningStyles", targetEntity="User")
     */
    protected $user;

    public function __construct()
    {
        $this->user = new Collection();
    }

    // other code

    /**
     * @return User[]|Collection
     */
    public function getUsers()
    {
        return $this->user;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getGlobal(): string
    {
        return (string) $this->global;
    }

     public function setGlobal(string $global): self
     {
            $this->global = $global;
            return $this;
     }

    public function setUser( $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVerbal(): string
    {
        return (string) $this->verbal;
    }


    public function setVerbal(string  $verbal): self
    {
        $this->verbal = $verbal;

        return $this;
    }
    public function setActive(bool  $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getActive():string
    {
        return (bool) $this->active;
    }
    /**
     * @return mixed
     */
    public function getIntuitive():string
    {
        return (string) $this->intuitive;
    }

    /**
     * @param mixed $intuitive
     */
    public function setIntuitive(string $intuitive): self
    {
        $this->intuitive = $intuitive;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReflector(): string
    {
        return (string) $this->reflective;
    }

    /**
     * @param mixed $reflective
     */
    public function setReflector(string $reflective): self
    {
        $this->reflective = $reflective;
        return $this;
    }

    /**
     * String representation of object
     * @link https://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
                $this->id,
                $this->reflective,
                $this->intuitive,
                $this->verbal,
                $this->global,
                $this->active
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
            $this->reflective,
            $this->intuitive,
            $this->verbal,
            $this->global,
            $this->active
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }
}