<?php
	include '../includes/database-connection.php';
	include 'includes/header.php';


	if (isset($_POST['username'])) {

		$new_username = $_POST['username'];

		$stmt = $dbh->prepare('SELECT * FROM users WHERE username = :username');
		$stmt->bindParam(':username', $new_username);
		$stmt->execute();
		$result = $stmt->rowcount(PDO::FETCH_ASSOC);
		$usernamematch = $result;

		// Check if username already exists
		if ($usernamematch >= 1) {
			//header('Location: users.php');
			echo '<div class="alert alert-danger"><strong>Error:</strong> Username already exists. Please try again.</div>';
		} else {
			$salt = "3dN9OcVYt9v2";
			$new_password = md5($_POST['password'] . $salt);

			$stmt = $dbh->prepare("INSERT INTO users (username, password)VALUES(:username, :password)");
			$stmt->bindParam(':username', $new_username);
			$stmt->bindParam(':password', $new_password);
			$stmt->execute();		




			$sth = $dbh -> prepare("SELECT userid from users WHERE username = :username");
			$sth->execute(['username' => $new_username]); 
			$result = $sth -> fetch();
			$new_userid = $result["userid"];


			$new_balance = 0;

			$stmt = $dbh->prepare("INSERT INTO bank (userid, balance)VALUES(:userid, :balance)");
			$stmt->bindParam(':userid', $new_userid);
			$stmt->bindParam(':balance', $new_balance);
			$stmt->execute();	

			header('Location: users.php');
		}
	}

?>

<ol class="breadcrumb">
  <li><a href="index.php">Admin Control Panel</a></li>
  <li><a href="users.php">Users</a></li>
  <li class="active">Create User Account</li>
</ol>

<h1>Create User Account</h1>

<form action="" method="post">
	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" class="form-control" name="username" placeholder="" required>
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		<input type="text" class="form-control" name="password" required>
	</div>

	<input type="submit" name="submit" class="btn btn-primary" value="Create Account">
</form>


<?php
	include('includes/footer.php');
?>