<?php
  include 'includes/database-connection.php';
  include 'includes/session.php';
  include 'includes/membersonly.php';

  // Page title
  $page_title = "Shops";

  include 'includes/header.php';
?>

<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li class="active">Shops</li>
</ol>

<h2>Shops</h2>


<?php
  
  
  echo '<a href="the-marketplace.php"><div class="shops"><img alt="The Marketplace" class="img-responsive" style="" src="images/shops/the-marketplace.png' . '"><h5>' . 'The Marketplace' . '</h5></div></a>';

  echo '<a href="bank.php"><div class="shops"><img alt="Bank" class="img-responsive" style="" src="images/shops/bank.png' . '"><h5>' . 'Bank' . '</h5></div></a>';
  
  echo '<a href="lottery.php"><div class="shops"><img alt="Lottery" class="img-responsive" style="" src="images/shops/lottery.png' . '"><h5>' . 'Lottery' . '</h5></div></a>';
  
  // Select all shops from database
  $stmt = $dbh->prepare('SELECT * FROM shops');
  $stmt->execute();
  $result = $stmt->fetchall(PDO::FETCH_ASSOC);

  foreach ($result as $row) {
    $shopid = $row['shopid'];
    $shopname = $row['shopname'];        
    $shopimage = $row['shopimage'];

    echo '<a href="viewshop.php?shop=' . $shopname . '"><div class="shops"><img alt="' . $shopname . '" class="img-responsive" style="" src="images/shops/' . $shopimage . '"><h5>' . $shopname . '</h5></div></a>';

  }


  include 'includes/footer.php'

?>