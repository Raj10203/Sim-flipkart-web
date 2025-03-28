<?php
require_once('../../classes/Database.php');
use Admin\Classes\Database;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$db = new Database;
$conn = $db->connect();

$columns = array(
    0 => 'id', 
    1 => 'name',  
    2 => 'description', 
);

$start = $_POST['start'] ?? 0;  
$search_value = $_POST['search']['value'] ?? "";  
$order_column = $_POST['order'][0]['column'] ?? 0;
$order_dir = $_POST['order'][0]['dir'] ?? 'asc';  

$sql_total = "SELECT COUNT(id) FROM category";  
$length = $_POST['length'] ?? $sql_total;  
$result_total = $conn->query($sql_total);
$total_records = $result_total->fetch_row()[0];

$sql = "SELECT id, name, description FROM category
        WHERE name LIKE '%$search_value%' OR description LIKE '%$search_value%' 
        ORDER BY " . $columns[$order_column] . " $order_dir 
        LIMIT $start, $length";

$result = $conn->query($sql);

$sql_filter = "SELECT COUNT(id) FROM category 
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
