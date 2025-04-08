<?php

use Admin\Classes\Category;

require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Category.php');

$cat = new Category();
$id = $_POST['id'];
echo json_encode($cat->getItemById($cat->getTableName(), $id));
