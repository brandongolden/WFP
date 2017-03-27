<?php
	include '../includes/database-connection.php';
	include 'includes/session.php';
	include 'includes/admin.php';

	$id = $_GET['id'];


	$sth = $dbh -> prepare("SELECT shopid from shops_inventory WHERE id = :id");
	$sth->execute(['id' => $id]); 
	$result = $sth -> fetch();
	$shopid = $result["shopid"];


	$sth = $dbh -> prepare("DELETE from shops_inventory WHERE id = :id");
	$sth->execute(['id' => $id]);

    header('Location: manageshop.php?shopid=' . $shopid);
?>