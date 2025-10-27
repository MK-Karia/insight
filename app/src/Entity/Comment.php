<?php

declare(strict_types=1);

namespace App\Entity;

class Comment
{
    private int $commentId;
    private User $author;
    private Article $article;
    private \DateTimeInterface $createdAt;
    private bool $isEdited;
    private string $content;
    private ?Comment $previousComment = null;

    public function __construct(
        User $author,
        Article $article,
        \DateTimeInterface $createdAt,
        bool $isEdited,
        string $content,
        ?Comment $previousComment = null
    ) {
        $this->author = $author;
        $this->article = $article;
        $this->createdAt = $createdAt;
        $this->isEdited = $isEdited;
        $this->content = $content;
        $this->previousComment = $previousComment;
    }

    public function getId(): int
    {
        return $this->commentId;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    public function getArticle(): Article
    {
        return $this->article;
    }

    public function setArticle(Article $article): void
    {
        $this->article = $article;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getIsEdited(): bool
    {
        return $this->isEdited;
    }

    public function setIsEdited(bool $isEdited): void
    {
        $this->isEdited = $isEdited;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getPreviousComment(): ?Comment
    {
        return $this->previousComment;
    }

    public function setPreviousComment(?Comment $previousComment): void
    {
        $this->previousComment = $previousComment;
    }
}