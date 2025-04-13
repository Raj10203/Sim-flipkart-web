<?php
require '../../classes/Authentication.php';
require_once('../../classes/User.php');

use Classes\User;
use Classes\Authentication;

Authentication::requirePostMethod();

$usr = new User();
$conn = $usr->getConnection();
$columns = array(
    0 => 'id',
    1 => 'first_name',
    2 => 'last_name',
    3 => 'role',
    4 => 'email',
    5 => 'created_at',
);

$searchValue = isset($_POST['search']['value']) ? mysqli_real_escape_string($conn, $_POST['search']['value']) : '';
$start = $_POST['start'] ?? 0;
$length = $_POST['length'] ?? 10;
$orderColumn = $_POST['order'][0]['column'] ?? 0;
$orderDir = $_POST['order'][0]['dir'] ?? 'asc';
$orderColumnName = $columns[$orderColumn];

$totalRecords = $conn->query("SELECT COUNT(id) FROM users")->fetch_row()[0];
$baseSql = " FROM users WHERE 1=1";

$searchSql = '';
if (!empty($searchValue)) {
    $searchSql = " AND (id LIKE '%$searchValue%' 
                    OR first_name LIKE '%$searchValue%' 
                    OR last_name LIKE '%$searchValue%' 
                    OR role LIKE '%$searchValue%' 
                    OR email LIKE '%$searchValue%' 
                    OR created_at LIKE '%$searchValue%')";
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

$sql = "SELECT id, first_name, last_name, role, email, created_at
        $baseSql $searchSql $columnSearchSql
        ORDER BY $orderColumnName $orderDir 
        LIMIT $start, $length";
$result = $conn->query($sql);
$data = $result->fetch_all(MYSQLI_ASSOC);

$sqlFilter = "SELECT COUNT(id) $baseSql $searchSql $columnSearchSql";
$filteredRecords = $conn->query($sqlFilter)->fetch_row()[0];

echo json_encode([
    "draw" => intval($_POST['draw']),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $filteredRecords,
    "data" => $data,
]);
$conn->close();
