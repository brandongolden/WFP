<?php
	include '../includes/database-connection.php';
	include 'includes/session.php';
	include 'includes/admin.php';

	$id = $_GET['itemid'];



	$sth = $dbh -> prepare("SELECT itemimage from items WHERE id = :id");
	$sth->execute(['id' => $id]); 
	$result = $sth -> fetch();
	$itemimage = $result["itemimage"];


	unlink('../images/items/' . $itemimage);


	$sth = $dbh -> prepare("DELETE from items WHERE id = :id");
	$sth->execute(['id' => $id]);


	$sth = $dbh -> prepare("DELETE from shops_inventory WHERE itemid = :id");
	$sth->execute(['id' => $id]);


	$sth = $dbh -> prepare("DELETE from users_shops WHERE itemid = :id");
	$sth->execute(['id' => $id]);

	$sth = $dbh -> prepare("DELETE from users_inventory WHERE itemid = :id");
	$sth->execute(['id' => $id]);


    header('Location: items.php');
?>