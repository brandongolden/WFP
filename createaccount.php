<?php
	include 'includes/database-connection.php';
	include 'includes/session.php';
	include 'includes/membersonly.php';

	// Password salt
	$salt = "3dN9OcVYt9v2";

	// Encrypt password using salt
	$epass = md5($_POST['password'] . $salt);

	// Username from form
	$euser = $_POST['user'];

	// Check if username already exists
	$stmt = $dbh->prepare('SELECT * FROM users WHERE username = :username');
	$stmt->bindParam(':username', $euser);
	$stmt->execute();
	$result = $stmt->rowcount(PDO::FETCH_ASSOC);
	$usernamematch = $result;


	if ($usernamematch >= 1) {
		// Username already exists redirect user back to form with error
		header('Location: register.php?error=usernamematch');
	} else {
		// Create user account in database
		$stmt = $dbh->prepare("INSERT INTO users (username, password)VALUES(:username, :password)");
		$stmt->bindParam(':username', $euser);
		$stmt->bindParam(':password', $epass);
		$stmt->execute();

		// User id of new account
		$sth = $dbh -> prepare("SELECT userid from users WHERE username = :username");
		$sth->execute(['username' => $euser]); 
		$result = $sth -> fetch();
		$new_userid = $result["userid"];

		// Create user bank account
		$new_balance = 0; // Default bank account balance for new user accounts
		$stmt = $dbh->prepare("INSERT INTO bank (userid, balance)VALUES(:userid, :balance)");
		$stmt->bindParam(':userid', $new_userid);
		$stmt->bindParam(':balance', $new_balance);
		$stmt->execute();		

		header('Location: login.php');
	}


?>