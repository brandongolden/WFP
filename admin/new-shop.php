<?php
	include '../includes/database-connection.php';
	include 'includes/header.php';

	if (isset($_POST['shopname'])) {
		$new_shopname = $_POST['shopname'];

		$stmt = $dbh->prepare('SELECT * FROM shops WHERE shopname = :shopname');
		$stmt->bindParam(':shopname', $new_shopname);
		$stmt->execute();
		$result = $stmt->rowcount(PDO::FETCH_ASSOC);
		$shopnamematch = $result;

		// Check if username already exists
		if ($shopnamematch >= 1) {
			//header('Location: users.php');
			echo '<div class="alert alert-danger"><strong>Error:</strong> Shop name already exists. Please try again.</div>';
		} else {
			$shopname = $_POST['shopname'];
			$stmt = $dbh->prepare("INSERT INTO shops (shopname)VALUES(:shopname)");
			$stmt->bindParam(':shopname', $shopname);
			$stmt->execute();
			header('Location: shops.php');
		}
	}
?>

<ol class="breadcrumb">
  <li><a href="index.php">Admin Control Panel</a></li>
  <li><a href="shops.php">Shops</a></li>
  <li class="active">New Shop</li>
</ol>

<h1>New Shop</h1>
<form action="" method="post">
	<div class="form-group">
		<label for="shopname">Shop Name</label>
		<input type="text" class="form-control" name="shopname" placeholder="" required>
	</div>

	<input type="submit" name="submit" class="btn btn-primary" value="Submit">
</form>

<?php
	include('includes/footer.php');
?>