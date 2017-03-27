<?php
	/*
		Redirect user to the login page if they are not logged in.
		Include this file in any file that you want restricted to members only.
	*/
    if (!isset($_SESSION['user_id'])) {
    	header('Location: login.php');
	}
?>