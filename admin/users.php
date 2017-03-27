<?php
	include '../includes/database-connection.php';
	include 'includes/header.php';
?>

<ol class="breadcrumb">
  <li><a href="index.php">Admin Control Panel</a></li>
  <li class="active">Users</li>
</ol>

<h1>Users <a href="new-user-account.php"><button type="button" class="btn btn-primary" style="float: right;">Create User Account</button></a></h1>


<table class="table">
<thead>
  <tr>
    <th>Username</th>
    <th style="text-align: right;">Manage User Account</th>
    <th style="text-align: right;">Delete User Account</th>
  </tr>
</thead>
<tbody>
<?php


	$stmt = $dbh->prepare('SELECT userid, username, account_type FROM users');
	$stmt->execute();
	$result = $stmt->fetchall(PDO::FETCH_ASSOC);


	foreach ($result as $row) {
	    $user_id = $row['userid'];
	    $username = $row['username'];
	    $account_type = $row['account_type'];
        


	    echo '<tr>';
	    echo '<td>' . $username . '</td>';
	    //echo '<td><a class="" href="manageuser.php?userid=' . $user_id . '">' . $username . '</a></td>';

	   	echo '<td style="text-align: right;"><a class="btn btn-default" href="manageuser.php?userid=' . $user_id . '">' . 'Manage</a></td>';

	   	
	   	if ($userid == $user_id) {
	   		echo '<td style="text-align: right;"><a class="btn btn-default" disabled>' . 'Delete</a></td>';
	   	} else {
	   		echo '<td style="text-align: right;"><a class="btn btn-default" href="deleteuser.php?userid=' . $user_id . '">' . 'Delete</a></td>';
	   	}
	   	


	    echo '</tr>';
  	}
?>	
</tbody>
</table>

<?php
  include('includes/footer.php');
?>