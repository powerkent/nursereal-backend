<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use Nursery\Domain\Shared\Enum\Roles;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Webmozart\Assert\Assert;

class Agent implements UserInterface, PasswordAuthenticatedUserInterface
{
    protected ?int $id = null;

    /**
     * @ORM\Column(type="json")
     * @var array<int, string>
     */
    protected array $roles;

    /**
     * @param array<int, string> $roles
     */
    public function __construct(
        protected UuidInterface $uuid,
        protected string $firstname,
        protected string $lastname,
        protected string $email,
        protected ?string $password,
        protected ?NurseryStructure $nurseryStructure,
        protected DateTimeInterface $createdAt,
        protected ?DateTimeInterface $updatedAt,
        array $roles = [],
    ) {
        Assert::stringNotEmpty($firstname);
        Assert::stringNotEmpty($lastname);
        Assert::email($email);

        $this->roles = $roles;
        if (empty($this->roles)) {
            $this->roles = [Roles::Agent->value];
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function setUuid(UuidInterface $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getNurseryStructure(): NurseryStructure
    {
        return $this->nurseryStructure;
    }

    public function setNurseryStructure(NurseryStructure $nurseryStructure): self
    {
        $this->nurseryStructure = $nurseryStructure;

        return $this;
    }

    /**
     * @return array<int, string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array<int, string> $roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $hashedPassword): self
    {
        $this->password = $hashedPassword;

        return $this;
    }
}
