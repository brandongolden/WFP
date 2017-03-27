<?php

  include 'includes/database-connection.php';
  include 'includes/session.php';
  include 'includes/membersonly.php';


  if (!isset($_GET['username'])) {
    header('Location: shops.php');
  }

  $shopusername = $_GET['username'];


  //$shopid = $_GET['shopid'];


  $sth = $dbh -> prepare("SELECT userid from users WHERE username = :username");
  $sth->execute(['username' => $shopusername]); 
  $result = $sth -> fetch();
  $shopid = $result["userid"];
  
  $shopname = $shopusername . "'s Shop";

  

  $page_title = $shopname;

  
  include 'includes/header.php';

?>

<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li><a href="shops.php">Shops</a></li>
  <li><a href="the-marketplace.php">The Marketplace</a></li>
  <li class="active"><?php echo $shopname; ?></li>
</ol>



<h2>
<?php echo $shopname; ?>
<?php 
  if ($shopid == $userid) {
?>
<a class="btn btn-link" style="float: right;" href="manage-shop.php">Manage Shop</a>
<?php
  }
?>
</h2>



  <?php
    // Select all items from users_shops that match userid of shop owner
    $stmt = $dbh->prepare('SELECT * FROM users_shops WHERE userid = :shopid');
    $stmt->execute(['shopid' => $shopid]);
    $result = $stmt->fetchall(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
      $id = $row['id'];
      $itemid = $row['itemid'];
      $itemprice = 0;
      $itemname = "";


      $sth = $dbh -> prepare("SELECT itemname from items WHERE id = :itemid");
      $sth->execute(['itemid' => $itemid]); 
      $result = $sth -> fetch();
      $itemname = $result["itemname"];

      $sth = $dbh -> prepare("SELECT itemprice from users_shops WHERE id = :id");
      $sth->execute(['id' => $id]); 
      $result = $sth -> fetch();
      $itemprice = $result["itemprice"];

      $itemprice = number_format($itemprice);


      $sth = $dbh -> prepare("SELECT itemimage from items WHERE id = :itemid");
      $sth->execute(['itemid' => $itemid]); 
      $result = $sth -> fetch();
      $itemimage = $result["itemimage"];


      echo '<div class="shops-item"><div class="shops-item-img-container"><img alt="' . $itemname . '" class="img-thumbnail" src="images/items/' . $itemimage . '" /></div>';
      echo '<h6>' . $itemname . '</h6>';

      if ($shopid != $userid){
        echo '<div class="purchase">Purchase: <a class="btn btn-primary" href="buyfromusershop.php?shopid=' . $shopid . '&id='. $id . '">' . $itemprice . ' ' . $settings_virtualcurrency1 .'</a></div></div>';        
      } else {
        echo '<div class="purchase">Purchase: <a class="btn btn-primary" disabled>' . $itemprice . ' ' . $settings_virtualcurrency1 .'</a></div></div>';   
      }

    }

  ?>


<?php
  include 'includes/footer.php';
?>