<?php

namespace App\Models\User;

class UserFacade {

    private UserRepository $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    public function getUserByEmail(string $email): UserEntity|bool
    {
        return $this->userRepo->getUserByEmail($email);
    }

}