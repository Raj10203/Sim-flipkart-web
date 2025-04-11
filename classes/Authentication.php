<?php

namespace Classes;

class Authentication
{

    public static function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function roleHasAccess($requiredRole)
    {
        $currentRole = $_SESSION['role'] ?? null;
        $roleLevels = [
            'super_admin' => 3,
            'admin' => 2,
            'user' => 1,
            null => 0,
        ];
        return $roleLevels[$currentRole] >= $roleLevels[$requiredRole];
    }

    public static function requireUser()
    {
        self::startSession();
        if (empty($_SESSION["user_id"]) || !self::roleHasAccess('user')) {
            header("location:/login");
            exit;
        }
    }

    public static function requireAdmin()
    {
        self::startSession();
        if (empty($_SESSION["user_id"]) || !self::roleHasAccess('admin')) {
            header("location:/");
            exit;
        }
    }

    public static function requireSuperAdmin()
    {
        self::startSession();
        if (empty($_SESSION["user_id"]) || !self::roleHasAccess('super_admin')) {
            header("location:/");
            exit;
        }
    }

    public static function requirePostMethod()
    {
        self::startSession();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !empty($_SESSION["user_id"])) {
            header('location: /');
            exit;
        }
    }
}
