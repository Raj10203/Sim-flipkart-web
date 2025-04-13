<?php

use Classes\Category;

require_once('../../classes/Category.php');

$cat = new Category();

if (!isset($_POST['id'])) {
    echo json_encode([
        "error" => "Id is required",
        "message" => 'id is required to delete category'
    ]);
    die;
}
echo json_encode($cat->getItemById($cat->getTableName(), $_POST['id']));
