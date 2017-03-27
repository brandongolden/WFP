<?php
  include 'includes/database-connection.php';
  include 'includes/session.php';
  include 'includes/membersonly.php';

  // Page title
  $page_title = "Inventory";

  include 'includes/header.php';

?>


<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li><a href="my-account.php">My Account</a></li>
  <li class="active">Inventory</li>
</ol>


<h2>Inventory</h2>



  <?php
    // Select all items in user's inventory
    $stmt = $dbh->prepare('SELECT * FROM users_inventory WHERE userid = :userid');
    $stmt->execute(['userid' => $userid]);
    $result = $stmt->fetchall(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
      //$id = $row['id'];
      $id = $row['id'];
      $itemid = $row['itemid'];
      $itemname = "";

      // Select item name that matches item id
      $sth = $dbh -> prepare("SELECT itemname from items WHERE id = :itemid");
      $sth->execute(['itemid' => $itemid]); 
      $result = $sth -> fetch();
      $itemname = $result["itemname"];

      // Select item image that matches item id
      $sth = $dbh -> prepare("SELECT itemimage from items WHERE id = :itemid");
      $sth->execute(['itemid' => $itemid]); 
      $result = $sth -> fetch();
      $itemimage = $result["itemimage"];

      // Display item
      echo '<div class="inventory-item"><div class="shops-item-img-container"><img alt="' . $itemname . '" class="img-thumbnail" src="images/items/' . $itemimage . '" /></div>';
      echo '<h6>' . $itemname . '</h6>';
      echo '<div class="purchase"><a class="btn btn-default" href="put-into-your-shop.php?id=' . $id . '">Put into your Shop</a>';
      echo ' <a class="btn btn-default" href="discard-item.php?id=' . $id . '">Discard Item</a>';

      echo '</div></div>';
      
    }

  ?>

 


<?php
  include 'includes/footer.php';
?>