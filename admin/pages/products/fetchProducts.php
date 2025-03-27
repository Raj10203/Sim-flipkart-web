<?php
include_once('../../conf/backend_authenticate.php');
require_once('../../classes/Database.php');
require_once('../../classes/Product.php');
use Admin\Classes\Database;
use Admin\Classes\Product;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$db = new Database;
$prod = new Product($db);
$conn = $prod->getConnection();
$tableName = $prod->getTableName();

$columns = [];
$result_columns = $conn->query("SHOW COLUMNS FROM $tableName");
while ($row = $result_columns->fetch_assoc()) {
    $columns[] = $row['Field'];
}

$start = $_POST['start'] ?? 0;
$search_value = $_POST['search']['value'] ?? "";
$order_column = $_POST['order'][0]['column'] ?? 0;
$order_dir = $_POST['order'][0]['dir'] ?? 'asc';

$sql_total = "SELECT COUNT(id) FROM $tableName";
$length = $_POST['length'] ?? $sql_total;
$result_total = $conn->query($sql_total);
$total_records = $result_total->fetch_row()[0];

$sql = "SELECT p.*, c.name as category_name FROM products p JOIN categories c  ON p.category_id = c.id
        WHERE p.name LIKE '%$search_value%' OR p.description LIKE '%$search_value%' OR p.id LIKE '%$search_value%' OR p.price LIKE '%$search_value%' OR c.name LIKE '%$search_value%'
        ORDER BY " . $columns[$order_column] . " $order_dir 
        LIMIT $start, $length";

$result = $conn->query($sql);

$sql_filter = "SELECT COUNT(id) FROM $tableName 
        WHERE name LIKE '%$search_value%' OR description LIKE '%$search_value%'
        ORDER BY " . $columns[$order_column] . " $order_dir ;";
        
$filtered_records = $conn->query($sql_filter)->fetch_row()[0];

$data = array();
while ($row = $result->fetch_assoc()) {
    $row['DT_RowId'] = 'row_' . $row['id'];
    $data[] = $row;
}

$response = array(
    "draw" => $_POST['draw'],
    "recordsTotal" => $total_records,
    "recordsFiltered" => $filtered_records,
    "data" => $data,
);

echo json_encode($response);

$conn->close();
