<?php

namespace App\Models\User;

class UserEntity {

    private string $userID;
    private string $email;
    private string $password;
    private string $firstName;
    private string $lastName;
    private string|null $authCookie;
    private string|null $lastLoginDate;

    /**
     * @return string
     */
    public function getUserID(): string
    {
        return $this->userID;
    }

    /**
     * @param string $userID
     */
    public function setUserID(string $userID): void
    {
        $this->userID = $userID;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string|null
     */
    public function getAuthCookie(): ?string
    {
        return $this->authCookie;
    }

    /**
     * @param string|null $authCookie
     */
    public function setAuthCookie(?string $authCookie): void
    {
        $this->authCookie = $authCookie;
    }

    /**
     * @return string|null
     */
    public function getLastLoginDate(): ?string
    {
        return $this->lastLoginDate;
    }

    /**
     * @param string|null $lastLoginDate
     */
    public function setLastLoginDate(?string $lastLoginDate): void
    {
        $this->lastLoginDate = $lastLoginDate;
    }



    public function getWholeName(): string
    {
        return "$this->firstName  $this->lastName";
    }

}