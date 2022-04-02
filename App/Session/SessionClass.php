<?php

namespace App\Session;

class SessionClass {

    public string $email;
    public string $firstName;
    public string $lastName;
    public bool $isLoggedIn;
    public bool $showError;
    public string $errors;
    public string $userId;

    /**
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param bool $isLoggedIn
     * @param bool $showError
     * @param string $errors
     * @param string $userId
     */
    public function __construct(string $email = ".", string $firstName = ".", string $lastName = ".", bool $isLoggedIn = false, bool $showError = false, string $errors = ".", string $userId = ".")
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->isLoggedIn = $isLoggedIn;
        $this->showError = $showError;
        $this->errors = $errors;
        $this->userId = $userId;
    }


}