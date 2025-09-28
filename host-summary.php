<?php
require_once 'config.php'; // Your DB connection file

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query: Count rows grouped by host
    $stmt = $pdo->query("SELECT host, COUNT(*) AS total_rows FROM your_table_name GROUP BY host ORDER BY total_rows DESC");

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
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
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['host']); ?></td>
                <td><?php echo number_format($row['total_rows']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
