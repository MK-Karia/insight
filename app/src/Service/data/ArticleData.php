<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class ArticleData
{
    private string $id;
    private string $title;
    private ?string $image = null;
    private ?string $description = null;
    private array $content;
    private ?User $author;
    private \DateTimeInterface $createdAt;
    private ?\DateTimeInterface $updatedAt = null;
    private int $likes = 0;
    private int $dislikes = 0;
    private int $comments = 0;

    public function __construct(
        string $id,
        string $title,
        ?User $author,
        \DateTimeInterface $createdAt,
        ?\DateTimeInterface $updatedAt,
        ?string $image = null,
        ?string $description = null,
        array $content,
        int $likes = 0,
        int $dislikes = 0,
        int $comments = 0,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->image = $image;
        $this->description = $description;
        $this->content = $content;
        $this->likes = $likes;
        $this->dislikes = $dislikes;
        $this->comments = $comments;
    }
}