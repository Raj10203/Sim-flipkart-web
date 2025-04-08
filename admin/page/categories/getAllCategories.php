<?php

use Admin\Classes\Category;

require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Category.php');

$cat = new Category();
$categories = $cat->getAllItems($cat->getTableName());
echo json_encode($categories);
