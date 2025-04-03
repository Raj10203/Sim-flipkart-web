<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Category.php');

use Admin\Classes\Category;
use Admin\Classes\Database;

$db = new Database();
$cat = new Category($db);
$categories = $cat->getAllItems($cat->getTableName());
echo json_encode($categories);
