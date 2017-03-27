<?php
  include 'includes/database-connection.php';
  include 'includes/session.php';
  include 'includes/membersonly.php';

  // Page title
  $page_title = "Modify Account Information";



  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Update password
    $salt = "3dN9OcVYt9v2";
    $password = md5($_POST['password'] . $salt);
    $username = $username;

    $stmt = $dbh->prepare("
    UPDATE users
      SET 
      password = :password
    WHERE 
    username = :username
    ");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    header('Location: modify-account-information.php?message=success');

  }

  include 'includes/header.php';
?>

<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li><a href="my-account.php">My Account</a></li>
  <li class="active">Modify Account Information</li>
</ol>

<?php
  // Password change success message
  if (isset($_GET['message'])) {
    echo '<div class="alert alert-success alert-dismissable">';
    echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    echo '<strong>Success!</strong> Password has been changed.';
    echo '</div>';
  }
?>

<h2>Modify Account Information</h2>




<form action="modify-account-information.php" method="post">
 
  <div class="form-group">
    <label for="password">New Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="" required>
  </div>

  <button type="submit" class="btn btn-primary">Update Password</button>
</form>

<?php
  include 'includes/footer.php';
?>