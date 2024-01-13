<?php

namespace Framework\Authentication;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;

class Auth
{
    /** Get the id of the logged in user */
    public static function id(): ?int
    {
        return Session::getValue('userId');
    }

    /** Check if the user is logged in */
    public static function isLoggedIn(): bool
    {
        return self::id() !== null;
    }

    /** Check if the current user has the requested role */
    public static function hasRole(string $role): bool
    {
        if (self::id() === null) {
            return false;
        }

        return self::userHasRole(self::id(), $role);
    }

    /** Check if the given user has the requested role */
    public static function userHasRole(int $userId, string $role): bool
    {
        $role = Role::findByName($role);
        if ($role->getId() === null) {
            return false;
        }

        $userRole = UserRole::findByUserAndRoleId($userId, $role->getId());
        if ($userRole->getId() === null) {
            return false;
        }

        return true;
    }

    /** Check if the given password for the given user */
    public static function isPasswordValid(string $username, string $password): bool
    {
        $user = User::findByUsername($username);

        // Return false if the password is not set
        if ($user->getPassword() === null) {
            return false;
        }

        // Verify the password
        return password_verify($password, $user->getPassword());
    }

    /** Hash the given password */
    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}