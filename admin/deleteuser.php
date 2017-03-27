<?php
	include '../includes/database-connection.php';
	include 'includes/session.php';
	include 'includes/admin.php';


	if (isset($_GET['userid']) && $userid != $_GET['userid']) {

		$deleteuserid = $_GET['userid'];


		$sth = $dbh -> prepare("SELECT avatar from users WHERE userid = :userid");
		$sth->execute(['userid' => $deleteuserid]); 
		$result = $sth -> fetch();
		$delete_avatar = $result["avatar"];


		// users table
		$sth = $dbh -> prepare("DELETE from users WHERE userid = :userid");
		$sth->execute(['userid' => $deleteuserid]); 

		// bank table
		$sth = $dbh -> prepare("DELETE from bank WHERE userid = :userid");
		$sth->execute(['userid' => $deleteuserid]); 

		// lottery table
		$sth = $dbh -> prepare("DELETE from lottery WHERE userid = :userid");
		$sth->execute(['userid' => $deleteuserid]); 

		// profiles table
		$sth = $dbh -> prepare("DELETE from profiles WHERE userid = :userid");
		$sth->execute(['userid' => $deleteuserid]); 

		// users_inventory table
		$sth = $dbh -> prepare("DELETE from users_inventory WHERE userid = :userid");
		$sth->execute(['userid' => $deleteuserid]); 

		// users_shops table
		$sth = $dbh -> prepare("DELETE from users_shops WHERE userid = :userid");
		$sth->execute(['userid' => $deleteuserid]); 

		// delete avatar file
		unlink('../avatars/' . $delete_avatar);


		header('Location: users.php');

	} else {
		header('Location: users.php');
	}
?>