<?php
  include '../includes/database-connection.php';
  include 'includes/header.php';


  $stmt = $dbh->prepare('SELECT * FROM users');
  $stmt->execute();
  $result = $stmt->rowcount(PDO::FETCH_ASSOC);
  $users = $result;

  $stmt = $dbh->prepare('SELECT * FROM shops');
  $stmt->execute();
  $result = $stmt->rowcount(PDO::FETCH_ASSOC);
  $shops = $result;

  $stmt = $dbh->prepare('SELECT * FROM items');
  $stmt->execute();
  $result = $stmt->rowcount(PDO::FETCH_ASSOC);
  $items = $result;
?>


<h1>Admin Home</h1>

<table class="table">
<thead>
	<th>Statistic</th>
	<th>Value</th>
</thead>
<tbody>
	<tr>
		<td>Users Count</td>
		<td><?php echo $users; ?></td>
	</tr>
	<tr>
		<td>Shops Count</td>
		<td><?php echo $shops; ?></td>
	</tr>
	 <tr>
		<td>Items Count</td>
		<td><?php echo $items; ?></td>
	</tr>
</tbody>
</table>

<?php
  include('includes/footer.php');
?>