<?php

use Classes\Order;

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Order.php');

$ord = new Order();
$conn = $ord->getConnection();
$columns = ["o.id", "u.first_name", "o.status", "o.total_products", "o.total_price", "o.payment_id", "o.user_id"];

$searchValue = isset($_POST['search']['value']) ? mysqli_real_escape_string($conn, $_POST['search']['value']) : '';
$start = $_POST['start'] ?? 0;
$length = $_POST['length'] ?? 10;
$orderColumn = $_POST['order'][0]['column'] ?? 0;
$orderDir = $_POST['order'][0]['dir'] ?? 'asc';
$orderColumnName = $columns[$orderColumn] ?? 'o.id';

$totalRecords = $conn->query("SELECT COUNT(o.id) FROM orders o")->fetch_row()[0];
$baseSql = " FROM orders o
             JOIN users u ON o.user_id = u.id 
             WHERE 1=1";

$searchSql = '';
if (!empty($searchValue)) {
    $searchSql = " AND (o.total_products LIKE '%$searchValue%' 
                    OR o.status LIKE '%$searchValue%' 
                    OR o.id LIKE '%$searchValue%' 
                    OR o.total_price LIKE '%$searchValue%'  
                    OR o.payment_id LIKE '%$searchValue%'  
                    OR u.first_name LIKE '%$searchValue%')";
}

$columnSearchSql = '';
if (!empty($_POST['columns'])) {
    foreach ($_POST['columns'] as $index => $col) {
        if (!empty($col['search']['value'])) {
            $colValue = mysqli_real_escape_string($conn, $col['search']['value']);
            $columnName = $columns[$index];
            $conditions = array_map(fn($value) => "$columnName = '$value'", explode('|', $colValue));
            $columnSearchSql .= " AND (" . implode(" OR ", $conditions) . ")";
        }
    }
}

$sql = "SELECT o.id, u.first_name, o.status, o.total_products, o.total_price, o.payment_id, o.user_id 
        $baseSql $searchSql $columnSearchSql
        ORDER BY $orderColumnName $orderDir 
        LIMIT $start, $length";
$result = $conn->query($sql);
$data = $result->fetch_all(MYSQLI_ASSOC);

$sqlFilter = "SELECT COUNT(o.id) $baseSql $searchSql $columnSearchSql";
$filteredRecords = $conn->query($sqlFilter)->fetch_row()[0];

echo json_encode([
    "draw" => intval($_POST['draw']),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $filteredRecords,
    "data" => $data,
]);
$conn->close();
