<?php
  include 'includes/database-connection.php';
  include 'includes/session.php';
  include 'includes/membersonly.php';

  // Page title
  $page_title = "Edit Profile";

  // Check if user has a profile
  $stmt = $dbh->prepare('SELECT * FROM profiles WHERE userid = :userid');
  $stmt->bindParam(':userid', $userid);
  $stmt->execute();
  $result = $stmt->rowcount(PDO::FETCH_ASSOC);
  $rowfound = $result;

  // If no results found create profile
  if ($rowfound < 1) {
    $stmt = $dbh->prepare("INSERT INTO profiles (userid)VALUES(:userid)");
    $stmt->bindParam(':userid', $userid);
    $stmt->execute();
  }


  // Update user profile
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $hobbies = $_POST['hobbies'];

    $stmt = $dbh->prepare("
    UPDATE profiles
      SET 
      name = :name,
      gender = :gender,
      hobbies = :hobbies
    WHERE 
    userid = :userid
    ");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':hobbies', $hobbies);
    $stmt->bindParam(':userid', $userid);
    $stmt->execute();

    // Redirect user back to edit profile with success message
    header('Location: edit-profile.php?message=success');
  }

  // Select user profile
  $stmt = $dbh->prepare('SELECT * FROM profiles WHERE userid = :userid');
  $stmt->execute(['userid' => $userid]);
  $result = $stmt->fetchall(PDO::FETCH_ASSOC);

  $name = "";
  $gender = "";
  $hobbies = "";


  foreach ($result as $row) {
    $name = $row['name'];
    $gender = $row['gender'];
    $hobbies = $row['hobbies']; 
  }


  include 'includes/header.php';
?>

<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li><a href="my-account.php">My Account</a></li>
  <li class="active">Edit Profile</li>
</ol>

<?php
  // Success message when profile is updated
  if (isset($_GET['message'])) {
    echo '<div class="alert alert-success alert-dismissable">';
    echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    echo '<strong>Success!</strong> Profile updated.';
    echo '</div>';
  }
?>

<h2>Edit Profile</h2>


<form method="post">
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>">
  </div>

  <div class="form-group">
    <label for="gender">Gender</label>
    <select name="gender" class="form-control">
      <?php if ($gender == "Male") { ?>
      <option value="Male" selected>Male</option>
      <option value="Female">Female</option>
      <?php } elseif ($gender == "Female") { ?>
      <option value="Male">Male</option>
      <option value="Female" selected>Female</option>
      <?php } else { ?>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
      <?php } ?>
    </select>
  </div>

  <div class="form-group">
    <label for="hobbies">Hobbies</label>
    <textarea name="hobbies" class="form-control" rows="4"><?php echo $hobbies; ?></textarea>
  </div>
 
  <button type="submit" class="btn btn-primary">Update Profile</button>
</form>



<?php
  include 'includes/footer.php';
?>