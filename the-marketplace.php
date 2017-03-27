<?php
  include 'includes/database-connection.php';
  include 'includes/session.php';
  include 'includes/membersonly.php';

  // Page title
  $page_title = "The Marketplace";

  include 'includes/header.php';
?>

<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li><a href="shops.php">Shops</a></li>
  <li class="active">The Marketplace</li>
</ol>

<h2>
<?php   
  echo '<img style="max-width: 100px;" class="shops-img"  alt="The Marketplace" src="images/shops/the-marketplace.png" />';
?>
The Marketplace
</h2>


<?php
  $stmt = $dbh->prepare('SELECT userid, username, avatar FROM users');
  $stmt->execute();
  $result = $stmt->fetchall(PDO::FETCH_ASSOC);

  foreach ($result as $row) {
    $select_userid = $row['userid'];
    $select_username = $row['username']; 
    $select_avatar = $row['avatar'];

    if ($select_avatar === null || $select_avatar == "") {
      $select_avatar = "default/default.png";
    }    


    // Does the user have any items in their shop?
    $stmt = $dbh->prepare('SELECT * FROM users_shops WHERE userid = :userid');
    $stmt->bindParam(':userid', $select_userid);
    $stmt->execute();
    $result = $stmt->rowcount(PDO::FETCH_ASSOC);
    $shopinventory = $result;


    // Show user shop if they have items in it
    if ($shopinventory >= 1) {
      echo '<div class="profile"><div class="profile-img-container"><img alt="' . $select_username . '" class="img-thumbnail" src="avatars/' . $select_avatar . '" /></div>';
      echo '<a href="viewusershop.php?username=' . $select_username . '"><h6 style="margin-top:25px;">' . $select_username . "'s Shop</h6></a>";
      echo '<div class="viewprofile" style="width: 93px; height: 34px;"></div></div>';
    }


  }

  include 'includes/footer.php'

?>