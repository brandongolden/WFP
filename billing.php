<?php
  include 'includes/database-connection.php';
  include 'includes/session.php';
  include 'includes/membersonly.php';


  // Page title with name of virtual currency 2
  $page_title = "Buy " . $settings_virtualcurrency2;

  include 'includes/header.php';
?>


<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li><a href="my-account.php">My Account</a></li>
  <li class="active">Buy <?php echo $settings_virtualcurrency2; ?></li>
</ol>


<h2>Buy <?php echo $settings_virtualcurrency2; ?></h2>



<?php

  // Select virtual currency 2 packages ordered by price
  $stmt = $dbh->prepare('SELECT * FROM billing ORDER BY price asc');
  $stmt->execute();
  $result = $stmt->fetchall(PDO::FETCH_ASSOC);

  foreach ($result as $row) {
    $id = $row['id'];
    $packagename = $row['packagename'];
    $package_virtualcurrency = $row['virtualcurrency2'];
    $price = $row['price'];
    $packageimage = $row['packageimage'];

    // Change virtual currency 2 name to lowercase
    $settings_virtualcurrency2 = strtolower($settings_virtualcurrency2);
  
    
    echo '<div class="billing"><div class="billing-img-container"><img class="img-thumbnail" src="images/billing/' . $packageimage . '" /></div>';
    echo '<h6>' . $packagename . '</h6>';
    echo '<div class="purchase"><a class="btn btn-default" href="">' . $package_virtualcurrency . " " . $settings_virtualcurrency2 . " for $" . $price . '</a>';

    echo '</div></div>';
  }

?>



<?php
  include 'includes/footer.php';
?>