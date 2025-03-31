<?php
require_once('../../classes/Database.php');
require_once('../../classes/Category.php');
use Admin\Classes\Database;
use Admin\Classes\Category;


$db = new Database;
$category = new Category($db);
$id = $_POST['id'];
echo json_encode($category->getCategoryById($id));