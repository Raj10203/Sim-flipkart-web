<?php
require_once('../../classes/Category.php');

use Classes\Category;

$cat = new Category();
$categories = $cat->getAllItems($cat->getTableName());
echo json_encode($categories);
