<?php

include 'includes/database-connection.php';
include 'includes/session.php';
include 'includes/membersonly.php';


// Select user's bank account balance
$stmt = $dbh->prepare('SELECT balance FROM bank WHERE userid = :userid');
$stmt->execute(['userid' => $userid]);
$result = $stmt->fetchall(PDO::FETCH_ASSOC);

foreach ($result as $row) {
	// Store bank account balance in variable
	$balance = $row['balance'];
}

// Select user's virtual currency 1
$stmt = $dbh->prepare('SELECT virtualcurrency1 FROM users WHERE userid = :userid');
$stmt->execute(['userid' => $userid]);
$result = $stmt->fetchall(PDO::FETCH_ASSOC);

foreach ($result as $row) {
	// Store user's virtual currency 1 in variable
	$virtualcurrency = $row['virtualcurrency1'];
}


// If action == withdraw, do withdrawal
if ($_GET['action'] == 'withdraw') {
	if ($_POST['withdraw'] > $balance || $_POST['withdraw'] < 1) {
		// Withdraw greater than bank account balance or less than 1
		header('Location: bank.php');
	} else {
		// Do withdraw

		// Update bank account balance to reflect withdraw
		$update_bank_balance = $balance - $_POST['withdraw'];
		$update_virtualcurrency = $virtualcurrency + $_POST['withdraw'];

		$stmt = $dbh->prepare('UPDATE bank SET balance = :balance  WHERE userid = :userid');
		$stmt->execute(['balance' => $update_bank_balance, 'userid' => $userid]);


		// Update user's virtual currency 1 after withdraw
		$stmt = $dbh->prepare('UPDATE users SET virtualcurrency1 = :virtualcurrency  WHERE userid = :userid');
		$stmt->execute(['virtualcurrency' => $update_virtualcurrency, 'userid' => $userid]);

	}
	// Redirect user back to bank
	header('Location: bank.php');


// If action == deposit, do deposit
} elseif ($_GET['action'] == 'deposit') {

	if ($_POST['deposit'] > $virtualcurrency || $_POST['deposit'] < 1) {
		// Deposit is greater than user's virtual currency 1 or less than 1
		// Do nothing
	} else {

		// Do deposit

		// Update bank account balance to reflect deposit
		$update_bank_balance = $balance + $_POST['deposit'];
		$update_virtualcurrency = $virtualcurrency - $_POST['deposit'];

		$stmt = $dbh->prepare('UPDATE bank SET balance = :balance  WHERE userid = :userid');
		$stmt->execute(['balance' => $update_bank_balance, 'userid' => $userid]);


		// Update user's virtual currency 1 after deposit
		$stmt = $dbh->prepare('UPDATE users SET virtualcurrency1 = :virtualcurrency  WHERE userid = :userid');
		$stmt->execute(['virtualcurrency' => $update_virtualcurrency, 'userid' => $userid]);

	}
	// Redirect user back to bank
	header('Location: bank.php');

} else {
	// Redirect user back to bank if no action matches
	header('Location: bank.php');
}


?>