<?php

declare(strict_types=1);

namespace App\Entity;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    private string $articleId;
    private string $title;
    private ?string $image = null;
    private ?string $description = null;
    private array $content;
    private ?User $author;
    private \DateTimeInterface $createdAt;
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct(
        string $articleId,
        string $title,
        array $content,
        ?User $author,
        \DateTimeInterface $createdAt,
        ?\DateTimeInterface $updatedAt,
        ?string $image = null,
        ?string $description = null,
    ) {
        $this->articleId = $articleId;
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->image = $image;
        $this->description = $description;
    }

    public function getId(): string
    {
        return $this->articleId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function setContent(array $content): void
    {
        $this->content = $content;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}