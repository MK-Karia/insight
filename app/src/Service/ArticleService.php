<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Article;
use App\Service\ArticlePreviewData;
use App\Service\ArticleData;
use App\Exception\ArticleNotFoundException;
use App\Exception\UserNotFoundException;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;

class ArticleService
{
    private ArticleRepository $articleRepository;
    private UserRepository $userRepository;

    public function __construct(ArticleRepository $articleRepository, UserRepository $userRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
    }

    public function listArticles(): array
    {
        $rows = $this->articleRepository->findArticleList();

        $previews = [];
        foreach ($rows as $row) 
        {
            $previews[] = new ArticlePreviewData(
                $row['id'],
                $row['title'],
                $row['author'],
                $row['createdAt'],
                $row['updatedAt'],
                $row['image'],
                $row['description'],
                (int) $row['likes'],
                (int) $row['dislikes'],
                (int) $row['commentsCount'],
            );
        }

        return $previews;
    }

    public function getArticle(string $articleId): ArticleData
    {
        $row = $this->articleRepository->findArticle($articleId);
        if (!$row)
        {
            throw new ArticleNotFoundException;
        }

        return new ArticleData(
            $row['articleId'],
            $row['title'],
            $row['author'],
            $row['createdAt'],
            $row['updatedAt'],
            $row['image'],
            $row['description'],
            $row['content'],
            (int) $row['likes'],
            (int) $row['dislikes'],
            (int) $row['commentsCount'],
        );
    }


    public function getArticleData(string $id): Article
    {
        $article = $this->articleRepository->find($id);
        if (!$article) 
        {
            throw new ArticleNotFoundException;
        }

        return $article;
    }

    public function createArticle(array $data): Article
    {
        $title = $data['title'] ?? null;
        $image = $data['image'] ?? null;
        $description = $data['description'] ?? null;
        $content = $data['content'] ?? null;
        $authorId = $data['authorId'] ?? null;
        $createdAt = $data['createdAt'] ?? null;

        $articleId = uniqid('', true);

        $author = $this->userRepository->find($authorId);
        if (!$author) 
        {
            throw new UserNotFoundException;
        }

        $article = new Article(
            $articleId,
            $title,
            $content,
            $author,
            $createdAt,
            null,
            $image,
            $description
        );

        $this->articleRepository->save($article);

        return $article;
    }

    public function updateArticle(array $data): void
    {
        $id = $data['id'] ?? null;
        $title = $data['title'] ?? null;
        $image = $data['image'] ?? null;
        $description = $data['description'] ?? null;
        $content = $data['content'] ?? null;
        $updatedAt = new \DateTime($data['updatedAt']) ?? null;

        $article = $this->getArticleData($id);

        $article->setTitle($title);
        $article->setImage($image);
        $article->setDescription($description);
        $article->setContent($content);
        $article->setUpdatedAt($updatedAt);

        $this->articleRepository->save($article);
    }

    public function deleteArticle(string $id): void
    {
        $article = $this->getArticleData($id);
        $this->articleRepository->save($article);
    }
}