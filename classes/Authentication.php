<?php

namespace Classes;

class Authentication
{
    public static $roleLevels = [
        'super_admin' => 3,
        'admin' => 2,
        'user' => 1,
        null => 0,
    ];

    public static function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function roleHasAccess($requiredRole)
    {
        $currentRole = $_SESSION['role'] ?? null;
        $bool = ((self::$roleLevels[$currentRole] ?? 0) >= (self::$roleLevels[$requiredRole] ?? 1));
        return $bool;
    }

    public static function requireAccess(string $requiredRole)
    {
        self::startSession();
        if (empty($_SESSION["user_id"]) || !self::roleHasAccess($requiredRole)) {
            header("location:/permission-not-granted");
            exit;
        }
        return self::$roleLevels[$_SESSION['role']];
    }

    public static function requireUser()
    {
        return self::requireAccess('user');
    }


    public static function requireSuperAdmin()
    {
        return self::requireAccess('super_admin');
    }

    public static function requireAdmin()
    {
        return self::requireAccess('admin');
    }

    public static function requirePostMethod()
    {
        self::startSession();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION["user_id"])) {
            header('location: /');
            exit;
        }
    }
}
