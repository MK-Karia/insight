<?php

declare(strict_types=1);

namespace App\Entity;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role
{
    private int $roleId;
    private string $roleName;

    public function __construct(int $roleId, string $roleName)
    {
        $this->roleId = $roleId;
        $this->roleName = $roleName;
    }

    public function getId(): int 
    {
        return $this->roleId;
    }

    public function getName(): string
    {
        return $this->roleName;
    }
}