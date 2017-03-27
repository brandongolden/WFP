<?php
	include 'includes/database-connection.php';
	include 'includes/session.php';
	include 'includes/membersonly.php';



 	if($_SERVER['REQUEST_METHOD'] == 'POST') {

		$id = $_POST['id'];
		$itemprice = $_POST['itemprice'];

		// Get itemid - What is the item?
		$sth = $dbh -> prepare("SELECT itemid from users_inventory WHERE id = :id");
		$sth->execute(['id' => $id]); 
		$result = $sth -> fetch();
		$itemid = $result["itemid"];


		// Delete item from user inventory
		$sth = $dbh -> prepare("DELETE from users_inventory WHERE id = :id");
		$sth->execute(['id' => $id]);

		// Move item to user shop
		$stmt = $dbh->prepare("INSERT INTO users_shops (userid, itemid, itemprice)VALUES(:userid, :itemid, :itemprice)");
		$stmt->bindParam(':userid', $userid);
		$stmt->bindParam(':itemid', $itemid);
		$stmt->bindParam(':itemprice', $itemprice);
		$stmt->execute();

		header('Location: inventory.php');
	}




	$page_title = "Put into your Shop";




	// Id in db table users_inventory for the item
	$id = $_GET['id'];


	// Verify user owns that item
	$sth = $dbh -> prepare("SELECT userid from users_inventory WHERE id = :id");
	$sth->execute(['id' => $id]); 
	$result = $sth -> fetch();
	$owner = $result["userid"];


	if ($owner != $userid) {
		header('Location: inventory.php');
	}


	// Select itemid
	$sth = $dbh -> prepare("SELECT itemid from users_inventory WHERE id = :id");
	$sth->execute(['id' => $id]); 
	$result = $sth -> fetch();
	$itemid = $result["itemid"];

	// Look up item name using $itemid
	$sth = $dbh -> prepare("SELECT itemname from items WHERE id = :itemid");
	$sth->execute(['itemid' => $itemid]); 
	$result = $sth -> fetch();
	$itemname = $result["itemname"];

	
	$sth = $dbh -> prepare("SELECT itemimage from items WHERE id = :itemid");
	$sth->execute(['itemid' => $itemid]); 
	$result = $sth -> fetch();
	$itemimage = $result["itemimage"];


	include 'includes/header.php';
?>

<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li><a href="my-account.php">My Account</a></li>
  <li><a href="inventory.php">Inventory</a></li>
  <li class="active">Put into your shop</li>
</ol>


<h2>Put into your Shop</h2>

<?php
      echo '<div class="shops-item"><div class="shops-item-img-container"><img class="img-thumbnail" src="images/items/' . $itemimage . '" /></div>';
      echo '<h6>' . $itemname . '</h6>';
      echo '<div class="purchase"></div></div>';

?>
<form action="" method="post" class="putintoyourshop">
  <div class="form-group">
    <label for="itemprice">Item Price</label>
    <input type="text" class="form-control" id="itemprice" name="itemprice" required>
  </div>
   <input type="hidden" class="form-control" id="id" name="id" value='<?php echo $id; ?>' required>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>





<?php
	include 'includes/footer.php';
?>