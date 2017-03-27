<?php

	include 'includes/database-connection.php';
	include 'includes/session.php';
	include 'includes/membersonly.php';

	// Item id of item being purchased
	$itemid = $_GET['itemid'];

	// Shop id where item is located
	$shopid = $_GET['shopid'];


	// Select shopname
	$sth = $dbh -> prepare("SELECT shopname from shops WHERE shopid = :shopid");
	$sth->execute(['shopid' => $shopid]); 
	$result = $sth -> fetch();
	$shopname = $result["shopname"];

	// Shop url for redirecting user back to the shop where they purchased the item from
	$shopurl = 'viewshop.php?shop=' . $shopname;



	// Does the user have enough virtual currency to buy the item?
	$sth = $dbh -> prepare("SELECT virtualcurrency1 from users WHERE userid = :userid");
	$sth->execute(['userid' => $userid]); 
	$result = $sth -> fetch();
	$virtualcurrency1 = $result["virtualcurrency1"];
	$itemprice = 0;

	// Select item price
	$sth = $dbh -> prepare("SELECT itemprice from items WHERE id = :itemid");
	$sth->execute(['itemid' => $itemid]); 
	$result = $sth -> fetch();
	$itemprice = $result["itemprice"];


	// Redirect user back to shop if item price is greater than user's virtual currency 1
	if ($itemprice > $virtualcurrency1) {
		header('Location: ' . $shopurl);
	} else {
		// Calculate user's virtual currency 1 by subtracting item price
		$update_virtualcurrency = $virtualcurrency1 - $itemprice;

		// Update user's virtual currency 1
		$stmt = $dbh->prepare('UPDATE users SET virtualcurrency1 = :updatevirtualcurrency  WHERE userid = :userid');
		$stmt->execute(['updatevirtualcurrency' => $update_virtualcurrency, 'userid' => $userid]);

		// Add item to user's inventory
		$stmt = $dbh->prepare("INSERT INTO users_inventory (userid, itemid)VALUES(:userid, :itemid)");
		$stmt->bindParam(':userid', $userid);
		$stmt->bindParam(':itemid', $itemid);
		$stmt->execute();

		// Redirect user back to shop
		header('Location: ' . $shopurl);
	}

?>