<?php

namespace Services;

use App\Models\User\UserEntity;
use App\Models\User\UserFacade;
use App\Session;

class AuthService {

    private UserFacade $userFacade;

    public function __construct()
    {
        $this->userFacade = new UserFacade();
    }

    public function handleAuth(string $email, string $password): bool
    {
        if (empty($email) || empty($password)) {
            setError("Prosím vyplň všechny pole.");
            return false;
        }

        $user = $this->userFacade->getUserByEmail($email);

        if ($user) {
            if (password_verify($password . getCfgVar("pepper"), $user->getPassword())) {
                $this->signInSuccess($user);
                return true;
            }
            setError("Heslo pro tento email nesedí.");
        } else {
            setError("Uživatel s tím emailem neexistuje.");
        }

        return false;
    }

    public function logout(): void
    {
        $this->userFacade->removeAuthCookie(Session::get("user_ID"));

        if (isset($_COOKIE['remember'])) {
            unset($_COOKIE['remember']);
            setcookie('remember', null, -1, '/');
        }

        Session::destroy();
    }

    public function setAuthCookie(): void
    {
        $this->userFacade->setAuthCookie(Session::get("user_ID"));
    }

    public function checkAuthCookie(string $cookie): void
    {
        $user = $this->userFacade->checkAuthCookie($cookie);

        if ($user) {
            $this->signInSuccess($user);
        }
    }

    private function signInSuccess(UserEntity $user): void
    {
        Session::set("isLoggedIn", true);
        Session::set("user_ID", $user->getUserID());
        Session::set("email", $user->getEmail());
        Session::set("lastName", $user->getFirstName());
        Session::set("firstName", $user->getLastName());
        Session::set("isTeacher", $this->userFacade->checkIfTeacher($user->getUserID()));
        $this->userFacade->updateUserLastLogin($user->getUserID());
        cleanError();
    }


}