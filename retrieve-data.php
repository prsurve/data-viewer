<?php
include 'config.php';
$query="select * from WORKLOAD ORDER BY srno DESC LIMIT 2000"; // Fetch all the data from the table WORKLOAD
$result=mysqli_query($db,$query);
?>
