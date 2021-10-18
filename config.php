<?php
define('DB_NAME', 'mydatabase');
define('DB_USER', 'root');
# define('DB_PASSWORD', $_ENV["DB_PASS"]);
define('DB_PASSWORD', 'password');
define('DB_HOST', 'mysql');

// Create connection
$db		=	new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
