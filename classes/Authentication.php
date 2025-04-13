<?php

namespace Classes;

require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/Database.php";

class Authentication
{
    private static $roleLevels = [
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

    public static function roleHasAccess(string $requiredRole)
    {
        $currentRole = $_SESSION['role'] ?? null;
        return (self::$roleLevels[$currentRole] ?? 0) >= (self::$roleLevels[$requiredRole] ?? 1);
    }

    public static function requireAccess(string $requiredRole)
    {
        if (!self::validateSession()) {
            session_unset();
            session_destroy();
            header("location:/login");
            exit;
        }
        if (!self::roleHasAccess($requiredRole)) {
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

    private static function validateSession()
    {
        self::startSession();
        if (!empty($_SESSION['user_id'])) {
            $conn = Database::getInstance()->getConnection();
            $query = "SELECT session_version FROM users WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $stmt->bind_result($dbSessionVersion);
            $stmt->fetch();
            $stmt->close();
            if (($_SESSION['session_version'] ?? -1) === $dbSessionVersion) {
                return true;
            }
        }
        return false;
    }

    public static function requirePostMethod(bool $signInRequired = true)
    {
        self::startSession();
        if (!self::validateSession()) {
            session_unset();
            session_destroy();
            echo json_encode([
                'success' => false,
                'error' => 'session_expired',
                'redirect' => '/login',
            ]);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $signInRequired) {
            header('location: /login');
            exit;
        }
    }
}
