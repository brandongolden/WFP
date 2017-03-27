<?php
	include '../includes/database-connection.php';
	include 'includes/session.php';
	include 'includes/admin.php';

	$shopid = $_GET['shopid'];

	// delete from shops table
	$sth = $dbh -> prepare("DELETE from shops WHERE shopid = :shopid");
	$sth->execute(['shopid' => $shopid]); 

	// delete shop inventory
	$sth = $dbh -> prepare("DELETE from shops_inventory WHERE shopid = :shopid");
	$sth->execute(['shopid' => $shopid]);

	header('Location: shops.php');
?>