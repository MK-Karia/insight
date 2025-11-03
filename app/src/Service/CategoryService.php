<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Category;
use App\Exception\CategoryAlreadyExistException;
use App\Exception\CategoryNotFoundException;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategory(): array
    {
        return $this->categoryRepository->findAll();
    }

    public function createCategory(string $name): Category
    {
        $existing = $this->categoryRepository->findOneBy(['categoryName' => $name]);

        if ($existing !== null) 
        {
            throw new CategoryAlreadyExistException;
        }

        $category = new Category(uniqid('', true), $name);
        $this->categoryRepository->save($category);

        return $category;
    }

    public function updateCategory(string $id, string $name): void
    {
        $category = $this->categoryRepository->find($id);

        if ($category === null) 
        {
            throw new CategoryNotFoundException;
        }

        $existing = $this->categoryRepository->findOneBy(['categoryName' => $name]);

        if ($existing !== null && $existing->getId() !== $id) 
        {
            throw new CategoryAlreadyExistException;
        }

        $category->setName($name);
        $this->categoryRepository->save($category);
    }

    public function deleteCategory(string $id): void
    {
        $category = $this->categoryRepository->find($id);

        if ($category === null) 
        {
            throw new CategoryNotFoundException;
        }

        $this->categoryRepository->remove($category);
    }
}
