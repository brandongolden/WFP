<?php
	include '../includes/database-connection.php';
	include 'includes/header.php';
?>

<ol class="breadcrumb">
  <li><a href="index.php">Admin Control Panel</a></li>
  <li class="active">Shops</li>
</ol>

<h1>Shops <a href="new-shop.php"><button type="button" class="btn btn-primary" style="float: right;">New Shop</button></a></h1>

<table class="table">
<thead>
  <tr>
  	<th>Shop Image</th>
    <th>Shop Name</th>
    <th style="text-align: right;">Manage Shop</th>
    <th style="text-align: right;">Delete Shop</th>
  </tr>
</thead>
<tbody>
<?php

	$stmt = $dbh->prepare('SELECT * FROM shops');
	$stmt->execute();
	$result = $stmt->fetchall(PDO::FETCH_ASSOC);


	foreach ($result as $row) {
	    $shopid = $row['shopid'];
	    $shopname = $row['shopname'];
        $shopimage = $row['shopimage'];

	    echo '<tr>';
	   	echo '<td><img class="img-thumbnail" style="max-width: 50px; max-height: 50px;" src="../images/shops/' . $shopimage . '" /></td>';
	    echo '<td>' . $shopname . '</td>';
	   	echo '<td style="text-align: right;"><a class="btn btn-default" href="manageshop.php?shopid=' . $shopid . '">' . 'Manage</a></td>';
	    echo '<td style="text-align: right;"><a class="btn btn-default" href="delete-shop.php?shopid=' . $shopid . '">' . 'Delete</a></td>';
	    echo '</tr>';
  	}
?>	
</tbody>
</table>

<?php
  include('includes/footer.php');
?>