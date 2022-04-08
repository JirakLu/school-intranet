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

    public function updateUserLastLogin(string $id): void
    {
        $this->userRepo->updateUserLastLogin($id);
    }

    public function setAuthCookie(string $id): void
    {
        $selector = base64_encode(random_bytes(9));
        $authenticator = random_bytes(33);

        setcookie(
            'remember',
            $selector.':'.base64_encode($authenticator),
            time() + 864000,
            "/",
        );

        $this->userRepo->setUserAuthCookie($id, $selector, hash("sha256", $authenticator));
    }

    public function checkAuthCookie(string $cookie): UserEntity|null
    {
        list($selector, $authenticator) = explode(':', $cookie);

        $user = $this->userRepo->getUserBySelector($selector);

        if (!$user) return null;

        if (hash_equals($user->getAuthCookie(), hash("sha256", base64_decode($authenticator)))) {
            return $user;
        }

        return null;
    }

}