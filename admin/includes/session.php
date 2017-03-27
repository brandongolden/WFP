<?php
	session_start();

    if (isset($_SESSION['user_id'])) {
		$userid = $_SESSION['user_id'];
	}
?>