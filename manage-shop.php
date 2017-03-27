<?php

  include 'includes/database-connection.php';
  include 'includes/session.php';
  include 'includes/membersonly.php';


  // Shop id is the shop owner user id
  $shopid = $userid;



  // Select username of shop owner
  $sth = $dbh -> prepare("SELECT username from users WHERE userid = :shopid");
  $sth->execute(['shopid' => $shopid]); 
  $result = $sth -> fetch();
  $shopusername = $result["username"];
  
  $shopname = $shopusername . "'s Shop";

  
  // Page title
  $page_title = "Manage Shop";

  


  if (isset($_GET['action'])) {
    if ($_GET['action'] == "discarditem") {
      $discarditemid = $_GET['id'];

      // Verify user owns that item
      $sth = $dbh -> prepare("SELECT userid from users_shops WHERE id = :id");
      $sth->execute(['id' => $discarditemid]); 
      $result = $sth -> fetch();
      $owner = $result["userid"];


      if ($owner == $userid) {
        // Trash item
        $sth = $dbh -> prepare("DELETE from users_shops WHERE id = :id");
        $sth->execute(['id' => $discarditemid]); 
      } 

      header('Location: manage-shop.php');  
    }
  }

  // Update item price
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $yourprice = $_POST['yourprice'];
    $id = $_POST['id'];

    $stmt = $dbh->prepare('UPDATE users_shops SET itemprice = :yourprice  WHERE id = :id');
    $stmt->execute(['yourprice' => $yourprice, 'id' => $id]);

    header('Location: manage-shop.php');
  }


  include 'includes/header.php';

?>

<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li><a href="shops.php">Shops</a></li>
  <li><a href="the-marketplace.php">The Marketplace</a></li>
  <?php
  echo '<li><a href="viewusershop.php?username=' . $username . '">' . $shopname . '</a></li>';
  ?>
  <li class="active">Manage Shop</li>
</ol>





<h2>
Manage Shop

<?php
  echo '<a class="btn btn-link" style="margin-left: 4px; float: right;" href="viewusershop.php?username=' . $username . '">' . 'Shop Front' . '</a>';
?>

<a class="btn btn-link" style="float: right;" href="shop-till.php">Shop Till</a>

</h2>


<?php
  // Select all items that belong to shop
  $stmt = $dbh->prepare('SELECT * FROM users_shops WHERE userid = :shopid');
  $stmt->execute(['shopid' => $shopid]);
  $result = $stmt->fetchall(PDO::FETCH_ASSOC);

  foreach ($result as $row) {
    $id = $row['id'];
    $itemid = $row['itemid'];
    $itemprice = 0;
    $itemname = "";

    // Select item name that matches item id
    $sth = $dbh -> prepare("SELECT itemname from items WHERE id = :itemid");
    $sth->execute(['itemid' => $itemid]); 
    $result = $sth -> fetch();
    $itemname = $result["itemname"];

    // Select item price that matches item id
    $sth = $dbh -> prepare("SELECT itemprice from users_shops WHERE id = :id");
    $sth->execute(['id' => $id]); 
    $result = $sth -> fetch();
    $itemprice = $result["itemprice"];


    // Select item image that matches item id
    $sth = $dbh -> prepare("SELECT itemimage from items WHERE id = :itemid");
    $sth->execute(['itemid' => $itemid]); 
    $result = $sth -> fetch();
    $itemimage = $result["itemimage"];



    
    echo '<div class="manage-shops-item"><div class="shops-item-img-container"><img class="img-thumbnail" src="images/items/' . $itemimage . '" /></div>';
    echo '<h6>' . $itemname . '</h6>';



    echo '<div class="yourprice">';
    echo '<form method="post">';
    echo '<input type="text" class="form-control" id="yourprice" name="yourprice" style="float: left; max-width: 100px;" value="'. $itemprice .'" required>';


    echo '<input type="hidden" class="form-control" id="id" name="id" value="'. $id .'" required>';


    echo '<button style="float: left; margin-left: 4px;" type="submit" class="btn btn-primary">Update Price</button>';
    echo '</form>';
    echo '</div>';


    echo '<div class="purchase" style="margin-top: 4px;">';
    echo '<a class="btn btn-default" href="buyfromusershop.php?shopid=' . $shopid . '&id='. $id . '">Put into your Inventory</a>';
    echo ' <a class="btn btn-default" href="manage-shop.php?action=discarditem&id=' . $id .'">Discard Item</a>';
    echo '</div></div>'; 
    


  }

?>



<?php
  include 'includes/footer.php';
?>