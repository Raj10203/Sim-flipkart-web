<?php
require_once('../../classes/Authentication.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Category.php');

use Classes\Category;
use Classes\Authentication;

Authentication::requirePostMethod();

$category = new Category();
$conn = $category->getConnection();
$tableName = $category->getTableName();
$columns = ['id', 'name', 'description'];

$start = $_POST['start'] ?? 0;
$search_value = $_POST['search']['value'] ?? "";
$order_column = $_POST['order'][0]['column'] ?? 0;
$order_dir = $_POST['order'][0]['dir'] ?? 'asc';

$sql_total = "SELECT COUNT(id) FROM $tableName";
$length = $_POST['length'] ?? $sql_total;
$result_total = $conn->query($sql_total);
$total_records = $result_total->fetch_row()[0];

$sql = "SELECT id, name, description FROM $tableName
        WHERE name LIKE '%$search_value%' OR description LIKE '%$search_value%' 
        ORDER BY " . $columns[$order_column] . " $order_dir 
        LIMIT $start, $length";
$result = $conn->query($sql);
$data = $result->fetch_all(MYSQLI_ASSOC);

$sql_filter = "SELECT COUNT(id) FROM $tableName 
        WHERE name LIKE '%$search_value%' OR description LIKE '%$search_value%'
        ORDER BY " . $columns[$order_column] . " $order_dir ;";
$filtered_records = $conn->query($sql_filter)->fetch_row()[0];

$response = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $total_records,
        "recordsFiltered" => $filtered_records,
        "data" => $data,
);
echo json_encode($response);
$conn->close();
