<?php
  include 'includes/database-connection.php';
  include 'includes/session.php';

  // If user is logged in redirect them to index.php
  if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
  }

  // Page title
  $page_title = "Sign up";

  include 'includes/header.php';
?>

<?php
  // Username match found error message
  if (isset($_GET['error']) == "usernamematch") {
    echo '<div class="alert alert-danger alert-dismissable">';
    echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    echo '<strong>Error!</strong> Username already exists. Please try again.';
    echo '</div>';
  }
?>

<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li class="active">Sign Up</li>
</ol>


<div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4">
    <h2>Sign up</h2>

    <form action="createaccount.php" method="post">
      <div class="form-group">
        <label for="user">Username</label>
        <input class="form-control" type="text" id="user" name="user" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input class="form-control" type="password" id="password" name="password" required>
      </div>
      
      <button type="submit" class="btn btn-primary btn-block">Sign up</button>
    </form>

  </div>
  <div class="col-md-4"></div>
</div>

<?php
  include 'includes/footer.php';
?>