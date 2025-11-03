<?php

declare(strict_types=1);

namespace App\Entity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    private string $userId;
    private string $name;
    private string $email;
    private \DateTimeInterface $birthdate;
    private string $password;
    private Role $role;
    private ?string $avatar = null;

    public function __construct(
        string $userId, 
        string $name,
        string $email, 
        \DateTimeInterface $birthdate,
        string $password,
        Role $role,
        ?string $avatar = null,
    ) {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->birthdate = $birthdate;
        $this->password = $password;
        $this->role = $role;
        $this->avatar = $avatar;
    }

    public function getId(): string
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getBirthdate(): \DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $date): void
    {
        $this->birthdate = $date;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function setRole(Role $role): void
    {
        $this->role = $role;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar = null): void
    {
        $this->avatar = $avatar;
    }
}