<?php
include 'config.php'; // Include your database connection

// Get parameters from the AJAX request
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
$offset = ($page - 1) * $limit;

// Get the total number of rows for pagination
$resultTotal = mysqli_query($db, "SELECT COUNT(*) FROM WORKLOAD");
$totalRows = mysqli_fetch_row($resultTotal)[0];
$totalPages = ceil($totalRows / $limit);

// Fetch the column names dynamically
$columnsResult = mysqli_query($db, "SHOW COLUMNS FROM WORKLOAD");
$columns = [];
while ($column = mysqli_fetch_assoc($columnsResult)) {
    $columns[] = $column['Field']; // Collect all column names
}

// Fetch the records for the current page
$result = mysqli_query($db, "SELECT * FROM WORKLOAD ORDER BY srno DESC LIMIT $offset, $limit");

$data = [];
if ($result->num_rows > 0) {
    while ($array = mysqli_fetch_row($result)) {
        $data[] = $array;
    }
}

// Return data as JSON with dynamic column names and pagination info
echo json_encode([
    'columns' => $columns,
    'data' => $data,
    'totalRows' => $totalRows,
    'page' => $page,
    'totalPages' => $totalPages
]);
?>
