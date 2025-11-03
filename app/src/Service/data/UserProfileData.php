<?php

declare(strict_types=1);

namespace App\Service;
use App\Entity\Role;

class UserProfileData
{
   private string $userId;
    private string $name;
    private ?string $email;
    private \DateTimeInterface $birthdate;
    private Role $role;
    private ?string $avatar = null;

    public function __construct(
        string $userId, 
        string $name,
        ?string $email,
        \DateTimeInterface $birthdate,
        Role $role,
        ?string $avatar = null,
    ) {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->birthdate = $birthdate;
        $this->role = $role;
        $this->avatar = $avatar;
    }
}