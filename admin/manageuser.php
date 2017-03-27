<?php	
	include '../includes/database-connection.php';
	include 'includes/header.php';

	$selecteduserid = $_GET['userid'];


  	if (isset($_POST['banksubmit'])) {
  		$update_balance = $_POST['balance'];

  		$stmt = $dbh->prepare('UPDATE bank SET balance = :balance  WHERE userid = :userid');
		$stmt->execute(['balance' => $update_balance, 'userid' => $selecteduserid]);

		header('Location: manageuser.php?userid=' . $selecteduserid);
  	}

	// Upload and Rename avatar file
	if (isset($_POST['filesubmit']))
	{
		$filename = $_FILES["file"]["name"];
		$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
		$file_ext = substr($filename, strripos($filename, '.')); // get file name
		$filesize = $_FILES["file"]["size"];
		$allowed_file_types = array('.png','.gif','.jpg');	


		$sth = $dbh -> prepare("SELECT avatar from users WHERE userid = :userid");
		$sth->execute(['userid' => $selecteduserid]); 
		$result = $sth -> fetch();
		$avatar = $result["avatar"];


		$sth = $dbh -> prepare("SELECT username from users WHERE userid = :userid");
		$sth->execute(['userid' => $selecteduserid]); 
		$result = $sth -> fetch();
		$avatar_username = $result["username"];


		if (in_array($file_ext,$allowed_file_types) && ($filesize < 200000))
		{	
			// Rename file
			$newfilename = $avatar_username . $file_ext;
			
			// Delete old avatar
			if ($avatar === null) {
				// Do nothing
			} else {
				unlink('../avatars/' . $avatar);
			}

			// file already exists error
			move_uploaded_file($_FILES["file"]["tmp_name"], "../avatars/" . $newfilename);
			echo "File uploaded successfully.";


			// Save avatar to database
			$stmt = $dbh->prepare('UPDATE users SET avatar = :avatar  WHERE userid = :userid');
			$stmt->execute(['avatar' => $newfilename, 'userid' => $selecteduserid]);

		}
		elseif (empty($file_basename))
		{	
			// file selection error
			echo "Please select a file to upload.";
		} 
		elseif ($filesize > 200000)
		{	
			// file size error
			echo "The file you are trying to upload is too large.";
		}
		else
		{
			// file type error
			echo "Only these file typs are allowed for upload: " . implode(', ',$allowed_file_types);
			unlink($_FILES["file"]["tmp_name"]);
		}

		header('Location: manageuser.php?userid=' . $selecteduserid);
	}


  if (isset($_POST['userid'])) {
  	// Save changes
	$update_userid = $_POST['userid'];
	$update_username = $_POST['username'];
	$update_password = $_POST['password'];
	$update_virtualcurrency1 = $_POST['virtualcurrency1'];
	$update_virtualcurrency2 = $_POST['virtualcurrency2'];
	$update_shoptill = $_POST['shoptill'];
	$update_accounttype = $_POST['accounttype'];


	if ($update_password == "" || $update_password === null) {
		$sth = $dbh -> prepare("SELECT password from users WHERE userid = :userid");
		$sth->execute(['userid' => $update_userid]); 
		$r = $sth -> fetch();
		$update_password = $r["password"];
	} else {
		// Salt new password
		$salt = "3dN9OcVYt9v2";
		$epass = md5($update_password . $salt);
		$update_password = $epass;
	}


	// Rename avatar file
	$sth = $dbh -> prepare("SELECT username from users WHERE userid = :userid");
	$sth->execute(['userid' => $selecteduserid]); 
	$result = $sth -> fetch();
	$user_name = $result["username"];

	$sth = $dbh -> prepare("SELECT avatar from users WHERE userid = :userid");
	$sth->execute(['userid' => $selecteduserid]); 
	$result = $sth -> fetch();
	$user_avatar = $result["avatar"];



	if ($update_username != $user_name && ($user_avatar != null || $user_avatar != "")) {

		$file = "../avatars/" . $user_avatar;
		$ext = pathinfo($file, PATHINFO_EXTENSION);

		$newfilename = $update_username . '.' . $ext;

		$stmt = $dbh->prepare('UPDATE users SET avatar = :avatar  WHERE userid = :userid');
		$stmt->execute(['avatar' => $newfilename, 'userid' => $selecteduserid]);

		rename("../avatars/" . $file, "../avatars/" . $newfilename);
	}

	// End rename avatar file





	$stmt = $dbh->prepare("
	UPDATE users
	SET 
	userid = :userid,
	username = :username,
	password = :password,
	virtualcurrency1 = :virtualcurrency1,
	virtualcurrency2 = :virtualcurrency2,
	shoptill = :shoptill,
	account_type = :accounttype
	WHERE 
	userid = :userid
	");	
	$stmt->bindParam(':userid', $update_userid);
	$stmt->bindParam(':username', $update_username);
	$stmt->bindParam(':password', $update_password);
	$stmt->bindParam(':virtualcurrency1', $update_virtualcurrency1);
	$stmt->bindParam(':virtualcurrency2', $update_virtualcurrency2);
	$stmt->bindParam(':shoptill', $update_shoptill);
	$stmt->bindParam(':accounttype', $update_accounttype);
	$stmt->execute();

  	header('Location: manageuser.php?userid=' . $selecteduserid);
  	}


	$stmt = $dbh->prepare('SELECT userid, username, virtualcurrency1, virtualcurrency2, shoptill, avatar, account_type FROM users WHERE userid = :userid');
	$stmt->execute(['userid' => $selecteduserid]);
	$result = $stmt->fetchall(PDO::FETCH_ASSOC);


	foreach ($result as $row) {
		$manage_userid = $row['userid'];
		$manage_username = $row['username'];
		$manage_virtualcurrency1 = $row['virtualcurrency1'];
		$manage_virtualcurrency2 = $row['virtualcurrency2'];
		$manage_shoptill = $row['shoptill'];
		$manage_avatar = $row['avatar'];
		$manage_accounttype = $row['account_type'];
	}
?>

<ol class="breadcrumb">
  <li><a href="index.php">Admin Control Panel</a></li>
  <li><a href="users.php">Users</a></li>
  <li class="active"><?php echo $manage_username; ?></li>
</ol>

<h1>Manage User Account</h1>

<h2><?php echo $manage_username; ?></h2>

<form action="" method="post">
	<!--
	<div class="form-group">
		<label for="username">User ID:</label>
		<input type="text" class="form-control" name=""  placeholder="" value='<?php echo $manage_userid; ?>' disabled>
	-->
		<input type="hidden" class="form-control" name="userid"  placeholder="" value='<?php echo $manage_userid; ?>'>
	<!-- 
	</div> 
	-->
	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" class="form-control" name="username" placeholder="" value='<?php echo $manage_username; ?>'>
		<!--
		<input type="hidden" class="form-control" name="username"  placeholder="" value='<?php echo $manage_username; ?>'>
		-->
	</div>
	<div class="form-group">
		<label for="password">Change Password</label>
		<input type="text" class="form-control" name="password" aria-describedby="passwordHelp">
		<p id="passwordHelp" class="form-text text-muted">
			Optional
		</p>
	</div>
	<div class="form-group">
		<label for="virtualcurrency1"><?php echo $settings_virtualcurrency1; ?></label>
		<input type="text" class="form-control" name="virtualcurrency1" value='<?php echo $manage_virtualcurrency1; ?>' required>
	</div>
	<div class="form-group">
		<label for="virtualcurrency2"><?php echo $settings_virtualcurrency2; ?></label>
		<input type="text" class="form-control" name="virtualcurrency2" value='<?php echo $manage_virtualcurrency2; ?>' required>
	</div>
	<div class="form-group">
		<label for="shoptill">Shop Till</label>
		<input type="text" class="form-control" name="shoptill" value='<?php echo $manage_shoptill; ?>' required>
	</div>
	<div class="form-group">
		<label for="accounttype">Account Type</label>
		<select class="form-control" name="accounttype" required>
			<?php 
				if ($manage_accounttype == 'user') {
					echo '<option value="user" selected>User</option>';
					echo '<option value="admin">Admin</option>';
				} else {
					echo '<option value="user">User</option>';
					echo '<option value="admin" selected>Admin</option>';
				}
			?>

		</select>
	</div>
	<input type="submit" name="submit" class="btn btn-primary" value="Save Changes">
</form>

<hr>
<h4>User Avatar</h4>


<?php
	if ($manage_avatar != null) {
		echo '<div class="row">';
		echo '<div class="col-md-2">';
		echo '<div class="thumbnail">';

		echo '<a href="../avatars/' . $manage_avatar . '">';
		echo '<img class="img-thumbnail" src="../avatars/' . $manage_avatar . '" /></a>';

		echo '</div></div></div>';
	}

	echo '<form action="" enctype="multipart/form-data" method="post">';
	echo '<input id="file" name="file" type="file" required><br>';
	echo '<input id="FileSubmit" class="btn btn-primary" name="filesubmit" type="submit" value="Upload" />';
	echo '</form>';
?>

<hr>
<h4>User Bank Account</h4>
<?php
	$sth = $dbh -> prepare("SELECT balance from bank WHERE userid = :userid");
	$sth->execute(['userid' => $selecteduserid]); 
	$result = $sth -> fetch();
	$manage_balance = $result["balance"];
?>
<form action="" method="post">
	<div class="form-group">
		<label for="balance">Balance</label>
		<input type="text" class="form-control" name="balance"  placeholder="" value='<?php echo $manage_balance; ?>' required>
	</div>
	<input type="submit" name="banksubmit" class="btn btn-primary" value="Update Balance">
</form>



<hr>
<h4>Delete Account</h4>
<?php
	if ($userid == $manage_userid) {
		//echo '<a href="deleteuser.php?userid=' . $manage_userid . '">';
		echo '<p>You cannot delete this account.</p>';
		echo '<button type="button" class="btn btn-danger" disabled>Delete Account</button>';
	} else {
		echo '<p>This action is permanent.</p>';
		echo '<a href="deleteuser.php?userid=' . $manage_userid . '">';
		echo '<button type="button" class="btn btn-danger">Delete Account</button></a>';		
	}

?>


<?php
  include('includes/footer.php');
?>