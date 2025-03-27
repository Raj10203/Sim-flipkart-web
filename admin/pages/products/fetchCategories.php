<?php
require_once('../../classes/Database.php');
require_once('../../classes/Category.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Admin\Classes\Category;
use Admin\Classes\Database;
$db = new Database();
$category = new Category($db);
$categories = $category->getAllCategories();
echo json_encode($categories);
?>