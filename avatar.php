<?php  
	include 'includes/database-connection.php';
 	include 'includes/session.php';
	include 'includes/membersonly.php';



	// Upload and Rename File

	if (isset($_POST['submit']))
	{
		$filename = $_FILES["file"]["name"];
		$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
		$file_ext = substr($filename, strripos($filename, '.')); // get file name
		$filesize = $_FILES["file"]["size"];
		$allowed_file_types = array('.png','.gif','.jpg');	



		if (in_array($file_ext,$allowed_file_types) && ($filesize < 1000000))
		{	
			// Rename file
			$newfilename = $username . $file_ext;
			
			// Delete old avatar
			if ($avatar === null) {
				// Do nothing
			} else {
				unlink('avatars/' . $avatar);
			}

			// file already exists error
			move_uploaded_file($_FILES["file"]["tmp_name"], "avatars/" . $newfilename);
			echo "File uploaded successfully.";




			// Save avatar to database
			$stmt = $dbh->prepare('UPDATE users SET avatar = :avatar  WHERE userid = :userid');
			$stmt->execute(['avatar' => $newfilename, 'userid' => $userid]);

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
		header('Location: avatar.php');
	}


	// Page title
	$page_title = "Avatar";
	
	include 'includes/header.php';

	// Select user avatar
	$sth = $dbh -> prepare("SELECT avatar from users WHERE userid = :userid");
	$sth->execute(['userid' => $userid]); 
	$result = $sth -> fetch();
	$avatar = $result["avatar"];
?>

<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li><a href="my-account.php">My Account</a></li>
  <li class="active">Avatar</li>
</ol>


<h2>Avatar</h2>


<?php
	// Display user's avatar if they have one
	if ($avatar != null) {
		echo '<a href="avatars/' . $avatar . '">';
		echo '<img style="max-width: 200px; margin-bottom: 10px;" class="img-thumbnail" src="avatars/' . $avatar . '" />';
		echo '</a>';
	}
?>


<!-- 
	Avatar image upload form
-->
<form enctype="multipart/form-data" method="post">

  <div class="form-group">
    <label for="file">Avatar</label>
    <input type="file" id="file" name="file" required>
    <p class="help-block">Allowed file types: png, gif, jpg <br> Max file size: 1 MB</p>

  </div>
  
  <button type="submit" id="submit" name="submit" class="btn btn-primary">Upload</button>
</form>



  
<?php
	include 'includes/footer.php';
?>