<?php

use Classes\User;

require_once('../../authentication/backend_authenticate.php');
require_once('../../classes/traits/ItemOperations.php');
require_once('../../classes/Database.php');
require_once('../../classes/User.php');

$usr = new User();
$conn = $usr->getConnection();
$columns = array(
    0 => 'id',
    1 => 'first_name',
    2 => 'last_name',
    3 => 'email',
    4 => 'created_at',
);

$start = $_POST['start'];
$length = $_POST['length'];
$search_value = $_POST['search']['value'];
$order_column = $_POST['order'][0]['column'] ?? 0;
$order_dir = $_POST['order'][0]['dir'] ?? 'asc';

$sql_total = "SELECT COUNT(id) FROM users";
$result_total = $conn->query($sql_total);
$total_records = $result_total->fetch_row()[0];

$sql = "SELECT id, first_name, last_name, email, created_at FROM users
        WHERE first_name LIKE '%$search_value%' OR email LIKE '%$search_value%' 
        ORDER BY " . $columns[$order_column] . " $order_dir 
        LIMIT $start, $length";

$result = $conn->query($sql);

$sql_filter = "SELECT COUNT(id) FROM users 
        WHERE first_name LIKE '%$search_value%' OR email LIKE '%$search_value%'
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
