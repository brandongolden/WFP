<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $sql = "

    CREATE TABLE `bank` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `userid` int(11) DEFAULT NULL,
      `balance` int(11) DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

    CREATE TABLE `billing` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `packagename` varchar(255) DEFAULT '',
      `virtualcurrency2` int(11) unsigned DEFAULT '0',
      `price` decimal(5,2) unsigned DEFAULT '0.00',
      `packageimage` varchar(255) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

    CREATE TABLE `blog_posts` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `post_userid` int(11) DEFAULT NULL,
      `post_title` text,
      `post_content` longtext,
      `post_date` datetime DEFAULT NULL,
      `post_modified` datetime DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

    CREATE TABLE `free_gift` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `itemid` int(11) unsigned DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

    CREATE TABLE `items` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `itemname` varchar(255) NOT NULL DEFAULT '',
      `itemprice` int(11) unsigned NOT NULL,
      `itemimage` varchar(255) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

    CREATE TABLE `profiles` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `userid` int(11) unsigned NOT NULL,
      `name` varchar(255) DEFAULT NULL,
      `gender` varchar(255) DEFAULT NULL,
      `hobbies` varchar(255) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

    CREATE TABLE `scratchcards` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `userid` int(11) unsigned NOT NULL,
      `user_prize` tinyint(1) DEFAULT '0',
      `scratch_off_count` int(1) unsigned DEFAULT NULL,
      `user_1` tinyint(1) DEFAULT NULL,
      `user_2` tinyint(1) DEFAULT NULL,
      `user_3` tinyint(1) DEFAULT NULL,
      `user_4` tinyint(1) DEFAULT NULL,
      `user_5` tinyint(1) DEFAULT NULL,
      `user_6` tinyint(1) DEFAULT NULL,
      `user_7` tinyint(1) DEFAULT NULL,
      `user_8` tinyint(1) DEFAULT NULL,
      `user_9` tinyint(1) DEFAULT NULL,
      `scratchcard_1` int(1) DEFAULT NULL,
      `scratchcard_2` int(1) DEFAULT NULL,
      `scratchcard_3` int(1) DEFAULT NULL,
      `scratchcard_4` int(1) DEFAULT NULL,
      `scratchcard_5` int(1) DEFAULT NULL,
      `scratchcard_6` int(1) DEFAULT NULL,
      `scratchcard_7` int(1) DEFAULT NULL,
      `scratchcard_8` int(1) DEFAULT NULL,
      `scratchcard_9` int(1) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

    CREATE TABLE `settings` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(255) DEFAULT NULL,
      `value` varchar(255) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

    CREATE TABLE `shops` (
      `shopid` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `shopname` varchar(255) NOT NULL,
      `shopimage` varchar(255) NOT NULL DEFAULT 'default.png',
      PRIMARY KEY (`shopid`)
    ) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

    CREATE TABLE `shops_inventory` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `shopid` int(11) unsigned NOT NULL,
      `itemid` int(11) unsigned NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

    CREATE TABLE `users` (
      `userid` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `username` varchar(255) NOT NULL DEFAULT '',
      `password` varchar(255) NOT NULL DEFAULT '',
      `virtualcurrency1` int(11) unsigned NOT NULL DEFAULT '0',
      `virtualcurrency2` int(11) unsigned NOT NULL DEFAULT '0',
      `shoptill` int(11) unsigned NOT NULL DEFAULT '0',
      `avatar` varchar(255) DEFAULT NULL,
      `account_type` varchar(255) NOT NULL DEFAULT 'user',
      `scratchcards` int(11) unsigned NOT NULL DEFAULT '0',
      `free_gift` datetime DEFAULT NULL,
      `free_gift_itemid` int(11) unsigned DEFAULT NULL,
      PRIMARY KEY (`userid`)
    ) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

    CREATE TABLE `users_inventory` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `userid` int(11) unsigned NOT NULL,
      `itemid` varchar(255) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=latin1;

    CREATE TABLE `users_shops` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `userid` int(11) unsigned NOT NULL,
      `itemid` int(11) unsigned NOT NULL,
      `itemprice` int(11) unsigned NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=latin1;


    INSERT INTO `settings` (`id`, `name`, `value`)
    VALUES
    (1, 'virtualcurrency1', 'Coins'),
    (2, 'virtualcurrency2', 'Points'),
    (3, 'title', 'Title'),
    (6, 'scratchcardprice', '1');


    INSERT INTO `users` (`userid`, `username`, `password`, `virtualcurrency1`, `virtualcurrency2`, `shoptill`, `avatar`, `account_type`, `scratchcards`, `free_gift`, `free_gift_itemid`)
    VALUES
    (2, 'admin', 'ac05fcb6e9c82f7dc7f2bfc80e595291', 0, 0, 0, NULL, 'admin', 0, NULL, NULL);

    ";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Tables created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;

?>