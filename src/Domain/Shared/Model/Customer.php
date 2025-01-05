<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use LogicException;
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Domain\Shared\User\UserDomainInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Webmozart\Assert\Assert;

class Customer implements UserDomainInterface, PasswordAuthenticatedUserInterface
{
    protected ?int $id = null;

    /** @var Collection<int, Child> */
    protected Collection $children;

    /** @var array<int, string> */
    public array $roles;

    /**
     * @param array<int, Child>|Collection<int, Child> $children
     * @param array<int, string>                       $roles
     */
    public function __construct(
        protected UuidInterface $uuid,
        protected ?Avatar $avatar,
        protected string $firstname,
        protected string $lastname,
        protected string $email,
        protected string $user,
        protected string $password,
        protected string $phoneNumber,
        protected DateTimeInterface $createdAt,
        protected ?DateTimeInterface $updatedAt = null,
        array|Collection $children = [],
        array $roles = [],
    ) {
        Assert::stringNotEmpty($firstname, 'Firstname cannot be empty.');
        Assert::stringNotEmpty($lastname, 'Lastname cannot be empty.');
        Assert::email($email, 'Invalid email address.');
        Assert::stringNotEmpty($user, 'User cannot be empty.');

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

    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
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

    public function addChild(Child $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
        }

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

    public function getUser(): string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        if (empty($this->user)) {
            throw new LogicException('User identifier cannot be empty.');
        }

        return $this->user;
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
