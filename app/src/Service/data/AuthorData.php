<?php

declare(strict_types=1);

namespace App\Service;
use App\Entity\Role;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class AuthorData
{
    private string $userId;
    private string $name;
    private ?string $avatar = null;

    public function __construct(
        ?string $userId, 
        string $name,
        ?string $avatar = null,
    ) {
        $this->userId = $userId;
        $this->name = $name;
        $this->avatar = $avatar;
    }
}