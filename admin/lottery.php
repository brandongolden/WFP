<?php
	include '../includes/database-connection.php';
	include 'includes/header.php';

	$name = "scratchcardprice";
	$sth = $dbh -> prepare("SELECT value from settings WHERE name = :name");
	$sth->execute(['name' => $name]); 
	$result = $sth -> fetch();
	$scratchcardprice = $result["value"];
	$scratchcardprice = (int)$scratchcardprice;

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$form_scratchcardprice = $_POST['scratchcardprice'];

	    $name = "scratchcardprice";
	    $stmt = $dbh->prepare('UPDATE settings SET value = :value  WHERE name = :name');
	    $stmt->execute(['value' => $form_scratchcardprice, 'name' => $name]);

	    header('Location: lottery.php');
	}

?>

<ol class="breadcrumb">
  <li><a href="index.php">Admin Control Panel</a></li>
  <li class="active">Lottery</li>
</ol>

<h1>Lottery</h1>

<form action="" method="post">

	<div class="form-group">
		<label for="title">Scratchcard Price</label>
		<input type="text" class="form-control" name="scratchcardprice" value='<?php echo $scratchcardprice; ?>' required>
	</div>



	<input type="submit" name="submit" class="btn btn-primary" value="Save Changes">
</form>


<?php
	include('includes/footer.php');
?>