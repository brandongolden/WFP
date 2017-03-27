<?php
	include '../includes/database-connection.php';
	include 'includes/header.php';

	$itemid = $_GET['itemid'];


	$sth = $dbh -> prepare("SELECT itemname from items WHERE id = :id");
	$sth->execute(['id' => $itemid]); 
	$result = $sth -> fetch();
	$itemname = $result["itemname"];

	$sth = $dbh -> prepare("SELECT itemprice from items WHERE id = :id");
	$sth->execute(['id' => $itemid]); 
	$result = $sth -> fetch();
	$itemprice = $result["itemprice"];

	$sth = $dbh -> prepare("SELECT itemimage from items WHERE id = :id");
	$sth->execute(['id' => $itemid]); 
	$result = $sth -> fetch();
	$itemimage = $result["itemimage"];


	if (isset($_POST['submit'])) {
		$update_itemname = $_POST['itemname'];
		$update_itemprice = $_POST['itemprice'];

		$stmt = $dbh->prepare('UPDATE items SET itemname = :itemname, itemprice = :itemprice  WHERE id = :id');
		$stmt->execute(['itemname' => $update_itemname, 'itemprice' => $update_itemprice, 'id' => $itemid]);

		header('Location: manage-item.php?itemid=' . $itemid);
	}

	if (isset($_POST['filesubmit'])) {
		$filename = $_FILES["file"]["name"];
		$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
		$file_ext = substr($filename, strripos($filename, '.')); // get file name
		$filesize = $_FILES["file"]["size"];
		$allowed_file_types = array('.png','.gif','.jpg');	



		if (in_array($file_ext,$allowed_file_types) && ($filesize < 200000))
		{	
			// Rename file
			$newfilename = $itemname . '-' . $itemid . $file_ext;
			
			// Delete old avatar
			if ($itemimage === null) {
				// Do nothing
			} else {
				unlink('../images/items/' . $itemimage);
			}

			// file already exists error
			move_uploaded_file($_FILES["file"]["tmp_name"], "../images/items/" . $newfilename);
			echo "File uploaded successfully.";




			// Save avatar to database
			$stmt = $dbh->prepare('UPDATE items SET itemimage = :itemimage  WHERE id = :itemid');
			$stmt->execute(['itemimage' => $newfilename, 'itemid' => $itemid]);

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

		header('Location: manage-item.php?itemid=' . $itemid);
	}
?>

<ol class="breadcrumb">
  <li><a href="index.php">Admin Control Panel</a></li>
  <li><a href="items.php">Items</a></li>
  <li class="active"><?php echo $itemname; ?></li>
</ol>

<h1>Manage Item</h1>
<h2><?php echo $itemname; ?></h2>
<form action="" method="post">
	<div class="form-group">
		<label for="itemname">Item Name</label>
		<input type="text" class="form-control" name="itemname" value='<?php echo $itemname; ?>' required>
	</div>
	<div class="form-group">
		<label for="itemprice">Item Price</label>
		<input type="text" class="form-control" name="itemprice" value='<?php echo $itemprice; ?>' required>
	</div>
	<input type="submit" name="submit" class="btn btn-primary" value="Save Changes">
</form>



<hr>
<h4>Item Image</h4>
<?php
	echo '<a href="../images/items/' . $itemimage . '">';
	echo '<img class="img-thumbnail" src="../images/items/' . $itemimage . '" /></a>';


	echo '<form action="" enctype="multipart/form-data" method="post">';
	echo '<input id="file" name="file" type="file" required><br>';
	echo '<input id="FileSubmit" class="btn btn-primary" name="filesubmit" type="submit" value="Upload" />';
	echo '</form>';
?>



<hr>
<h4>Delete Item</h4>
<p>This action is permanent.</p>
<?php echo '<a class="btn btn-danger" href="delete-item.php?itemid=' . $itemid . '">' . 'Delete Item</a>'; ?>

<?php
	include('includes/footer.php');
?>