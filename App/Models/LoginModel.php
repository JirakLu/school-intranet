<?php

namespace App\Models;

use App\Models\User\UserFacade;
use App\Session;


class LoginModel
{

    private UserFacade $userFacade;

    public function __construct()
    {
        $this->userFacade = new UserFacade();
    }

    public function handleLogin(): bool
    {
        if (!isset($_POST["email"]) || !isset($_POST["password"])) {
            setError("Prosím vyplň všechny pole!");
            return false;
        }

        $user = $this->userFacade->getUserByEmail($_POST["email"]);

        if ($user) {
            $pepper = get_cfg_var("pepper");
            $psw_peppered = hash_hmac("sha256", $_POST["password"], $pepper);
            if (password_verify($psw_peppered, $user->getPassword())) {
                Session::set("email", $user->getEmail());
                Session::set("firstName", $user->getFirstName());
                Session::set("lastName", $user->getLastName());
                Session::set("userID", $user->getUserID());
                Session::set("isLoggedIn", true);

                cleanError();

                return true;
            } else {
                setError("Heslo nesedí.");
                return false;
            }
        } else {
            setError("Uživatel s tímto emailem neexistuje.");
            return false;
        }
    }

}