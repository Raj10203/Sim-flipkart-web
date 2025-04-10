<?php

use Classes\Product;

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/Product.php');

$prod = new Product();
$conn = $prod->getConnection();
// $columns = ["p.id", "p.name", "p.image_path", "p.description", "p.price", "p.discount", "c.name", "p.category_id"];

$searchValue = isset($_POST['search']['value']) ? mysqli_real_escape_string($conn, $_POST['search']['value']) : '';
$start = $_POST['start'] ?? 0;
$length = $_POST['length'] ?? 10;
$orderColumn = $_POST['order'][0]['column'] ?? 0;
$orderDir = $_POST['order'][0]['dir'] ?? 'asc';
$orderColumnName = $columns[$orderColumn] ?? 'p.id';

$totalRecords = $conn->query("SELECT COUNT(p.id) FROM products p")->fetch_row()[0];
$baseSql = " FROM products p 
             JOIN categories c ON p.category_id = c.id 
             WHERE 1=1";

$searchSql = '';
if (!empty($searchValue)) {
    $searchSql = " AND (p.name LIKE '%$searchValue%' 
                    OR p.description LIKE '%$searchValue%' 
                    OR p.id LIKE '%$searchValue%' 
                    OR p.price LIKE '%$searchValue%' 
                    OR p.discount LIKE '%$searchValue%' 
                    OR c.name LIKE '%$searchValue%')";
}

$columnSearchSql = '';
if (!empty($_POST['columns'])) {
    foreach ($_POST['columns'] as $index => $col) {
        if (!empty($col['search']['value'])) {
            $colValue = mysqli_real_escape_string($conn, $col['search']['value']);
            $columnName = ($columns[$index] === "c.name") ? "c.name" : $columns[$index];
            $conditions = array_map(fn($value) => "$columnName = '$value'", explode('|', $colValue));
            $columnSearchSql .= " AND (" . implode(" OR ", $conditions) . ")";
        }
    }
}

$sql = "SELECT p.id, p.name, p.image_path, p.description, p.price, p.discount, c.name AS category_name, p.category_id 
        $baseSql $searchSql $columnSearchSql
        ORDER BY $orderColumnName $orderDir 
        LIMIT $start, $length";
$result = $conn->query($sql);
$data = $result->fetch_all(MYSQLI_ASSOC);

$sqlFilter = "SELECT COUNT(p.id) $baseSql $searchSql $columnSearchSql";
$filteredRecords = $conn->query($sqlFilter)->fetch_row()[0];

echo json_encode([
    "draw" => intval($_POST['draw']),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $filteredRecords,
    "data" => $data,
]);
$conn->close();
