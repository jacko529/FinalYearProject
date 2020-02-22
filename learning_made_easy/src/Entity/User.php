<?php

namespace App\Entity;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @OGM\Node(label="User")
 */
class User implements UserInterface, \Serializable
{


    /**
    /* @OGM\GraphId()
     */
    protected $id;

    /**
     * @OGM\Property(type="string")
     */
    protected $firstName;


    /**
     * @OGM\Property(type="string")
     */
    protected $surname;


    /**
     * @OGM\Property(type="string")
     */
    protected $email;

    /**
     * @OGM\Property(type="string")
     */
    protected $roles = [];

    /**
     * @var string The hashed password
     * @OGM\Property(type="string")
     */
    protected $password;

    /**
     * @OGM\Property(type="int")
     */
    protected $time;
    /**
     * @var LearningStyle[]|Collection
     *
     * @OGM\Relationship(type="HAS", direction="OUTGOING", collection=true, mappedBy="user", targetEntity="LearningStyle")
     */
    protected $learningStyles;

    /**
     * @var Course[]|Collection
     *
     * @OGM\Relationship(type="CREATED_BY", direction="OUTGOING", collection=true, mappedBy="user", targetEntity="Course")
     */
    protected $course;


    public function __construct()
    {
        $this->learningStyles = new Collection();
        $this->course = new Collection();
    }


    public function getLearningStyles()
    {
        return $this->learningStyles;
    }

    public function getCourse()
    {
        return $this->course;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail(): string
    {
        return (string) $this->email;

    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return (string)$this->firstName;
    }


    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return (string)$this->surname;
    }


    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

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
                $this->firstName,
                $this->surname,
                $this->email,
                $this->roles,
                $this->time
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
            $this->firstName,
            $this->surname,
            $this->email,
            $this->roles,
            $this->time
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time): void
    {
        $this->time = $time;
    }
}
