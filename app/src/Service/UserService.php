<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Entity\Role;
use App\Exception\RoleNotFoundException;
use App\Exception\UserNotFoundException;
use App\Exception\UserAlreadyExistException;
use App\Repository\UserRepository;
use App\Repository\RoleRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserService
{
    private UserRepository $userRepository;
    private RoleRepository $roleRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function listUsers(): array
    {
        return $this->userRepository->findAll();
    }

    // TODO 
    public function listAuthors(): array
    {
        return $this->userRepository->findAuthors();
    }

    public function getUser(string $id): User
    {
        $user = $this->userRepository->find($id);

        if (!$user) 
        {
            throw new UserNotFoundException;
        }

        return $user;
    }

    public function createUser(array $data): User
    {
        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $date = $data['birthdate'] ?? null;
        $password = $data['password'] ?? null;
        $avatar = $data['avatar'] ?? null;

        if ($this->userRepository->findByEmail($email)) 
        {
            throw new BadRequestHttpException('USER_ALREADY_EXIST');
        }

        $userId = uniqid('', true);
        $role = $this->roleRepository->findOneBy(['roleName' => 'USER']);

        if (!$role) 
        {
            throw new RoleNotFoundException;
        }

        $birthdate = new \DateTime($date);

        $user = new User(
            $userId,
            $name,
            $email,
            $birthdate,
            password_hash($password, PASSWORD_DEFAULT),
            $role,
            $avatar ?? null
        );

        $this->userRepository->save($user);

        return $user;
    }

    public function updateUser(array $data): void
    {
        $id = $data['id'] ?? null;
        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $date = $data['birthdate'] ?? null;
        $avatar = $data['avatar'] ?? null;

        $user = $this->getUser($id);
        $existing = $this->userRepository->findOneBy(['email' => $email]);
        if ($existing !== null && $existing->getId() !== $id) 
        {
            throw new UserAlreadyExistException;
        }

        $user->setName($name);
        $user->setEmail($email);
        $user->setBirthdate($date);
        $user->setAvatar($avatar);

        $this->userRepository->save($user);
    }

    public function deleteUser(string $id): void
    {
        $user = $this->getUser($id);
        $this->userRepository->remove($user);
    }

    public function changeUserRole(string $userId, string $roleId): void
    {
        $user = $this->getUser($userId);
        $role = $this->roleRepository->find($roleId);

        if (!$role) 
        {
            throw new RoleNotFoundException;
        }

        $user->setRole($role);
        $this->userRepository->save($user);
    }
}
