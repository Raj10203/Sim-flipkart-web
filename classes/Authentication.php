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
    public static function requireLogin()
    {
        self::startSession();
        if (!empty($_SESSION["user_id"]) && $_SESSION["role"] != "user") {
            header("location:/login");
            exit;
        }
    }

    public static function requireAdmin()
    {
        self::startSession();
        if (!empty($_SESSION["user_id"]) && $_SESSION["role"] != "admin") {
            header("location:/");
            exit;
        }
    }

    public static function requireSuperAdmin()
    {
        self::startSession();
        if (!empty($_SESSION["user_id"]) && $_SESSION["role"] != "super_admin") {
            header("location:/");
            exit;
        }
    }

    public static function requirePostMethod()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('location: /');
            exit;
        }
    }
}
