<?php
	include '../includes/database-connection.php';
	include 'includes/header.php';
?>

<ol class="breadcrumb">
  <li><a href="index.php">Admin Control Panel</a></li>
  <li class="active">Items</li>
</ol>

<h1>Items <a href="new-item.php"><button type="button" class="btn btn-primary" style="float: right;">New Item</button></a></h1>

<table class="table">
<thead>
  <tr>
    <th>Item Image</th>
    <th>Item Name</th>
    <th  style="text-align: right;">Manage Item</th>
    <th  style="text-align: right;">Delete Item</th>
  </tr>
</thead>
<tbody>
<?php

	$stmt = $dbh->prepare('SELECT * FROM items');
	$stmt->execute();
	$result = $stmt->fetchall(PDO::FETCH_ASSOC);


	foreach ($result as $row) {
	    $itemid = $row['id'];
	    $itemname = $row['itemname'];
	    $itemprice = $row['itemprice'];
	    $itemimage = $row['itemimage'];
        

	    echo '<tr>';
	   	echo '<td><img class="img-thumbnail" style="max-width: 50px; max-height: 50px;" src="../images/items/' . $itemimage . '" /></td>';
	    echo '<td>' . $itemname . '</td>';
	   	echo '<td  style="text-align: right;"><a class="btn btn-default" href="manage-item.php?itemid=' . $itemid . '">' . 'Manage</a></td>';
	    echo '<td  style="text-align: right;"><a class="btn btn-default" href="delete-item.php?itemid=' . $itemid . '">' . 'Delete</a></td>';
	    echo '</tr>';
  	}
?>	
</tbody>
</table>

<?php
  include('includes/footer.php');
?>