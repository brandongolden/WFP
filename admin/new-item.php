<?php
	include '../includes/database-connection.php';
	include 'includes/header.php';

	if (isset($_POST['submit'])) {
		$itemname = $_POST['itemname'];
		$itemprice = $_POST['itemprice'];


		$stmt = $dbh->prepare("INSERT INTO items (itemname, itemprice)VALUES(:itemname, :itemprice)");
		$stmt->bindParam(':itemname', $itemname);
		$stmt->bindParam(':itemprice', $itemprice);
		$stmt->execute();
		

		$stmt = $dbh->query("SELECT LAST_INSERT_ID()");
		$itemid = $stmt->fetchColumn();



		$filename = $_FILES["file"]["name"];
		$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
		$file_ext = substr($filename, strripos($filename, '.')); // get file name
		$filesize = $_FILES["file"]["size"];
		$allowed_file_types = array('.png','.gif','.jpg');	



		if (in_array($file_ext,$allowed_file_types) && ($filesize < 200000))
		{	
			// Rename file
			$newfilename = $itemname . '-' . $itemid . $file_ext;
			
			
			if ($itemimage === null) {
				// Do nothing
			} else {
				unlink('../images/items/' . $itemimage);
			}

			// file already exists error
			move_uploaded_file($_FILES["file"]["tmp_name"], "../images/items/" . $newfilename);
			echo "File uploaded successfully.";




			// Save item image to database
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

		header('Location: items.php');
	}


?>

<ol class="breadcrumb">
  <li><a href="index.php">Admin Control Panel</a></li>
  <li><a href="items.php">Items</a></li>
  <li class="active">New Item</li>
</ol>

<h1>New Item</h1>
<form action="" enctype="multipart/form-data" method="post">
	<div class="form-group">
		<label for="itemname">Item Name</label>
		<input type="text" class="form-control" name="itemname" required>
	</div>
	<div class="form-group">
		<label for="itemprice">Item Price</label>
		<input type="text" class="form-control" name="itemprice" required>
	</div>

	<div class="form-group">
		<label for="file">Item Image</label>
		<input id="file" name="file" type="file" required>
	</div>
	<input type="submit" name="submit" class="btn btn-primary" value="Create Item">
</form>

<?php
	include('includes/footer.php');
?>