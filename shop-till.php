<?php

  include 'includes/database-connection.php';
  include 'includes/session.php';
  include 'includes/membersonly.php';

  // Page title
  $page_title = "Shop Till";


  // Select user's shop till balance
  $sth = $dbh -> prepare("SELECT shoptill from users WHERE userid = :userid");
  $sth->execute(['userid' => $userid]); 
  $result = $sth -> fetch();
  $shoptill = $result["shoptill"];
  

  
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $withdraw = $_POST['withdraw'];

    if ($withdraw > $shoptill || $withdraw < 1) {
      // Withdraw greater than bank account balance or less than 1
      header('Location: shop-till.php');
    } else {
      // Do withdraw

      // Update shop till balance to reflect withdraw


      $update_shoptill_balance = $shoptill - $withdraw;
      $update_virtualcurrency = $user_virtualcurrency1 + $withdraw;

      $stmt = $dbh->prepare('UPDATE users SET shoptill = :shoptill  WHERE userid = :userid');
      $stmt->execute(['shoptill' => $update_shoptill_balance, 'userid' => $userid]);



      $stmt = $dbh->prepare('UPDATE users SET virtualcurrency1 = :virtualcurrency  WHERE userid = :userid');
      $stmt->execute(['virtualcurrency' => $update_virtualcurrency, 'userid' => $userid]);

      //$shoptill = $update_shoptill_balance;
      header('Location: shop-till.php');
    }
  }

  $shoptill = number_format($shoptill);

  include 'includes/header.php';
?>


<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li><a href="shops.php">Shops</a></li>
  <li><a href="the-marketplace.php">The Marketplace</a></li>
  <?php
    echo '<li><a href="viewusershop.php?username=' . $username . '">' . $username . "'s Shop" . "</a></li>";
  ?>
  <li><a href="manage-shop.php">Manage Shop</a></li>
  <li class="active">Shop Till</li>
</ol>


<h2>Shop Till</h2>

<h5>Balance: <?php echo $shoptill . ' ' . $settings_virtualcurrency1; ?></h5>




<form class="form-inline" action="shop-till.php" method="post">
  <div class="form-group">
    <label  for="withdraw">Withdraw</label>
      <input type="text" class="form-control" name="withdraw" id="withdraw">
    </div>
  <button type="submit" class="btn btn-primary">Withdraw</button>
</form>




<?php
  include 'includes/footer.php';
?>