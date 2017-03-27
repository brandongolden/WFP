<?php
	include '../includes/database-connection.php';
	include 'includes/header.php';


	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$form_title = $_POST['title'];
	    $form_virtualcurrency1 = $_POST['virtualcurrency1'];
	    $form_virtualcurrency2 = $_POST['virtualcurrency2'];

	    $name = "title";
	    $stmt = $dbh->prepare('UPDATE settings SET value = :value  WHERE name = :name');
	    $stmt->execute(['value' => $form_title, 'name' => $name]);

	    $name = "virtualcurrency1";
	    $stmt = $dbh->prepare('UPDATE settings SET value = :value  WHERE name = :name');
	    $stmt->execute(['value' => $form_virtualcurrency1, 'name' => $name]);

	    $name = "virtualcurrency2";
	    $stmt = $dbh->prepare('UPDATE settings SET value = :value  WHERE name = :name');
	    $stmt->execute(['value' => $form_virtualcurrency2, 'name' => $name]);

	    header('Location: settings.php');
	}

?>

<ol class="breadcrumb">
  <li><a href="index.php">Admin Control Panel</a></li>
  <li class="active">Settings</li>
</ol>

<h1>Settings</h1>

<form action="" method="post">

	<div class="form-group">
		<label for="title">Title</label>
		<input type="text" class="form-control" name="title" value='<?php echo $settings_title;?>' required>
	</div>

	<div class="form-group">
		<label for="virtualcurrency1">Virtual Currency 1 Name</label>
		<input type="text" class="form-control" name="virtualcurrency1" value='<?php echo $settings_virtualcurrency1;?>' required>
	</div>

	<div class="form-group">
		<label for="virtualcurrency2">Virtual Currency 2 Name</label>
		<input type="text" class="form-control" name="virtualcurrency2" value='<?php echo $settings_virtualcurrency2;?>' required>
	</div>

	<input type="submit" name="submit" class="btn btn-primary" value="Save Changes">
</form>


<?php
	include('includes/footer.php');
?>