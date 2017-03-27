<?php

  include 'includes/database-connection.php';
  include 'includes/session.php';
  include 'includes/membersonly.php';

  // If no username in url redirect user back to members
  if (!isset($_GET['username'])) {
    header('Location: members.php');
  }

  //$foundprofile = false;

  $profileusername = $_GET['username'];

  $sth = $dbh -> prepare("SELECT userid from users WHERE username = :profileusername");
  $sth->execute(['profileusername' => $profileusername]); 
  $r = $sth -> fetch();
  $profileuserid = $r["userid"];



  $stmt = $dbh->prepare('SELECT * FROM profiles WHERE userid = :profileuserid');
  $stmt->execute(['profileuserid' => $profileuserid]);
  $result = $stmt->fetchall(PDO::FETCH_ASSOC);


  $profile_name = "";
  $gender = "";
  $hobbies = "";

  foreach ($result as $row) {
    $profile_name = $row['name'];
    $gender = $row['gender'];
    $hobbies = $row['hobbies'];
    //foundprofile = true;  
  }



  $sth = $dbh -> prepare("SELECT avatar from users WHERE userid = :userid");
  $sth->execute(['userid' => $profileuserid]); 
  $r = $sth -> fetch();
  $avatar = $r["avatar"];



  /*
  if ($foundprofile == false) {
    header('Location: members.php');
  }
  */


  // Page title
  $page_title = $profileusername . "'s Profile";

  include 'includes/header.php';
?>

  <ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
    <li><a href="members.php">Members</a></li>
    <li class="active"><?php echo $profileusername; ?></li>
  </ol>

  <h2><? echo $profileusername; ?></h2>

    <div class="row">
        <div class="col-sm-2" style="text-align: center;">
          <?php
            if ($avatar != null) {
              echo '<a href="avatars/' . $avatar . '"><img class="img-thumbnail" src="avatars/' . $avatar . '" /></a>';
            } else {
              echo '<img class="img-thumbnail" src="avatars/default/default.png" />';
            }    
            echo '<a style="display: block; margin-top: 10px;" href="viewusershop.php?username=' . $profileusername . '">' . $profileusername . "'s Shop</a>";
          ?>  

        </div>
        <div class="col-sm-10">
          <h4>Name </h4>
          <p><?php echo $profile_name; ?></p>

          <h4>Gender </h4>
          <p><?php echo $gender; ?></p>

          <h4>Hobbies </h4>
          <p><?php echo $hobbies; ?></p>
        </div>
    </div>




<?php
  include 'includes/footer.php';
?>