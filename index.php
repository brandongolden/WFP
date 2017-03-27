<?php
  include 'includes/database-connection.php';
  include 'includes/session.php';


  // If user is logged in
  if (isset($_SESSION['user_id'])) {
    $olderthanoneday = false;

    // Select datetime when user last got free gift
    $sth = $dbh -> prepare("SELECT free_gift from users WHERE userid = :userid");
    $sth->execute(['userid' => $userid]); 
    $result = $sth -> fetch();
    $free_gift_datetime = $result["free_gift"];
        

    $dateFromDatabase = strtotime($free_gift_datetime);
    $dateOneDayAgo = strtotime("-1 day");

    if ($dateFromDatabase >= $dateOneDayAgo) {
      // Less than 12 hours ago
      $olderthanoneday = false;
    }
    else {
      // More than 12 hours ago
      // User can get free gift again
      $olderthanoneday = true;
    }
  }


  if (isset($_GET['action'])) {
    if ($_GET['action'] == "freegift") {


      // Check Date of last free gift
      if ($free_gift_datetime == null || $olderthanoneday == true) {

        // Choose random free gift
        $sth = $dbh -> prepare("SELECT itemid from free_gift ORDER BY RAND() LIMIT 1");
        $sth->execute(); 
        $result = $sth -> fetch();
        $random_free_gift = $result["itemid"];

        // Add item to users inventory
        $stmt = $dbh->prepare("INSERT INTO users_inventory (userid, itemid)VALUES(:userid, :itemid)");
        $stmt->bindParam(':userid', $userid);
        $stmt->bindParam(':itemid', $random_free_gift);
        $stmt->execute();

        // Store item id of free gift in database
        $stmt = $dbh->prepare('UPDATE users SET free_gift_itemid = :free_gift_itemid WHERE userid = :userid');
        $stmt->bindParam(':userid', $userid);
        $stmt->bindParam(':free_gift_itemid', $random_free_gift);
        $stmt->execute();

        // Update datetime of free gift
        $datetime = date('Y-m-d H:i:s');
        $stmt = $dbh->prepare('UPDATE users SET free_gift = :free_gift  WHERE userid = :userid');
        $stmt->execute(['free_gift' => $datetime, 'userid' => $userid]);        
      }


      // Redirect user back to index.php
      header('Location: index.php');



    } // if ($_GET['action'] == "freegift") {
  } // if (isset($_GET['action'])) {


  include 'includes/header.php';

?>

<div class="row">

    <div class="col-md-9">
      <h2>News</h2>

      <?php
        // Select all blog posts from database, limit 5
        $stmt = $dbh->prepare('SELECT * FROM blog_posts ORDER BY post_date DESC LIMIT 5');
        $stmt->execute();
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
          $post_title = $row['post_title'];
          $post_content = $row['post_content'];        
          $post_userid = $row['post_userid'];
          $post_date = $row['post_date'];

          $sth = $dbh -> prepare("SELECT username from users WHERE userid = :userid");
          $sth->execute(['userid' => $post_userid]); 
          $result = $sth -> fetch();
          $post_author = $result["username"];

          // Format post datetime
          $post_date = date('F d, Y', strtotime($post_date));

          echo "<article>";
          echo "<header>";
          echo "<h3>" . $post_title . "</h3>";
          echo "<p>Posted " . $post_date . " by " . '<a href="viewprofile.php?username=' . $post_author . '">' . $post_author . "</a>.</p>";
          echo "</header>";
          echo "<p>" . $post_content . "</p>";
          echo "</article>";

        }
      ?>
     

    </div>

    <div class="col-md-3">
    <?php
      include 'includes/sidebar.php';
    ?>
    </div>

</div>





<?php

  include 'includes/footer.php';

?>