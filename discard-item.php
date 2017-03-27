<?php
	include 'includes/database-connection.php';
	include 'includes/session.php';
	include 'includes/membersonly.php';

	// If id is not set in url redirect user back to inventory
	if (!isset($_GET['id'])) {
    	header('Location: inventory.php');
  	}

  	// Id of item table row
  	$id = $_GET['id'];


  	// Verify user owns that item
	$sth = $dbh -> prepare("SELECT userid from users_inventory WHERE id = :id");
	$sth->execute(['id' => $id]); 
	$result = $sth -> fetch();
	$owner = $result["userid"];


	// If user owns item it can be deleted
	if ($owner == $userid) {
		// Trash item
		$sth = $dbh -> prepare("DELETE from users_inventory WHERE id = :id");
		$sth->execute(['id' => $id]); 

		// Redirect back to inventory
		header('Location: inventory.php');
	} else {
		// Redirect back to inventory
		header('Location: inventory.php');
	}
?>