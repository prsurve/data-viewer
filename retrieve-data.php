<?php
include 'config.php';
$query="select * from WORKLOAD ORDER BY dt DESC"; // Fetch all the data from the table WORKLOAD
$result=mysqli_query($db,$query);
?>
