<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
use Classes\Category;

require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Category.php');

$cat = new Category();
$categories = $cat->getAllItems($cat->getTableName());
echo json_encode($categories);
