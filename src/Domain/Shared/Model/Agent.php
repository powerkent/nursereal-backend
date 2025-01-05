<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Domain\Shared\User\UserDomainInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Webmozart\Assert\Assert;
use function is_array;

class Agent implements UserDomainInterface, PasswordAuthenticatedUserInterface
{
    protected ?int $id = null;

    /**
     * @ORM\Column(type="json")
     * @var array<int, string>
     */
    public array $roles;

    /** @var Collection<int, NurseryStructure> */
    protected Collection $nurseryStructures;

    /**
     * @param array<int, string>                                             $roles
     * @param array<int, NurseryStructure>|Collection<int, NurseryStructure> $nurseryStructures
     */
    public function __construct(
        protected UuidInterface $uuid,
        protected ?Avatar $avatar,
        protected ?string $firstname,
        protected ?string $lastname,
        protected ?string $email,
        protected DateTimeInterface $createdAt,
        protected ?DateTimeInterface $updatedAt,
        protected string $user,
        protected ?string $password = null,
        array|Collection $nurseryStructures = [],
        array $roles = [],
    ) {
        if (null !== $this->firstname) {
            Assert::stringNotEmpty($firstname);
        }

        if (null !== $this->lastname) {
            Assert::stringNotEmpty($lastname);
        }

        if (null !== $this->email) {
            Assert::email($email);
        }

        $this->roles = $roles;
        if (empty($this->roles)) {
            $this->roles = [Roles::Agent->value];
        }

        $this->nurseryStructures = is_array($nurseryStructures) ? new ArrayCollection($nurseryStructures) : $nurseryStructures;
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

    public function setAvatar(?Avatar $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
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

    /**
     * @return Collection<int, NurseryStructure>
     */
    public function getNurseryStructures(): Collection
    {
        return $this->nurseryStructures;
    }

    /**
     * @param array<int, NurseryStructure>|Collection<int, NurseryStructure> $nurseryStructures
     */
    public function setNurseryStructures(Collection|array $nurseryStructures): self
    {
        $this->nurseryStructures = $nurseryStructures instanceof Collection ? $nurseryStructures : new ArrayCollection($nurseryStructures);

        return $this;
    }

    public function addNurseryStructure(NurseryStructure $nurseryStructure): self
    {
        if (!$this->nurseryStructures->contains($nurseryStructure)) {
            $this->nurseryStructures->add($nurseryStructure);
        }

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
