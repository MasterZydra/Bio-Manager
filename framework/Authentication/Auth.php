<?php

namespace Framework\Authentication;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Framework\Facades\Http;

class Auth
{
    /** Caches the user role assignments the duration of one request */
    private static array $roleCache = [];

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

    /** Check if the current user has one of the given roles otherwise redirect to home */
    public static function checkRoles(array $roles): void
    {
        $match = false;

        foreach ($roles as $role) {
            $match = $match || self::hasRole($role);
        }

        if (!$match) {
            Http::redirect('/');
        }
    }

    /** Check if the current user has the given role otherwise redirect to home */
    public static function checkRole(string $role): void
    {
        if (!self::hasRole($role)) {
            Http::redirect('/');
        }
    }

    /** Check if the current user has the requested role */
    public static function hasRole(string $role): bool
    {
        if (!self::isLoggedIn()) {
            return false;
        }

        return self::userHasRole(self::id(), $role);
    }

    /** Check if the given user has the requested role */
    public static function userHasRole(int $userId, string $role): bool
    {
        // Check if the role and userId combination is already in the cache
        $cacheKey = $role . '-' . strval($userId);
        if (in_array($cacheKey, self::$roleCache, true)) {
            return self::$roleCache[$cacheKey];
        }

        $role = Role::findByName($role);
        if ($role->getId() === null) {
            self::$roleCache[$cacheKey] = false;
            return false;
        }

        $userRole = UserRole::findByUserAndRoleId($userId, $role->getId());
        if ($userRole->getId() === null) {
            self::$roleCache[$cacheKey] = false;
            return false;
        }

        self::$roleCache[$cacheKey] = true;
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