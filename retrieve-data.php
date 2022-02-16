<?php
include 'config.php';
$query="select * from WORKLOAD ORDER BY srno DESC LIMIT 1500"; // Fetch all the data from the table WORKLOAD
$result=mysqli_query($db,$query);
?>
