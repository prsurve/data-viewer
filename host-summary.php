<?php
include 'config.php'; // $dbHost, $dbUser, $dbPass, $dbName

// Run query
$sql = "SELECT host, COUNT(*) AS total_rows FROM WORKLOAD GROUP BY host ORDER BY total_rows DESC";
$result = mysqli_query($db, $sql);

// Check for query errors
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host Summary</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<div class="container mx-auto py-6 px-4">

    <!-- Page Title -->
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
        📊 Data Written Per Host
    </h2>

    <!-- Table -->
    <div class="overflow-x-auto shadow-lg rounded-lg bg-white">
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-gradient-to-r from-purple-500 to-indigo-500 text-white">
                    <th class="p-3 text-left">Host</th>
                    <th class="p-3 text-left">Total Rows</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 text-gray-900"><?php echo htmlspecialchars($row['host']); ?></td>
                        <td class="p-3 text-gray-900 font-semibold"><?php echo number_format($row['total_rows']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Link to go back -->
    <div class="text-center mt-6">
        <a href="index.php" 
           class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200">
            ⬅ Back to Main Page
        </a>
    </div>

</div>

</body>
</html>
