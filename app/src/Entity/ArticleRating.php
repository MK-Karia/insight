<?php

declare(strict_types=1);

namespace App\Entity;


class ArticleRating
{
    private Article $article;
    private User $user;
    private bool $like;

    public function __construct(Article $article, User $user, bool $like)
    {
        $this->article = $article;
        $this->user = $user;
        $this->like = $like;
    }

    public function getArticle(): Article
    {
        return $this->article;
    }

    public function setArticle(Article $article): void
    {
        $this->article = $article;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function isLike(): bool
    {
        return $this->like;
    }

    public function setLike(bool $like): void
    {
        $this->like = $like;
    }

}
