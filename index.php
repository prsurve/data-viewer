<html>
<head><title> Display.php </title></head>
<body bgcolor="aabbcc">
<?php


define('DB_SERVER', 'mysql');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'password');
define('DB_DATABASE', 'mydatabase'); //where customers is the database
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);


$query="select * from WORKLOAD"; // Fetch all the records from the table address
$result=mysqli_query($db,$query);
?>

<h3> Page to display the stored data </h3>

<table border="1">
<tr>
<th> DATE </th>
<th> DATA  </th>


<?php while($array=mysqli_fetch_row($result)) ?>
<tr>
<td><?echo $array[0];?></td>
<td><?echo $array[1];?></td>
</tr>

<?php endwhile; ?>
<?php mysqli_free_result($result); ?>
<?php mysqli_close($db); ?>
</table>
</body>
</html>
