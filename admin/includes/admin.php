<?php
	// Admin account?
	
	$sth = $dbh -> prepare("SELECT account_type from users WHERE userid = :userid");
	$sth->execute(['userid' => $userid]); 
	$result = $sth -> fetch();
	$account_type = $result["account_type"];

	$sth = $dbh -> prepare("SELECT username from users WHERE userid = :userid");
	$sth->execute(['userid' => $userid]); 
	$result = $sth -> fetch();
	$username = $result["username"];

	if ($account_type == 'user' || !isset($_SESSION['user_id'])) {
		header('Location: ../index.php');
	}
?>