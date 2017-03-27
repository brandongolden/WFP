<?php
	include 'includes/database-connection.php';
	include 'includes/session.php';

  
	// Unset all of the session variables.
	session_unset();
	// Destroy the session.
	session_destroy();


	// Redirect user back to index.php
	header('Location: index.php');
?>