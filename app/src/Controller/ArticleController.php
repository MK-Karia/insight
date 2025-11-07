<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\ArticleNotFoundException;
use App\Exception\UserNotFoundException;
use App\Service\ArticleService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    use TraitController;

    /**
     * @Route("/api/acticle/list", methods={"GET"})
     */
    public function showArticleList(ArticleService $articleService): JsonResponse
    {
        $articles = $articleService->listArticles();

        return new JsonResponse($articles, Response::HTTP_OK);
    }

    /**
     * @Route("/api/acticle/{id}", methods={"GET"})
     */
    public function showArticle(string $id, ArticleService $articleService): JsonResponse
    {
        try 
        {
            $article = $articleService->getArticle($id);
            return new JsonResponse($article, Response::HTTP_OK);
        }
        catch (ArticleNotFoundException $e) 
        {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } 
        catch (Exception $e)
        {
            return new JsonResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @Route("/api/acticle/create", methods={"POST"})
     */
    public function createArticle(Request $request, ArticleService $articleService): JsonResponse
    {
        $data = $this->getRequest($request);

        if (!$this->validateNewArticleData($data)) 
        {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }

        try 
        {
            $article = $articleService->createArticle($data);
            return new JsonResponse(['id' => $article->getId()], Response::HTTP_OK);
        } 
        catch (UserNotFoundException $e) 
        {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } 
        catch (Exception $e)
        {
            return new JsonResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @Route("/api/acticle/edit", methods={"POST"})
     */
    public function updateArticle(Request $request, ArticleService $articleService): JsonResponse
    {
        $data = $this->getRequest($request);

        if (!$this->validateUpdateArticleData($data)) 
        {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }
        try 
        {
            $articleService->updateArticle($data);
            return new JsonResponse(null, Response::HTTP_OK);
        } 
        catch (ArticleNotFoundException $e) 
        {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } 
        catch (Exception $e)
        {
            return new JsonResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @Route("/api/acticle/delete", methods={"POST"})
     */
    public function deleteArticle(Request $request, ArticleService $articleService): JsonResponse
    {
        $data = $this->getRequest($request);
        $id = $data['id'] ?? null;

        if (empty($id)) 
        {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }

        try 
        {
            $articleService->deleteArticle($id);
            return new JsonResponse(null, Response::HTTP_OK);
        } 
        catch (ArticleNotFoundException $e) 
        {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
        catch (Exception $e) 
        {
            return new JsonResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    private function validateNewArticleData(array $data): bool 
    {
        $title = $data['title'] ?? null;
        $image = $data['image'] ?? null;
        $content = $data['content'] ?? null;
        $authorId = $data['authorId'] ?? null;
        $createdAt = $data['createdAt'] ?? null;

        if (empty($title) || empty($image) || empty($content) || empty($authorId) || empty($createdAt) )
        {
            return false;
        }

        return true;
    }

    private function validateUpdateArticleData(array $data): bool 
    {
        $id = $data['id'] ?? null;
        $title = $data['title'] ?? null;
        $image = $data['image'] ?? null;
        $content = $data['content'] ?? null;
        $updatedAt = $data['updatedAt'] ?? null;

        if (empty($id) || empty($title) || empty($image) || empty($content) || empty($updatedAt) )
        {
            return false;
        }

        return true;
    }
}