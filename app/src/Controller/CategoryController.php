<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\CategoryData;
use App\Service\CategoryService;
use App\Exception\CategoryAlreadyExistException;
use App\Exception\CategoryNotFoundException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    use TraitController;

    /**
     * @Route("/api/category/list", methods={"GET"})
     */
    public function showCategoryList(CategoryService $categoryService): JsonResponse
    {
        $categories = $categoryService->getAllCategory();

        $data = [];
        foreach ($categories as $category) 
        {
            $data[] = new CategoryData($category->getId(), $category->getName());
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/category/create", methods={"POST"})
     */
    public function createCategory(Request $request, CategoryService $categoryService): JsonResponse
    {
        $data = $this->getRequest($request);
        $name = $data['name'] ?? null;

        if (empty($name)) 
        {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }

        try 
        {
            $category = $categoryService->createCategory($name);
            return new JsonResponse(['id' => $category->getId()], Response::HTTP_OK);
        } 
        catch (CategoryAlreadyExistException $e) 
        {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } 
        catch (Exception $e)
        {
            return new JsonResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @Route("/api/category/edit", methods={"POST"})
     */
    public function editCategory(Request $request, CategoryService $categoryService): JsonResponse
    {
        $data = $this->getRequest($request);
        $id = $data['id'] ?? null;
        $name = $data['name'] ?? null;

        if (empty($id) || empty($name)) 
        {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }

        try 
        {
            $categoryService->editCategory($id, $name);
            return new JsonResponse(null, Response::HTTP_OK);
        } 
        catch (CategoryNotFoundException $e) 
        {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } 
        catch (CategoryAlreadyExistException $e) 
        {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } 
        catch (Exception $e) 
        {
            return new JsonResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @Route("/api/category/delete", methods={"POST"})
     */
    public function deleteCategory(Request $request, CategoryService $categoryService): JsonResponse
    {
        $data = $this->getRequest($request);
        $id = $data['id'] ?? null;

        if (empty($id)) 
        {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }

        try 
        {
            $categoryService->deleteCategory($id);
            return new JsonResponse(null, Response::HTTP_OK);
        } 
        catch (CategoryNotFoundException $e) 
        {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
        catch (Exception $e) 
        {
            return new JsonResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }
}