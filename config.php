<?php
define('DB_NAME', 'mydatabase');
define('DB_USER', 'dataviewer');
define('DB_HOST', 'mysql');

// Create connection
$db		=	new mysqli(DB_HOST, DB_USER, 'dataviewer', DB_NAME);
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
