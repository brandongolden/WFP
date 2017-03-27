<?php
  include '../includes/database-connection.php';
  include 'includes/header.php';


	$manageshopid = $_GET['shopid'];


	$sth = $dbh -> prepare("SELECT shopname from shops WHERE shopid = :shopid");
	$sth->execute(['shopid' => $manageshopid]); 
	$result = $sth -> fetch();
	$shopname = $result["shopname"];


  $sth = $dbh -> prepare("SELECT shopimage from shops WHERE shopid = :shopid");
  $sth->execute(['shopid' => $manageshopid]); 
  $result = $sth -> fetch();
  $shopimage = $result["shopimage"];


	if (isset($_POST['shopnamesubmit'])) {
    $update_shopname = $_POST['shopname'];

  	$stmt = $dbh->prepare('UPDATE shops SET shopname = :shopname  WHERE shopid = :shopid');
		$stmt->execute(['shopname' => $update_shopname, 'shopid' => $manageshopid]);



    // Rename shop image

    $file = "../shops/" . $shopimage;
    $ext = pathinfo($file, PATHINFO_EXTENSION);

    $newfilename = $update_shopname . '-' . $manageshopid . '.' . $ext;

    if ($shopimage != "default.png") {
      $stmt = $dbh->prepare('UPDATE shops SET shopimage = :shopimage  WHERE shopid = :shopid');
      $stmt->execute(['shopimage' => $newfilename, 'shopid' => $manageshopid]);

      rename("../images/shops/" . $file, "../images/shops/" . $newfilename);      
    }


    // End rename shop image



		header('Location: manageshop.php?shopid=' . $manageshopid);
  }

  if (isset($_POST['addtoshop'])) {
    $additemid = $_POST['selectitem'];

    $stmt = $dbh->prepare("INSERT INTO shops_inventory (shopid, itemid)VALUES(:shopid, :itemid)");
    $stmt->bindParam(':shopid', $manageshopid);
    $stmt->bindParam(':itemid', $additemid);
    $stmt->execute();

    header('Location: manageshop.php?shopid=' . $manageshopid);
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
      $newfilename = $shopname . '-' . $manageshopid . $file_ext;
      
      // Delete old avatar
      if ($shopimage === null) {
        // Do nothing
      } else {
        if ($shopimage != "default.png") {
          unlink('../images/shops/' . $shopimage);
        }
      }

      // file already exists error
      move_uploaded_file($_FILES["file"]["tmp_name"], "../images/shops/" . $newfilename);
      echo "File uploaded successfully.";




      // Save avatar to database
      $stmt = $dbh->prepare('UPDATE shops SET shopimage = :shopimage  WHERE shopid = :shopid');
      $stmt->execute(['shopimage' => $newfilename, 'shopid' => $manageshopid]);

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

    header('Location: manageshop.php?shopid=' . $manageshopid);
  }

?>

<ol class="breadcrumb">
  <li><a href="index.php">Admin Control Panel</a></li>
  <li><a href="shops.php">Shops</a></li>
  <li class="active"><?php echo $shopname; ?></li>
</ol>

<h1>Manage Shop</h1>
<h2><?php echo $shopname; ?></h2>
<form action="" method="post">
	<div class="form-group">
		<label for="shopname">Shop Name</label>
		<input type="text" class="form-control" name="shopname" value='<?php echo $shopname; ?>' required>
	</div>
	<input type="submit" name="shopnamesubmit" class="btn btn-primary" value="Save Changes">
</form>


<hr>
<h4>Manage Shop Inventory</h4>


<table class="table">
<thead>
<tr>
  <th>Item Image</th>
  <th>Item Name</th>
  <th>Item Price</th>
  <th style="text-align: right;">Delete</th>
</tr>
</thead>
<tbody>
<?php
    $stmt = $dbh->prepare('SELECT * FROM shops_inventory WHERE shopid = :shopid');
    $stmt->execute(['shopid' => $manageshopid]);
    $result = $stmt->fetchall(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
      $id = $row['id'];
      $itemid = $row['itemid'];
      $itemprice = 0;
      $itemname = "";


      $sth = $dbh -> prepare("SELECT itemname from items WHERE id = :itemid");
      $sth->execute(['itemid' => $itemid]); 
      $result = $sth -> fetch();
      $itemname = $result["itemname"];

      $sth = $dbh -> prepare("SELECT itemprice from items WHERE id = :itemid");
      $sth->execute(['itemid' => $itemid]); 
      $result = $sth -> fetch();
      $itemprice = $result["itemprice"];

      $sth = $dbh -> prepare("SELECT itemimage from items WHERE id = :itemid");
      $sth->execute(['itemid' => $itemid]); 
      $result = $sth -> fetch();
      $itemimage = $result["itemimage"];


      echo "<tr>";
      echo '<td><img class="img-thumbnail" style="max-width: 50px; max-height: 50px;" src="../images/items/' . $itemimage . '" /></td>';
      echo "<td>" . $itemname . "</td>";
      echo "<td>" . $itemprice . "</td>";
      echo '<td style="text-align: right;"><a class="btn btn-default" href="delete-shop-item.php?id=' . $id . '">Delete</a></td>';
      echo "</tr>";
    }
?>
</tbody>
</table>

<hr>
<h4>Add To Shop</h4>

<form action="" method="post">
  <div class="form-group">
    <select name="selectitem" class="form-control">
      <?php

        $stmt = $dbh->prepare('SELECT * FROM items');
        $stmt->execute();
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
          $itemid = $row['id'];
          $itemname = $row['itemname'];
          $itemprice = $row['itemprice'];
          $itemimage = $row['itemimage'];

          echo '<option value="' . $itemid . '">' . $itemname . '</option>';
        }

      ?>
    </select>
  </div>
  <input type="submit" name="addtoshop" class="btn btn-primary" value="Add To Shop">
</form>


<hr>
<h4>Shop Image</h4>

<?php
  echo '<a href="../images/shops/' . $shopimage . '">';
  echo '<img class="img-thumbnail" src="../images/shops/' . $shopimage . '" /></a>';


  echo '<form action="" enctype="multipart/form-data" method="post">';
  echo '<input id="file" name="file" type="file" required><br>';
  echo '<input id="FileSubmit" class="btn btn-primary" name="filesubmit" type="submit" value="Upload" />';
  echo '</form>';
?>


<hr>
<h4>Delete Shop</h4>
<?php
    echo '<p>This action is permanent.</p>';
    echo '<a href="delete-shop.php?shopid=' . $manageshopid . '">';
    echo '<button type="button" class="btn btn-danger">Delete Shop</button></a>';    
?>


<?php
	include('includes/footer.php');
?>