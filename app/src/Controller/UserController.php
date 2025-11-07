<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\UserProfileData;
use App\Service\UserService;
use App\Exception\UserAlreadyExistException;
use App\Exception\UserNotFoundException;
use App\Exception\RoleNotFoundException;
use App\Service\AuthorData;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    use TraitController;
    
    /**
     * @Route("/api/user/list", methods={"GET"})
     */
    public function showUserList(UserService $userService): JsonResponse
    {
        $users = $userService->listUsers();
        $data = $this->createUserListData($users);

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/user/{id}", methods={"GET"})
     */
    public function showUserProfile(string $id, UserService $userService): JsonResponse
    {
        try 
        {
            $user = $userService->getUser($id);
            $userProfile = $this->createUserProfileData($user);
            return new JsonResponse($userProfile, Response::HTTP_OK);
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
     * @Route("/api/author/list", methods={"GET"})
     */
    public function showAuthorList(string $id, UserService $userService): JsonResponse
    {
        $authors = $userService->listAuthors();
        $data = $this->createAuthorListData($authors);

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/user/create", methods={"POST"})
     */
    public function createUser(Request $request, UserService $userService): JsonResponse
    {
        $data = $this->getRequest($request);

        if (!$this->validateNewUserData($data)) 
        {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }

        try 
        {
            $user = $userService->createUser($data);
            return new JsonResponse(['id' => $user->getId()], Response::HTTP_OK);
        } 
        catch (UserAlreadyExistException $e) 
        {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } 
        catch (Exception $e)
        {
            return new JsonResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @Route("/api/user/edit", methods={"POST"})
     */
    public function updateUser(Request $request, UserService $userService): JsonResponse
    {
        $data = $this->getRequest($request);

        if (!$this->validateUpdateUserData($data)) 
        {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }

        try 
        {
            $userService->updateUser($data);
            return new JsonResponse(null, Response::HTTP_OK);
        } 
        catch (UserNotFoundException $e) 
        {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } 
        catch (UserAlreadyExistException $e) 
        {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } 
        catch (Exception $e)
        {
            return new JsonResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @Route("/api/user/delete", methods={"POST"})
     */
    public function deleteUser(Request $request, UserService $userService): JsonResponse
    {
        $data = $this->getRequest($request);
        $id = $data['id'] ?? null;

        if (empty($id)) 
        {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }

        try 
        {
            $userService->deleteUser($id);
            return new JsonResponse(null, Response::HTTP_OK);
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
     * @Route("/api/user/role/change", methods={"POST"})
     */
    public function changeUserRole(Request $request, UserService $userService): JsonResponse
    {
        $data = $this->getRequest($request);
        $userId = $data['userId'] ?? null;
        $roleId = $data['roleId'] ?? null;

        if (empty($userId) || empty($roleId)) 
        {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }

        try 
        {
            $userService->changeUserRole($userId, $roleId);
            return new JsonResponse(null, Response::HTTP_OK);
        } 
        catch (UserNotFoundException $e) 
        {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
        catch (RoleNotFoundException $e) 
        {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
        catch (Exception $e) 
        {
            return new JsonResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    private function validateNewUserData(array $data): bool 
    {
        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $date = $data['birthdate'] ?? null;
        $password = $data['password'] ?? null;

        if (empty($name) || empty($email) || empty($date) || empty($password)) 
        {
            return false;
        }

        return true;
    }

    private function validateUpdateUserData(array $data): bool
    {
        $id = $data['id'] ?? null;
        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $date = $data['birthdate'] ?? null;

        if (empty($id) || empty($name) || empty($email) || empty($date)) 
        {
            return false;
        }

        return true;
    }

    private function createUserListData(array $users) 
    {
        $data = [];
        
        foreach ($users as $user) 
        {
            $data[] = $this->createUserProfileData($user);
        }

        return $data;
    }

    private function createUserProfileData(User $user): UserProfileData
    {
        $data = new UserProfileData(
            $user->getId(), 
            $user->getName(),
            null,
            $user->getBirthdate(),
            $user->getRole(),
            $user->getAvatar()
        );

        return $data;
    }

    private function createAuthorListData(array $authors)
    {
        $data = [];
        
        foreach ($authors as $author) 
        {
            $data[] = new AuthorData(
                $author->getId(), 
                $author->getName(),
                $author->getAvatar()
            );
        }

        return $data;
    }
}