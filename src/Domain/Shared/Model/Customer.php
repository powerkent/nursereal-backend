<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Nursery\Domain\Shared\Enum\Roles;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Webmozart\Assert\Assert;
use Symfony\Component\Security\Core\User\UserInterface;

class Customer implements UserInterface, PasswordAuthenticatedUserInterface
{
    protected ?int $id = null;

    /** @var Collection<int, Child> */
    protected Collection $children;

    /** @var array<int, string> */
    protected array $roles;

    /**
     * @param array<int, Child>|Collection<int, Child> $children
     * @param array<int, string>                       $roles
     */
    public function __construct(
        protected UuidInterface $uuid,
        protected string $firstname,
        protected string $lastname,
        protected string $email,
        protected string $password,
        protected int $phoneNumber,
        protected DateTimeInterface $createdAt,
        protected ?DateTimeInterface $updatedAt,
        array|Collection $children = [],
        array $roles = [],
    ) {
        Assert::stringNotEmpty($firstname);
        Assert::stringNotEmpty($lastname);
        Assert::email($email);

        $this->children = is_array($children) ? new ArrayCollection($children) : $children;
        $this->roles = $roles;
        if (empty($this->roles)) {
            $this->roles = [Roles::Parent->value];
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    public function getPhoneNumber(): int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection<int, Child>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    /**
     * @param Collection<int, Child>|array<int, Child> $children
     */
    public function setChildren(Collection|array $children): self
    {
        $this->children = $children instanceof Collection ? $children : new ArrayCollection($children);

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
}
