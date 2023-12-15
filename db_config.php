<?php

# SET DB CREDENTIALS
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'lgn_db';

# BUILD CONNECTION STRING
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

# CATCH CONNECTION ERRORS
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

?>