<?php

	// Title
	$name = "title";
	$sth = $dbh -> prepare("SELECT value from settings WHERE name = :name");
	$sth->execute(['name' => $name]); 
	$result = $sth -> fetch();
	$settings_title = $result["value"];

	// Virtual Currency 1 Name
	$name = "virtualcurrency1";
	$sth = $dbh -> prepare("SELECT value from settings WHERE name = :name");
	$sth->execute(['name' => $name]); 
	$result = $sth -> fetch();
	$settings_virtualcurrency1 = $result["value"];

	// Virtual Currency 2 Name
	$name = "virtualcurrency2";
	$sth = $dbh -> prepare("SELECT value from settings WHERE name = :name");
	$sth->execute(['name' => $name]); 
	$result = $sth -> fetch();
	$settings_virtualcurrency2 = $result["value"];

?>