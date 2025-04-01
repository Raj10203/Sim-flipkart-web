<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once('../../classes/Database.php');
require_once('../../classes/Category.php');
use Admin\Classes\Database;
use Admin\Classes\Category;

$db = new Database;
$cat = new Category($db);
$id = $_POST['id'];
echo json_encode($cat->getItemById($cat->getTableName(),$id));