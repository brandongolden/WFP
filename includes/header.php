<?php

  /*
  if (isset($_SESSION['user_id'])) {

    $sth = $dbh -> prepare("SELECT username from users WHERE userid = :userid");
    $sth->execute(['userid' => $userid]); 
    $result = $sth -> fetch();
    $username = $result["username"];

    $sth = $dbh -> prepare("SELECT account_type from users WHERE userid = :userid");
    $sth->execute(['userid' => $userid]); 
    $result = $sth -> fetch();
    $account_type = $result["account_type"];

    $sth = $dbh -> prepare("SELECT virtualcurrency1 from users WHERE userid = :userid");
    $sth->execute(['userid' => $userid]); 
    $result = $sth -> fetch();
    $user_virtualcurrency1 = $result["virtualcurrency1"];

    $sth = $dbh -> prepare("SELECT virtualcurrency2 from users WHERE userid = :userid");
    $sth->execute(['userid' => $userid]); 
    $result = $sth -> fetch();
    $user_virtualcurrency2 = $result["virtualcurrency2"];

  }

  // Settings
  $name = "title";
  $sth = $dbh -> prepare("SELECT value from settings WHERE name = :name");
  $sth->execute(['name' => $name]); 
  $result = $sth -> fetch();
  $settings_title = $result["value"];

  $name = "virtualcurrency1";
  $sth = $dbh -> prepare("SELECT value from settings WHERE name = :name");
  $sth->execute(['name' => $name]); 
  $result = $sth -> fetch();
  $settings_virtualcurrency1 = $result["value"];

  $name = "virtualcurrency2";
  $sth = $dbh -> prepare("SELECT value from settings WHERE name = :name");
  $sth->execute(['name' => $name]); 
  $result = $sth -> fetch();
  $settings_virtualcurrency2 = $result["value"];
  */

  // Title
  if (isset($page_title)) {
    $page_title = $page_title . " - " . $settings_title;
  } else {
    $page_title = $settings_title;
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    
    <title><?php echo $page_title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/navbar-fixed-top.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <link href="css/main.css" rel="stylesheet">



  </head>

  <body>


    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">

      <div class="account-info">
      <div class="container">

   

      <?php
      if (isset($_SESSION['user_id'])) {
        echo '<span class="virtualcurrency1">' . $settings_virtualcurrency1 . ': ' . number_format($user_virtualcurrency1) . '</span>'; 
        echo '<span class="virtualcurrency2">' . $settings_virtualcurrency2 . ': ' . number_format($user_virtualcurrency2) . '</span>'; 
      }
      ?>

 
      </div>
      </div>


      <div class="container">

        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><?php echo $settings_title; ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> My Account <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="inventory.php">Inventory</a></li>
                <li><a href="modify-account-information.php">Modify Account Information</a></li>   
                <li><a href="avatar.php">Avatar</a></li>             
                <li><a href="edit-profile.php">Edit Profile</a></li>
                <li><a href="billing.php">Buy <?php echo $settings_virtualcurrency2; ?></a></li>
              </ul>
            </li>


            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Shops <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="shops.php">Shops</a></li>
                <li><a href="the-marketplace.php">The Marketplace</a></li>                               
                <li><a href="viewusershop.php?username=<?php echo $username; ?>">Your Shop</a></li>
                <li><a href="bank.php">Bank</a></li>
                <li><a href="lottery.php">Lottery</a></li>
              </ul>
            </li>

            <li><a href="members.php">Members</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">


          <?php if (isset($_SESSION['user_id'])) { ?>

          


          <li class="dropdown">

              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $username; ?> <span class="caret"></span></a>

              <ul class="dropdown-menu">


              <?php
                if ($account_type == "admin") {
              ?>                
                <li class="dropdown-header">Management</li>
                <!-- <li><a href="#">Moderator Control Panel</a></li> -->
                <li><a href="admin">Admin Control Panel</a></li>
                <li role="separator" class="divider"></li>
              <?php 
                }
              ?>
              <li><a href="my-account.php">My Account</a></li>
              <li><a href="logout.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a></li>              

              </ul>
            </li>
            <?php 
              } else {
                echo '<li class=""><a href="login.php">Login</a></li>';
                echo '<li class=""><a href="register.php">Sign up</a></li>';
              }
            ?>

          </ul>


        </div><!--/.nav-collapse -->



      </div>
    


    </nav>

    <div class="container">