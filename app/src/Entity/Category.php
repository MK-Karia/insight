<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    private string $categoryId;
    private string $categoryName;

    public function __construct(string $categoryId, string $categoryName)
    {
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
    }

    public function getId(): string
    {
        return $this->categoryId;
    }

    public function getName(): string
    {
        return $this->categoryName;
    }

    public function setName(string $categoryName): void
    {
        $this->categoryName = $categoryName;
    }
}