<?php  
  include 'includes/database-connection.php';
  include 'includes/session.php';
  include 'includes/membersonly.php';

  // Page title
  $page_title = "My Account";

  include 'includes/header.php';
?>

<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li class="active">My Account</li>
</ol>

<h2>My Account</h2>


<div class="row">
<div class="col-md-6">
<?php
	// Inventory
	echo '<div class="myaccount"><div class="myaccount-img-container"><img class="img-thumbnail" src="images/backpack.png" /></div>';
	echo '<a href="inventory.php"><h6>' . 'Inventory'. '</h6></a>';
	echo '<div class="myaccount-info">Manage your inventory</div></div>';



	// Avatar
	echo '<div class="myaccount"><div class="myaccount-img-container"><img class="img-thumbnail" src="images/man.png" /></div>';
	echo '<a href="avatar.php"><h6>' . 'Avatar'. '</h6></a>';
	echo '<div class="myaccount-info">Upload an avatar</div></div>';


	// Buy Points
	echo '<div class="myaccount"><div class="myaccount-img-container"><img class="img-thumbnail" src="images/credit-card.png" /></div>';
	echo '<a href="billing.php"><h6>' . 'Buy ' . $settings_virtualcurrency2 . '</h6></a>';
	echo '<div class="myaccount-info">Buy ' . $settings_virtualcurrency2 . '</div></div>';

?>
</div>
<div class="col-md-6">


<?php 
	// Modify Account Information
	echo '<div class="myaccount"><div class="myaccount-img-container"><img class="img-thumbnail" src="images/verification.png" /></div>';
	echo '<a href="modify-account-information.php"><h6>' . 'Modify Account Information'. '</h6></a>';
	echo '<div class="myaccount-info">Change your password</div></div>';


	// Edit Profile
	echo '<div class="myaccount"><div class="myaccount-img-container"><img class="img-thumbnail" src="images/user.png" /></div>';
	echo '<a href="edit-profile.php"><h6>' . 'Edit Profile'. '</h6></a>';
	echo '<div class="myaccount-info">Edit your profile</div></div>';
?>

</div>
</div>

<?php 	
	include 'includes/footer.php'; 
?>