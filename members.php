<?php
  include 'includes/database-connection.php';
  include 'includes/session.php';
  include 'includes/membersonly.php';

  // Page title
  $page_title = "Members";

  include 'includes/header.php';



  // Select all users
  $stmt = $dbh->prepare('SELECT * FROM users');
  $stmt->execute();
  $result = $stmt->fetchall(PDO::FETCH_ASSOC);

?>

<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li class="active">Members</li>
</ol>

<h2>Members</h2>


<?php

  foreach ($result as $row) {
    $profile_userid = $row['userid'];
    $profile_username = $row['username']; 
    $avatar = $row['avatar'];

    // If user does not have an avatar display default avatar image
    if ($avatar === null || $avatar == "") {
      $avatar = "/default/default.png";
    }    

    /*
    echo '<div class="profile"><div class="profile-img-container"><img class="img-thumbnail" src="avatars/' . $avatar . '" /></div>';
    echo '<h6>' . $profile_username . '</h6>';
    echo '<div class="viewprofile"><a class="btn btn-default" href="viewprofile.php?username=' . $profile_username . '">' . 'View Profile</a></div></div>';
    */


    echo '<div class="profile"><div class="profile-img-container"><img alt="' . $profile_username . '" class="img-thumbnail" src="avatars/' . $avatar . '" /></div>';
    echo '<a href="viewprofile.php?username=' . $profile_username . '"><h6 style="margin-top:25px;">' . $profile_username . "</h6></a>";
    echo '<div class="viewprofile" style="width: 93px; height: 34px;"></div></div>';
  }

?>

      
<?php
  include 'includes/footer.php';
?>