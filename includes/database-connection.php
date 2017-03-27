<?php
	// Database username and password
	$database_username = 'root';
	$database_password = 'root';

	// Establish PDO & DSN Connection to Database
	$dbh = new PDO('mysql:host=localhost;dbname=;port=8889', $database_username, $database_password);
?>