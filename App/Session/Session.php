<?php

namespace App\Session;

/**
 * @param string $email
 * @param string $firstName
 * @param string $lastName
 * @param bool $isLoggedIn
 * @param bool $showError
 * @param string $errors
 * @param string $userId
 */

class Session {

    public static function start(): void
    {
        session_start();

        if (!isset($_SESSION["appInfo"])) {
            $_SESSION["appInfo"] = serialize(new SessionClass());
        }
    }

    public static function setEmail(string $email): void
    {
        $session = unserialize($_SESSION["appInfo"]);
        $session->email = $email;
        $_SESSION["appInfo"] = serialize($session);
    }

    public static function getEmail(): string
    {
        $session = unserialize($_SESSION["appInfo"]);
        return $session->email;
    }

    public static function setFirstName(string $firstName): void
    {
        $session = unserialize($_SESSION["appInfo"]);
        $session->firstName = $firstName;
        $_SESSION["appInfo"] = serialize($session);
    }

    public static function getFirstName(): string
    {
        $session = unserialize($_SESSION["appInfo"]);
        return $session->firstName;
    }

    public static function setLastName(string $lastName): void
    {
        $session = unserialize($_SESSION["appInfo"]);
        $session->lastName = $lastName;
        $_SESSION["appInfo"] = serialize($session);
    }

    public static function getLastName(): string
    {
        $session = unserialize($_SESSION["appInfo"]);
        return $session->lastName;
    }

    public static function setIsLoggedIn(bool $isLoggedIn): void
    {
        $session = unserialize($_SESSION["appInfo"]);
        $session->isLoggedIn = $isLoggedIn;
        $_SESSION["appInfo"] = serialize($session);
    }

    public static function getIsLoggedIn(): bool
    {
        $session = unserialize($_SESSION["appInfo"]);
        return $session->isLoggedIn;
    }

    public static function setShowError(bool $showError): void
    {
        $session = unserialize($_SESSION["appInfo"]);
        $session->showError = $showError;
        $_SESSION["appInfo"] = serialize($session);
    }

    public static function getShowError(): bool
    {
        $session = unserialize($_SESSION["appInfo"]);
        return $session->showError;
    }

    public static function setErrors(string $errors): void
    {
        $session = unserialize($_SESSION["appInfo"]);
        $session->errors = $errors;
        $_SESSION["appInfo"] = serialize($session);
    }

    public static function getErrors(): string
    {
        $session = unserialize($_SESSION["appInfo"]);
        return $session->errors;
    }

    public static function setUserID(string $userID): void
    {
        $session = unserialize($_SESSION["appInfo"]);
        $session->userID = $userID;
        $_SESSION["appInfo"] = serialize($session);
    }

    public static function getUserID(): string
    {
        $session = unserialize($_SESSION["appInfo"]);
        return $session->userID;
    }

}