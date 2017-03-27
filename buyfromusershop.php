<?php

  	include 'includes/database-connection.php';
	include 'includes/session.php';
	include 'includes/membersonly.php';

	$id = $_GET['id']; // id of listing in users_shops table
	$shopid = $_GET['shopid']; // User id of shop owner


	// Select username of shop owner
	$sth = $dbh -> prepare("SELECT username from users WHERE userid = :userid");
	$sth->execute(['userid' => $shopid]); 
	$result = $sth -> fetch();
	$shopusername = $result["username"];


	// Shop url for redirecting user
	$shopurl = 'viewusershop.php?username=' . $shopusername;


	// Does the user have enough virtual currency to buy the item?
	$sth = $dbh -> prepare("SELECT virtualcurrency1 from users WHERE userid = :userid");
	$sth->execute(['userid' => $userid]); 
	$result = $sth -> fetch();
	$virtualcurrency1 = $result["virtualcurrency1"];
	$itemprice = 0;

	// Select item price
	$sth = $dbh -> prepare("SELECT itemprice from users_shops WHERE id = :id");
	$sth->execute(['id' => $id]); 
	$result = $sth -> fetch();
	$itemprice = $result["itemprice"];


	// If item price is greater than virtual currency 1 and userid does not match shop owner userid
	if ($itemprice > $virtualcurrency1 && $shopid != $userid) {
		header('Location: ' . $shopurl);
	} else {
		
		// If shop id does not match user id
		if ($shopid != $userid){

			// Calculate user's virtual currency 1 by subtracting item price
			$update_virtualcurrency = $virtualcurrency1 - $itemprice;

			// Update user's virtual currency 1
			$stmt = $dbh->prepare('UPDATE users SET virtualcurrency1 = :updatevirtualcurrency  WHERE userid = :userid');
			$stmt->execute(['updatevirtualcurrency' => $update_virtualcurrency, 'userid' => $userid]);


			// Update shop till balance of shop owner
			$sth = $dbh -> prepare("SELECT shoptill from users WHERE userid = :shopid");
			$sth->execute(['shopid' => $shopid]); 
			$result = $sth -> fetch();
			$shoptill = $result["shoptill"];
			$shoptill = $shoptill + $itemprice;
			$stmt = $dbh->prepare('UPDATE users SET shoptill = :shoptill  WHERE userid = :shopid');
			$stmt->execute(['shoptill' => $shoptill, 'shopid' => $shopid]);
		}



		// What is the item?
		$sth = $dbh -> prepare("SELECT itemid from users_shops WHERE id = :id");
		$sth->execute(['id' => $id]); 
		$result = $sth -> fetch();
		$itemid = $result["itemid"];

		// Move purchase to user inventory
		$stmt = $dbh->prepare("INSERT INTO users_inventory (userid, itemid)VALUES(:userid, :itemid)");
		$stmt->bindParam(':userid', $userid);
		$stmt->bindParam(':itemid', $itemid);
		$stmt->execute();

		
		// Delete item from user shop
		$sth = $dbh -> prepare("DELETE from users_shops WHERE id = :id");
		$sth->execute(['id' => $id]);

		// If shop id matches user id redirect them back to manage shop
		if ($shopid == $userid){
			$shopurl = "manage-shop.php";
		}

		// Redirect user back to shop
		header('Location: ' . $shopurl);

	}

?>