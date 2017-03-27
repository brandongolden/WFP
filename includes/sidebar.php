<div class="sidebar">

<?php 
	// Show login form if user is not logged in
	if (!isset($_SESSION['user_id'])) { 
?>
<div class="box">
	<div class="box-top">
		Login
	</div>
	<div class="box-content">
	    <form method="post" action="login.php">
	      <div class="form-group">
	        <label class="sr-only" for="username_li">Username</label>
	        <input class="form-control" type="text" id="username_li" name="username_li" placeholder="Username" required>
	      </div>
	      <div class="form-group">
	        <label class="sr-only" for="password_li">Password</label>
	        <input class="form-control" type="password" id="password_li" name="password_li" placeholder="Password" required>
	      </div>
	      
	      <button type="submit" class="btn btn-primary btn-block">Login</button>
	    </form>
	</div>
</div>
<?php
	}
?>



<?php 
	// If user is logged in show free gift
	if (isset($_SESSION['user_id'])) { 
?>
<div class="box">
	<div class="box-top">
		Free Gift
	</div>
	<div class="box-content">

	<?php
		// If user has not got free gift or if one day has passed since they got the last free gift
		if ($free_gift_datetime == null || $olderthanoneday == true) {
	
			echo '<a href="index.php?action=freegift">';
			echo '<img class="img-responsive" style="display: block; margin: auto; margin-top: 15px; margin-bottom: 15px;" src="images/gift.png">';
			echo '</a>';

		} else {

			// Select free gift item id
			$sth = $dbh -> prepare("SELECT free_gift_itemid from users WHERE userid = :userid");
			$sth->execute(['userid' => $userid]); 
			$result = $sth -> fetch();
			$free_gift_itemid = $result["free_gift_itemid"];

			// Select free gift item image
			$sth = $dbh -> prepare("SELECT itemimage from items WHERE id = :id");
			$sth->execute(['id' => $free_gift_itemid]); 
			$result = $sth -> fetch();
			$itemimage = $result["itemimage"];

			// Select free gift item name
			$sth = $dbh -> prepare("SELECT itemname from items WHERE id = :id");
			$sth->execute(['id' => $free_gift_itemid]); 
			$result = $sth -> fetch();
			$itemname = $result["itemname"];

			// Display free gift item user got
			echo '<img style="margin: auto; display: block;" class="img-thumbnail" src="images/items/' . $itemimage . '">';
			echo '<h5 style="text-align: center;">' . $itemname . '</h5>';

		}
	?>
	</div>
</div>
<?php
	
	}
?>

</div>