<?php
  include 'includes/database-connection.php';
  include 'includes/session.php';
  include 'includes/membersonly.php';

  // Page title
  $page_title = "Bank";

  include 'includes/header.php';

  // Select user bank account balance
  $stmt = $dbh->prepare('SELECT balance FROM bank WHERE userid = :userid');
  $stmt->execute(['userid' => $userid]);
  $result = $stmt->fetchall(PDO::FETCH_ASSOC);
   
  foreach ($result as $row) {
    // Store user bank account balance in variable
    $balance = $row['balance'];
  }

?>


<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li><a href="shops.php">Shops</a></li>
  <li class="active">Bank</li>
</ol>

<h2>
<?php
echo '<img style="max-width: 100px;" class="shops-img"  src="images/shops/bank.png" />';
?>
Bank
</h2>

<!--
  Display user's bank account balance
-->
<h5>Bank Account Balance: <?php echo number_format($balance) . ' ' . $settings_virtualcurrency1; ?></h5>




<div class="row">
<div class="col-md-4">

<!-- 
  Make a withdrawal form
-->
<form action="banking.php?action=withdraw" method="post">
  <div class="form-group">
    <label for="withdraw">Make a Withdrawal</label>
    <input type="text" class="form-control" id="withdraw" name="withdraw" required>
  </div>

  <button type="submit" class="btn btn-primary">Withdraw</button>
</form>

</div>
<div class="col-md-4">

<!--
  Deposit virtual currency 1 form
-->
<form action="banking.php?action=deposit" method="post">
  <div class="form-group">
    <label for="deposit">Deposit <?php echo $settings_virtualcurrency1; ?></label>
    <input type="text" class="form-control" id="deposit" name="deposit" required>
  </div>

  <button type="submit" class="btn btn-primary">Deposit</button>
</form>

</div>
</div>


<?php
  include 'includes/footer.php';
?>