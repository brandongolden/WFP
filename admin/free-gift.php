<?php
	include '../includes/database-connection.php';
	include 'includes/header.php';

	if (isset($_POST['additem'])) {
	    $additemid = $_POST['selectitem'];

	    $stmt = $dbh->prepare("INSERT INTO free_gift (itemid)VALUES(:itemid)");
	    $stmt->bindParam(':itemid', $additemid);
	    $stmt->execute();

	    header('Location: free-gift.php');
  	}

  	if (isset($_GET['delete'])) {
  		$deleteid = $_GET['delete'];
  		$sth = $dbh -> prepare("DELETE from free_gift WHERE id = :id");
		$sth->execute(['id' => $deleteid]);
		header('Location: free-gift.php');
  	}

?>

<ol class="breadcrumb">
  <li><a href="index.php">Admin Control Panel</a></li>
  <li class="active">Free Gift</li>
</ol>

<h1>Free Gift</h1>


<h4>Free Gift Items</h4>


<table class="table">
<thead>
<tr>
  <th>Item Image</th>
  <th>Item Name</th>
  <th style="text-align: right;">Delete</th>
</tr>
</thead>
<tbody>
<?php
    $stmt = $dbh->prepare('SELECT * FROM free_gift');
    $stmt->execute();
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
      echo '<td style="text-align: right;"><a class="btn btn-default" href="free-gift.php?delete=' . $id . '">Delete</a></td>';
      echo "</tr>";
    }
?>
</tbody>
</table>




<hr>
<h4>Add Items</h4>
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

          echo '<option value="' . $itemid . '">' . $itemname . '</option>';
        }

      ?>
    </select>
  </div>
  <input type="submit" name="additem" class="btn btn-primary" value="Add Item">
</form>


<?php
	include('includes/footer.php');
?>