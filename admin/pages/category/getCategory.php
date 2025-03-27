<?php
require_once('../../classes/Category.php');
require_once('../../classes/Database.php');
use Admin\Classes\Database;
use Admin\Classes\Category;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$db = new Database;
$category = new Category($db);
$id = $_POST['id'];
echo json_encode($category->getCategoryById($id));
