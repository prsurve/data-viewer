<?php
include 'config.php'; // $dbHost, $dbUser, $dbPass, $dbName

// Run query
$sql = "SELECT host, COUNT(*) AS total_rows FROM WORKLOAD GROUP BY host ORDER BY total_rows DESC";
$result = mysqli_query($conn, $sql);

// Check for query errors
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Host Summary</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 60%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f5f5f5;
        }
        h2 {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <h2>Data Written Per Host</h2>
    <table>
        <tr>
            <th>Host</th>
            <th>Total Rows</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['host']); ?></td>
                <td><?php echo number_format($row['total_rows']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
// Close connection
mysqli_close($conn);
?>
