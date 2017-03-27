<?php
  include 'includes/database-connection.php';
  include 'includes/session.php';

  // If user is logged in already redirect to index.php
  if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
  }

  // Page title
  $page_title = "Login";


  // Password salt
  $salt = "3dN9OcVYt9v2";

  // If username and password are not null
  if (isset($_POST['username_li']) != null && isset($_POST['password_li']) != null) {
    $usernameInput = $_POST['username_li'];

    // Salt password
    $passwordInput = md5($_POST['password_li'] . $salt);

    // Select user account that matches username and password
    $sth = $dbh->prepare('SELECT userid, username, password FROM users WHERE username = :username and password = :password');
    $sth->bindParam(':username', $usernameInput);
    $sth->bindParam(':password', $passwordInput);
    $sth->execute();
    $result = $sth->fetchAll();

    // If user account found and login success
    if (isset($result[0]['userid'])) {

      $user_id = $result[0]['userid'];

      // User ID
      $_SESSION['user_id'] = $user_id;

      // Form username
      $_SESSION['user_name'] = $usernameInput;

      // Form password
      $_SESSION['pass_word'] = $passwordInput;


      // Select username that matches user id
      foreach ($result as $row) {
        $sth = $dbh->prepare('SELECT username from users WHERE userid = :userid');
        $sth->bindParam(':userid', $row['userid']);
        $sth->execute();
        $result = $sth->fetchAll();

        $userid = $row['userid'];
        foreach ($result as $row) {
          $username = $row['username'];
        };
      
      };

      // Redirect user back to index.php
      header('Location: index.php'); 
    } else {

      // Login failed
      echo '<div class="alert alert-danger alert-dismissable">';
      echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
      echo '<strong>Error!</strong> Login failed. Please try again.';
      echo '</div>';
    }
  }
  
  include 'includes/header.php';
?>

<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li class="active">Login</li>
</ol>

<div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4">
    <h2>Login to an existing account</h2>
    <form method="post">
      <div class="form-group">
        <label for="username_li">Username</label>
        <input class="form-control" type="text" id="username_li" name="username_li" required>
      </div>
      <div class="form-group">
        <label for="password_li">Password</label>
        <input class="form-control" type="password" id="password_li" name="password_li" required>
      </div>
      
      <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>

  </div>
  <div class="col-md-4"></div>
</div>


<?php 
  include 'includes/footer.php';
?>