<pre><?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();
require_once('../../conf/db_connection.php');
require_once('../../classes/User.php');
use Mysql_php\Classes\User;

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $user = new User($conn);

    $email = test_input($_POST['email']);
    $password = hash("sha256", $_POST['password']);

    $dbPass = $user->getPasswordOfSingleUser($email);   
    echo $password . "\n db pass : " . $dbPass;
    if ($password == $dbPass) {
        $_SESSION['email'] = "email";
        header('location: /admin/pages/');
    } else {
        $_SESSION['invalid-credentials'] = 'Incorrenct credentials';
        echo  $_SESSION['invalid-credentials'];
        header('location: /admin/pages/login.php');
    }
}

?></pre>