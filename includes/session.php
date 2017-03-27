<?php
	// Start session
	session_start();

	$user_virtualcurrency1 = $user_virtualcurrency2 = 0;
	
    if (isset($_SESSION['user_id'])) {

    	// User ID of logged in user
		$userid = $_SESSION['user_id'];

		// Username of logged in user
		$sth = $dbh -> prepare("SELECT username from users WHERE userid = :userid");
	    $sth->execute(['userid' => $userid]); 
	    $result = $sth -> fetch();
	    $username = $result["username"];

	    // Account type of logged in user
	    $sth = $dbh -> prepare("SELECT account_type from users WHERE userid = :userid");
	    $sth->execute(['userid' => $userid]); 
	    $result = $sth -> fetch();
	    $account_type = $result["account_type"];

	    // Virtual Currency 1 of logged in user
	    $sth = $dbh -> prepare("SELECT virtualcurrency1 from users WHERE userid = :userid");
	    $sth->execute(['userid' => $userid]); 
	    $result = $sth -> fetch();
	    $user_virtualcurrency1 = $result["virtualcurrency1"];

	    // Virtual Currency 2 of logged in user
	    $sth = $dbh -> prepare("SELECT virtualcurrency2 from users WHERE userid = :userid");
	    $sth->execute(['userid' => $userid]); 
	    $result = $sth -> fetch();
	    $user_virtualcurrency2 = $result["virtualcurrency2"];
	}



	// Settings

	// Title
	$name = "title";
	$sth = $dbh -> prepare("SELECT value from settings WHERE name = :name");
	$sth->execute(['name' => $name]); 
	$result = $sth -> fetch();
	$settings_title = $result["value"];

	// Name of virtual currency 1
	$name = "virtualcurrency1";
	$sth = $dbh -> prepare("SELECT value from settings WHERE name = :name");
	$sth->execute(['name' => $name]); 
	$result = $sth -> fetch();
	$settings_virtualcurrency1 = $result["value"];

	// Name of virtual currency 2
	$name = "virtualcurrency2";
	$sth = $dbh -> prepare("SELECT value from settings WHERE name = :name");
	$sth->execute(['name' => $name]); 
	$result = $sth -> fetch();
	$settings_virtualcurrency2 = $result["value"];
?>