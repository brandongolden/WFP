<?php

  include 'includes/database-connection.php';
  include 'includes/session.php';
  include 'includes/membersonly.php';


  if (!isset($_GET['shop'])) {
    header('Location: shops.php');
  }

  $shopname = $_GET['shop'];



  $sth = $dbh -> prepare("SELECT shopid from shops WHERE shopname = :shopname");
  $sth->execute(['shopname' => $shopname]); 
  $result = $sth -> fetch();
  $shopid = $result["shopid"];

  //$shopname = "Shop not found";




  $stmt = $dbh->prepare('SELECT virtualcurrency1 FROM users WHERE userid = :userid');
  $stmt->execute(['userid' => $userid]);
  $result = $stmt->fetchall(PDO::FETCH_ASSOC);

  foreach ($result as $row) {
    $virtualcurrency = $row['virtualcurrency1'];
  }



  $stmt = $dbh->prepare('SELECT * FROM shops WHERE shopid = :shopid');
  $stmt->execute(['shopid' => $shopid]);
  $result = $stmt->fetchall(PDO::FETCH_ASSOC);

  foreach ($result as $row) {
    $shopid = $row['shopid'];
    $shopname = $row['shopname'];
    $shopimage = $row['shopimage'];
  }


  if ($shopname == "Shop not found") {
    header('Location: shops.php');
  }



  $page_title = $shopname . " - Shops";

  include 'includes/header.php';

?>

<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li><a href="shops.php">Shops</a></li>
  <li class="active"><?php echo $shopname; ?></li>
</ol>


<h2>
<?php   
  echo '<img style="max-width: 100px;" class="shops-img"  src="images/shops/' . $shopimage . '" />';
?>
<?php echo $shopname; ?>
  
</h2>



  <?php
    // Select all shop inventory items
    $stmt = $dbh->prepare('SELECT * FROM shops_inventory WHERE shopid = :shopid');
    $stmt->execute(['shopid' => $shopid]);
    $result = $stmt->fetchall(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
      //$id = $row['id'];
      $itemid = $row['itemid'];
      $itemprice = 0;
      $itemname = "";


      $sth = $dbh -> prepare("SELECT itemname from items WHERE id = :itemid");
      $sth->execute(['itemid' => $itemid]); 
      $result = $sth -> fetch();
      $itemname = $result["itemname"];

      $sth = $dbh -> prepare("SELECT itemprice from items WHERE id = :itemid");
      $sth->execute(['itemid' => $itemid]); 
      $result = $sth -> fetch();
      $itemprice = $result["itemprice"];

      $itemprice = number_format($itemprice);


      $sth = $dbh -> prepare("SELECT itemimage from items WHERE id = :itemid");
      $sth->execute(['itemid' => $itemid]); 
      $result = $sth -> fetch();
      $itemimage = $result["itemimage"];

      echo '<div class="shops-item"><div class="shops-item-img-container"><img alt="' . $itemname . '" class="img-thumbnail" src="images/items/' . $itemimage . '" /></div>';
      echo '<h6>' . $itemname . '</h6>';
      echo '<div class="purchase">Purchase: <a class="btn btn-primary" href="buy.php?shopid=' . $shopid . '&itemid='. $itemid . '">' . $itemprice . ' ' . $settings_virtualcurrency1 .'</a></div></div>';

    }

  ?>




<?php
  include 'includes/footer.php';
?>