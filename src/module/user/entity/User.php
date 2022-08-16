<?php

declare(strict_types=1);

namespace App\module\user\entity;

use App\module\shared\traits\CreatedAtTrait;
use App\module\shared\traits\UpdatedAtTrait;
use App\module\shared\traits\UUIDTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Security\Core\User\UserInterface;
use App\module\user\repository\UserRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, \Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface
{
    use UUIDTrait;

    /**
     * @Groups({"default", "profile"})
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private ?string $firstName;

    /**
     * @Groups({"default", "profile"})
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private ?string $lastName;

    /**
     * @Groups({"default", "profile"})
     * @ORM\Column(type="string")
     * @var string
     */
    private string $email;

    /**
     * @Ignore()
     * @ORM\Column(type="string")
     * @var string
     */
    private string $password;

    /**
     * @Groups ({"token"})
     * @var string
     */
    private string $jwt;

    use UpdatedAtTrait;
    use CreatedAtTrait;


    /**
     * @Groups({"files"})
     * @var ArrayCollection|Collection|null
     * @ORM\ManyToMany(targetEntity=UserFile::class, cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinTable(name="user_files",
     *      joinColumns={@ORM\JoinColumn(name="id", referencedColumnName="id", onDelete="cascade")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)}
     *  )
     */
    private Collection|ArrayCollection|null $files;

    #[Pure] public function __construct()
    {
        $this->files = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     * @return User
     */
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     * @return User
     */
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $password
     * @return User
     */
    public function hashPassword(string $password): self
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        return $this;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getFiles(): ArrayCollection|Collection
    {
        return $this->files;
    }

    /**
     * @param UserFile $userFile
     * @return User
     */
    public function addFile(UserFile $userFile): self
    {
        $this->files->add($userFile);

        return $this;
    }

    /**
     * @param UserFile $userFile
     * @return $this
     */
    public function removeFile(UserFile $userFile): self
    {
        $this->files->removeElement($userFile);

        return $this;
    }

    /**
     * @return string
     */
    public function getJwt(): string
    {
        return $this->jwt;
    }

    /**
     * @param string $jwt
     * @return User
     */
    public function setJwt(string $jwt): self
    {
        $this->jwt = $jwt;
        return $this;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    #[Pure] public function __toString(): string
    {
        return (string) $this->getEmail();
    }
}