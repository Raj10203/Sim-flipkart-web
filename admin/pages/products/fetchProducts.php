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

$columns = [ "p.id", "p.name", "p.image_path", "p.description", "p.price", "category_name", "p.category_id"];

$columnSearch = $_POST['columns'];
$searchValue = $_POST['search']['value'] ?? '';
$start = $_POST['start'] ?? 0;
$length = $_POST['length'] ?? 10;
$orderColumn = $_POST['order'][0]['column'] ?? 0;
$orderDir = $_POST['order'][0]['dir'] ?? 'asc';

$sql_total = "SELECT COUNT(p.id) FROM products p";
$totalRecords = $conn->query($sql_total)->fetch_row()[0];

$sql = "SELECT p.id, p.name, p.image_path, p.description, p.price, c.name AS category_name , p.category_id FROM products p 
        JOIN categories c ON p.category_id = c.id WHERE (1=1)";

if (!empty($searchValue)) {
    $searchValue = mysqli_real_escape_string($conn, $searchValue);
    $sql .= " AND (
                p.name LIKE '%$searchValue%' 
                OR p.description LIKE '%$searchValue%' 
                OR p.id LIKE '%$searchValue%' 
                OR p.price LIKE '%$searchValue%' 
                OR c.name LIKE '%$searchValue%'
            )";
}

foreach ($columnSearch as $index => $col) {
    if (!empty($col['search']['value'])) {
        $colValue =  $col['search']['value'];
        $columnName = $columns[$index];
        if ($columnName == "category_name") {
            $sql .= " AND p.category_id = $colValue";
        } else {
            $sql .= " AND $columnName LIKE '%$colValue%'";
        }
    }
}

$orderColumnName = $columns[$orderColumn] ?? 'p.id';
$sql .= " ORDER BY $orderColumnName $orderDir LIMIT $start, $length";

$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
    $row['DT_RowId'] = 'row_' . $row['id'];
    $data[] = $row;
}

$sqlFilter = "SELECT COUNT(p.id) FROM products p 
              JOIN categories c ON p.category_id = c.id WHERE (1=1)";

if (!empty($searchValue)) {
    $sqlFilter .= " AND (
                    p.name LIKE '%$searchValue%' 
                    OR p.description LIKE '%$searchValue%' 
                    OR p.id LIKE '%$searchValue%' 
                    OR p.price LIKE '%$searchValue%' 
                    OR c.name LIKE '%$searchValue%'
                )";
}

foreach ($columnSearch as $index => $col) {
    if (!empty($col['search']['value'])) {
        $colValue = mysqli_real_escape_string($conn, $col['search']['value']);
        $columnName = $columns[$index];

        if ($columnName == "category_name") {
            $sqlFilter .= " AND p.category_id = $colValue";
        } else {
            $sqlFilter .= " AND $columnName LIKE '%$colValue%'";
        }
    }
}

$filteredRecords = $conn->query($sqlFilter)->fetch_row()[0];

echo json_encode([
    "draw" => intval($_POST['draw']),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $filteredRecords,
    "data" => $data,
    "sql" => $sql,
    "columnName" => $columnName ?? "",
    "colValue" => $colValue ?? "",
    "orderColumn" => $orderColumn ?? ""
]);

$conn->close();
