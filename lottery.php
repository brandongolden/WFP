<?php
  include 'includes/database-connection.php';
  include 'includes/session.php';
  include 'includes/membersonly.php';

  // If action == reset
  // Reset user scratchcards to 0
  if (isset($_GET['action']) == "reset") {     
    $update = 0;
    $stmt = $dbh->prepare('UPDATE users SET scratchcards = :scratchcards  WHERE userid = :userid');
    $stmt->execute(['scratchcards' => $update, 'userid' => $userid]);

    // Redirect user back to lottery
    header('Location: lottery.php');   
  }

  // Page title
  $page_title = "Lottery";
  

  // Select scratchcard count -- Did the user purchase a scratchcard?
  $stmt = $dbh -> prepare("SELECT scratchcards from users WHERE userid = :userid");
  $stmt->execute(['userid' => $userid]); 
  $result = $stmt -> fetch();
  $scratchcards = $result["scratchcards"];


  // Did the user get the prize?
  $stmt = $dbh -> prepare("SELECT user_prize from scratchcards WHERE userid = :userid");
  $stmt->execute(['userid' => $userid]); 
  $result = $stmt -> fetch();
  $user_prize = $result["user_prize"];


  // Scratchcard price -- Price is set in admin control panel
  $name = "scratchcardprice";
  $sth = $dbh -> prepare("SELECT value from settings WHERE name = :name");
  $sth->execute(['name' => $name]); 
  $result = $sth -> fetch();
  $scratchcardprice = $result["value"];
  $scratchcardprice = (int)$scratchcardprice;




  // Init variables to 0
  $prize_1_count = 0;
  $prize_2_count = 0;
  $prize_3_count = 0;
  $prize_4_count = 0;
  $prize_5_count = 0;
  $prize = 0;




  // Is there a scratchcard database table row that matches user id
  $stmt = $dbh->prepare('SELECT * FROM scratchcards WHERE userid = :userid');
  $stmt->bindParam(':userid', $userid);
  $stmt->execute();
  $result = $stmt->rowcount(PDO::FETCH_ASSOC);
  $rowfound = $result;

  // If no row found create one
  if ($rowfound < 1) {
    $stmt = $dbh->prepare("INSERT INTO scratchcards (userid)VALUES(:userid)");
    $stmt->bindParam(':userid', $userid);
    $stmt->execute();
  }


  // Select how many boxes the user has scratched off
  $sth = $dbh -> prepare("SELECT scratch_off_count from scratchcards WHERE userid = :userid");
  $sth->execute(['userid' => $userid]); 
  $result = $sth -> fetch();
  $scratch_off_count = $result["scratch_off_count"];

  // Scratchoff box
  if (isset($_GET['scratchoff'])) {

    // If scratch off count is less than 6, user can scratch off a box
    if ($scratch_off_count < 6) {

      // Box number to be scratched off
      $scratchoff = $_GET['scratchoff'];

      // Set scratch off box number to true and update database
      if ($scratchoff == '1') {
        $update_scratchoff = true;
        $stmt = $dbh->prepare('UPDATE scratchcards SET user_1 = :scratchoff  WHERE userid = :userid');
        $stmt->execute(['scratchoff' => $update_scratchoff, 'userid' => $userid]);
      } elseif ($scratchoff == '2') {
        $update_scratchoff = true;
        $stmt = $dbh->prepare('UPDATE scratchcards SET user_2 = :scratchoff  WHERE userid = :userid');
        $stmt->execute(['scratchoff' => $update_scratchoff, 'userid' => $userid]);
      } elseif ($scratchoff == '3') {
        $update_scratchoff = true;
        $stmt = $dbh->prepare('UPDATE scratchcards SET user_3 = :scratchoff  WHERE userid = :userid');
        $stmt->execute(['scratchoff' => $update_scratchoff, 'userid' => $userid]);
      } elseif ($scratchoff == '4') {
        $update_scratchoff = true;
        $stmt = $dbh->prepare('UPDATE scratchcards SET user_4 = :scratchoff  WHERE userid = :userid');
        $stmt->execute(['scratchoff' => $update_scratchoff, 'userid' => $userid]);     
      } elseif ($scratchoff == '5') {
        $update_scratchoff = true;
        $stmt = $dbh->prepare('UPDATE scratchcards SET user_5 = :scratchoff  WHERE userid = :userid');
        $stmt->execute(['scratchoff' => $update_scratchoff, 'userid' => $userid]);     
      } elseif ($scratchoff == '6') {
        $update_scratchoff = true;
        $stmt = $dbh->prepare('UPDATE scratchcards SET user_6 = :scratchoff  WHERE userid = :userid');
        $stmt->execute(['scratchoff' => $update_scratchoff, 'userid' => $userid]);     
      } elseif ($scratchoff == '7') {
        $update_scratchoff = true;
        $stmt = $dbh->prepare('UPDATE scratchcards SET user_7 = :scratchoff  WHERE userid = :userid');
        $stmt->execute(['scratchoff' => $update_scratchoff, 'userid' => $userid]);     
      } elseif ($scratchoff == '8') {
        $update_scratchoff = true;
        $stmt = $dbh->prepare('UPDATE scratchcards SET user_8 = :scratchoff  WHERE userid = :userid');
        $stmt->execute(['scratchoff' => $update_scratchoff, 'userid' => $userid]);     
      } elseif ($scratchoff == '9') {
        $update_scratchoff = true;
        $stmt = $dbh->prepare('UPDATE scratchcards SET user_9 = :scratchoff  WHERE userid = :userid');
        $stmt->execute(['scratchoff' => $update_scratchoff, 'userid' => $userid]);     
      }

      // Update scratch off count
      $scratch_off_count = $scratch_off_count + 1;
      $stmt = $dbh->prepare('UPDATE scratchcards SET scratch_off_count = :scratch_off_count  WHERE userid = :userid');
      $stmt->execute(['scratch_off_count' => $scratch_off_count, 'userid' => $userid]);
    }

    // Redirect user to lottery
    header('Location: lottery.php');
  }



  if (isset($_GET['action'])) {

    // If action == buy
    if ($_GET['action'] == "buy") {

      // If user virtual currency 1 is greater than or equal to scratchcard price
      if ($user_virtualcurrency1 >= $scratchcardprice) {

        // Update user prize to false -- new scratchcard
        $update_user_prize = false;
        $stmt = $dbh->prepare('UPDATE scratchcards SET user_prize = :user_prize  WHERE userid = :userid');
        $stmt->execute(['user_prize' => $update_user_prize, 'userid' => $userid]);

        // Update user scratchcard count to 1
        $update_scratchcards = 1;
        $stmt = $dbh->prepare('UPDATE users SET scratchcards = :scratchcards  WHERE userid = :userid');
        $stmt->execute(['scratchcards' => $update_scratchcards, 'userid' => $userid]);

        // Update user virtual currency 1 by subtracting scratchcard price
        $update_virtualcurrency1 = $user_virtualcurrency1 - $scratchcardprice;
        $stmt = $dbh->prepare('UPDATE users SET virtualcurrency1 = :virtualcurrency1  WHERE userid = :userid');
        $stmt->execute(['virtualcurrency1' => $update_virtualcurrency1, 'userid' => $userid]);


        // Reset scratchcard scratch off count to 0
        $scratch_off_count = 0;
        $stmt = $dbh->prepare('UPDATE scratchcards SET scratch_off_count = :scratch_off_count  WHERE userid = :userid');
        $stmt->execute(['scratch_off_count' => $scratch_off_count, 'userid' => $userid]);

        // Reset scratch off boxes to false
        $user_default = 0;
        $stmt = $dbh->prepare('UPDATE scratchcards SET user_1 = :user_default, user_2 = :user_default, user_3 = :user_default, user_4 = :user_default, user_5 = :user_default, user_6 = :user_default, user_7 = :user_default, user_8 = :user_default, user_9 = :user_default  WHERE userid = :userid');
        $stmt->execute(['user_default' => $user_default, 'userid' => $userid]);


        $scratchcard = array(0, 0, 0, 0, 0, 0, 0, 0, 0);


        // Scratchcard prizes array
        // All prize numbers should have 3 values in the array
        // It takes 3 of a kind to win
        $prizes = array(1, 1, 1, 2, 2, 2, 3, 3, 3, 4, 4, 4, 5, 5, 5);
        shuffle($prizes);

        // Random select 9 prizes from array
        $rand_keys = array_rand($prizes, 9);

        // Store scratchcard prize in array
        for ($i = 0; $i < count($scratchcard); $i++) {
          $scratchcard[$i] = $prizes[$rand_keys[$i]];
        }


        // For Testing
        // print_r(array_values($scratchcard));


        // Place prize inside scratchcard boxes
        $stmt = $dbh->prepare('UPDATE scratchcards SET scratchcard_1 = :scratchcard  WHERE userid = :userid');
        $stmt->execute(['scratchcard' => $scratchcard[0], 'userid' => $userid]);

        $stmt = $dbh->prepare('UPDATE scratchcards SET scratchcard_2 = :scratchcard  WHERE userid = :userid');
        $stmt->execute(['scratchcard' => $scratchcard[1], 'userid' => $userid]);

        $stmt = $dbh->prepare('UPDATE scratchcards SET scratchcard_3 = :scratchcard  WHERE userid = :userid');
        $stmt->execute(['scratchcard' => $scratchcard[2], 'userid' => $userid]);

        $stmt = $dbh->prepare('UPDATE scratchcards SET scratchcard_4 = :scratchcard  WHERE userid = :userid');
        $stmt->execute(['scratchcard' => $scratchcard[3], 'userid' => $userid]);  

        $stmt = $dbh->prepare('UPDATE scratchcards SET scratchcard_5 = :scratchcard  WHERE userid = :userid');
        $stmt->execute(['scratchcard' => $scratchcard[4], 'userid' => $userid]);

        $stmt = $dbh->prepare('UPDATE scratchcards SET scratchcard_6 = :scratchcard  WHERE userid = :userid');
        $stmt->execute(['scratchcard' => $scratchcard[5], 'userid' => $userid]);

        $stmt = $dbh->prepare('UPDATE scratchcards SET scratchcard_7 = :scratchcard  WHERE userid = :userid');
        $stmt->execute(['scratchcard' => $scratchcard[6], 'userid' => $userid]);

        $stmt = $dbh->prepare('UPDATE scratchcards SET scratchcard_8 = :scratchcard  WHERE userid = :userid');
        $stmt->execute(['scratchcard' => $scratchcard[7], 'userid' => $userid]);

        $stmt = $dbh->prepare('UPDATE scratchcards SET scratchcard_9 = :scratchcard  WHERE userid = :userid');
        $stmt->execute(['scratchcard' => $scratchcard[8], 'userid' => $userid]);                    
      } 
    }

    // Redirect user to lottery
    header('Location: lottery.php');
  }


  include 'includes/header.php';
?>

<ol class="breadcrumb">
  <li><a href="index.php"><?php echo $settings_title; ?></a></li>
  <li><a href="shops.php">Shops</a></li>
  <li class="active">Lottery</li>
</ol>

<h2>
<?php 
echo '<img style="max-width: 100px;" class="shops-img"  src="images/shops/lottery.png" />';
?>
Lottery
</h2>


<?php
  // If scratchcard count is 0 -- purchase scratchcard
  if ($scratchcards == 0) {
    echo '<div class="shops-item"><div class="shops-item-img-container"><img class="img-thumbnail" src="images/ticket.png" /></div>';
    echo '<h6>Scratchcard</h6>';
    echo '<div class="purchase">Purchase: <a class="btn btn-default" href="lottery.php?action=buy">' . number_format($scratchcardprice) . ' ' . $settings_virtualcurrency1 . '</a></div></div>';
  } else {


    echo '<h3>Scratchcard</h3>';
    echo '<p style="max-width: 302px;">Click on the treasure chests you want to scratch off, you have to scratch six out of the nine treasure chests off. You win if you get three of a kind! In the event of two three-of-a-kinds, the highest one will be the prize you get.</p>';


    echo '<div class="scratchcard"><div class="scratchcard-img-container"></div><div class="play-container">';



    // Select all from scratchcards that matches user id
    $stmt = $dbh->prepare('SELECT * FROM scratchcards WHERE userid = :userid');
    $stmt->execute(['userid' => $userid]);
    $result = $stmt->fetchall(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
      // True and false -- True if user scratched off box, otherwise false
      $user_1 = $row['user_1'];
      $user_2 = $row['user_2'];
      $user_3 = $row['user_3'];
      $user_4 = $row['user_4'];
      $user_5 = $row['user_5'];
      $user_6 = $row['user_6'];
      $user_7 = $row['user_7'];
      $user_8 = $row['user_8'];
      $user_9 = $row['user_9'];

      // Prize number for all scratch off boxes
      $scratchcard_1 = $row['scratchcard_1'];
      $scratchcard_2 = $row['scratchcard_2'];
      $scratchcard_3 = $row['scratchcard_3'];
      $scratchcard_4 = $row['scratchcard_4'];
      $scratchcard_5 = $row['scratchcard_5'];
      $scratchcard_6 = $row['scratchcard_6'];
      $scratchcard_7 = $row['scratchcard_7'];
      $scratchcard_8 = $row['scratchcard_8'];
      $scratchcard_9 = $row['scratchcard_9'];
    }




    // Box 1
    echo '<div class="scratchcard-box">';
    if ($scratch_off_count < 6 && $user_1 == false) {
      echo '<a href="lottery.php?scratchoff=1"><img src="images/chest-scratch-off.png"></a>';
    } elseif ($user_1 == true) {
      echo '<img src="images/' . $scratchcard_1 . '.png">';
    } else {
      echo '<img src="images/chest-scratch-off.png">';
    }
    echo '</div>';

    // Box 2
    echo '<div class="scratchcard-box">';
    if ($scratch_off_count < 6 && $user_2 == false) {
      echo '<a href="lottery.php?scratchoff=2"><img src="images/chest-scratch-off.png"></a>';
    } elseif ($user_2 == true) {
      echo '<img src="images/' . $scratchcard_2 . '.png">';
    } else {
      echo '<img src="images/chest-scratch-off.png">';
    }
    echo '</div>';

    // Box 3
    echo '<div class="scratchcard-box">';
    if ($scratch_off_count < 6 && $user_3 == false) {
      echo '<a href="lottery.php?scratchoff=3"><img src="images/chest-scratch-off.png"></a>';
    } elseif ($user_3 == true) {
      echo '<img src="images/' . $scratchcard_3 . '.png">';
    } else {
      echo '<img src="images/chest-scratch-off.png">';
    }
    echo '</div>';

    // Box 4
    echo '<div class="scratchcard-box">';
    if ($scratch_off_count < 6 && $user_4 == false) {
      echo '<a href="lottery.php?scratchoff=4"><img src="images/chest-scratch-off.png"></a>';
    } elseif ($user_4 == true) {
      echo '<img src="images/' . $scratchcard_4 . '.png">';
    } else {
      echo '<img src="images/chest-scratch-off.png">';
    }
    echo '</div>';

    // Box 5
    echo '<div class="scratchcard-box">';
    if ($scratch_off_count < 6 && $user_5 == false) {
      echo '<a href="lottery.php?scratchoff=5"><img src="images/chest-scratch-off.png"></a>';
    } elseif ($user_5 == true) {
      echo '<img src="images/' . $scratchcard_5 . '.png">';
    } else {
      echo '<img src="images/chest-scratch-off.png">';
    }
    echo '</div>';

    // Box 6
    echo '<div class="scratchcard-box">';
    if ($scratch_off_count < 6 && $user_6 == false) {
      echo '<a href="lottery.php?scratchoff=6"><img src="images/chest-scratch-off.png"></a>';
    } elseif ($user_6 == true) {
      echo '<img src="images/' . $scratchcard_6 . '.png">';
    } else {
      echo '<img src="images/chest-scratch-off.png">';
    }
    echo '</div>';


    // Box 7
    echo '<div class="scratchcard-box">';
    if ($scratch_off_count < 6 && $user_7 == false) {
      echo '<a href="lottery.php?scratchoff=7"><img src="images/chest-scratch-off.png"></a>';
    } elseif ($user_7 == true) {
      echo '<img src="images/' . $scratchcard_7 . '.png">';
    } else {
      echo '<img src="images/chest-scratch-off.png">';
    }
    echo '</div>';

    // Box 8
    echo '<div class="scratchcard-box">';
    if ($scratch_off_count < 6 && $user_8 == false) {
      echo '<a href="lottery.php?scratchoff=8"><img src="images/chest-scratch-off.png"></a>';
    } elseif ($user_8 == true) {
      echo '<img src="images/' . $scratchcard_8 . '.png">';
    } else {
      echo '<img src="images/chest-scratch-off.png">';
    }
    echo '</div>';

    // Box 9
    echo '<div class="scratchcard-box">';
    if ($scratch_off_count < 6 && $user_9 == false) {
      echo '<a href="lottery.php?scratchoff=9"><img src="images/chest-scratch-off.png"></a>';
    } elseif ($user_9 == true) {
      echo '<img src="images/' . $scratchcard_9 . '.png">';
    } else {
      echo '<img src="images/chest-scratch-off.png">';
    }
    echo '</div>';

    echo '</div></div>';



    // If scratch off count == 6
    if ($scratch_off_count == 6) {


      /*
        Calculate how many times all prizes appear in the scratched off boxes
      */

      if ($user_1 == true) {
        if ($scratchcard_1 == 1) {
          $prize_1_count = $prize_1_count + 1;
        } elseif ($scratchcard_1 == 2) {
          $prize_2_count = $prize_2_count + 1;
        } elseif ($scratchcard_1 == 3) {
          $prize_3_count = $prize_3_count + 1;
        } elseif ($scratchcard_1 == 4) {
          $prize_4_count = $prize_4_count + 1;
        } elseif ($scratchcard_1 == 5) {
          $prize_5_count = $prize_5_count + 1;
        }
      }

      if ($user_2 == true) {
        if ($scratchcard_2 == 1) {
          $prize_1_count = $prize_1_count + 1;
        } elseif ($scratchcard_2 == 2) {
          $prize_2_count = $prize_2_count + 1;
        } elseif ($scratchcard_2 == 3) {
          $prize_3_count = $prize_3_count + 1;
        } elseif ($scratchcard_2 == 4) {
          $prize_4_count = $prize_4_count + 1;
        } elseif ($scratchcard_2 == 5) {
          $prize_5_count = $prize_5_count + 1;
        }
      }

      if ($user_3 == true) {
        if ($scratchcard_3 == 1) {
          $prize_1_count = $prize_1_count + 1;
        } elseif ($scratchcard_3 == 2) {
          $prize_2_count = $prize_2_count + 1;
        } elseif ($scratchcard_3 == 3) {
          $prize_3_count = $prize_3_count + 1;
        } elseif ($scratchcard_3 == 4) {
          $prize_4_count = $prize_4_count + 1;
        } elseif ($scratchcard_3 == 5) {
          $prize_5_count = $prize_5_count + 1;
        }
      }

      if ($user_4 == true) {
        if ($scratchcard_4 == 1) {
          $prize_1_count = $prize_1_count + 1;
        } elseif ($scratchcard_4 == 2) {
          $prize_2_count = $prize_2_count + 1;
        } elseif ($scratchcard_4 == 3) {
          $prize_3_count = $prize_3_count + 1;
        } elseif ($scratchcard_4 == 4) {
          $prize_4_count = $prize_4_count + 1;
        } elseif ($scratchcard_4 == 5) {
          $prize_5_count = $prize_5_count + 1;
        }
      }


      if ($user_5 == true) {
        if ($scratchcard_5 == 1) {
          $prize_1_count = $prize_1_count + 1;
        } elseif ($scratchcard_5 == 2) {
          $prize_2_count = $prize_2_count + 1;
        } elseif ($scratchcard_5 == 3) {
          $prize_3_count = $prize_3_count + 1;
        } elseif ($scratchcard_5 == 4) {
          $prize_4_count = $prize_4_count + 1;
        } elseif ($scratchcard_5 == 5) {
          $prize_5_count = $prize_5_count + 1;
        }
      }

      if ($user_6 == true) {
        if ($scratchcard_6 == 1) {
          $prize_1_count = $prize_1_count + 1;
        } elseif ($scratchcard_6 == 2) {
          $prize_2_count = $prize_2_count + 1;
        } elseif ($scratchcard_6 == 3) {
          $prize_3_count = $prize_3_count + 1;
        } elseif ($scratchcard_6 == 4) {
          $prize_4_count = $prize_4_count + 1;
        } elseif ($scratchcard_6 == 5) {
          $prize_5_count = $prize_5_count + 1;
        }
      }

      if ($user_7 == true) {
        if ($scratchcard_7 == 1) {
          $prize_1_count = $prize_1_count + 1;
        } elseif ($scratchcard_7 == 2) {
          $prize_2_count = $prize_2_count + 1;
        } elseif ($scratchcard_7 == 3) {
          $prize_3_count = $prize_3_count + 1;
        } elseif ($scratchcard_7 == 4) {
          $prize_4_count = $prize_4_count + 1;
        } elseif ($scratchcard_7 == 5) {
          $prize_5_count = $prize_5_count + 1;
        }
      }


      if ($user_8 == true) {
        if ($scratchcard_8 == 1) {
          $prize_1_count = $prize_1_count + 1;
        } elseif ($scratchcard_8 == 2) {
          $prize_2_count = $prize_2_count + 1;
        } elseif ($scratchcard_8 == 3) {
          $prize_3_count = $prize_3_count + 1;
        } elseif ($scratchcard_8 == 4) {
          $prize_4_count = $prize_4_count + 1;
        } elseif ($scratchcard_8 == 5) {
          $prize_5_count = $prize_5_count + 1;
        }
      }

      if ($user_9 == true) {
        if ($scratchcard_9 == 1) {
          $prize_1_count = $prize_1_count + 1;
        } elseif ($scratchcard_9 == 2) {
          $prize_2_count = $prize_2_count + 1;
        } elseif ($scratchcard_9 == 3) {
          $prize_3_count = $prize_3_count + 1;
        } elseif ($scratchcard_9 == 4) {
          $prize_4_count = $prize_4_count + 1;
        } elseif ($scratchcard_9 == 5) {
          $prize_5_count = $prize_5_count + 1;
        }
      }




      if ($prize_1_count == 3) {
        $prize = 100000; // 100,000
      } elseif ($prize_2_count == 3) {
        $prize = 10000; // 10,000
      } elseif ($prize_3_count == 3) {
        $prize = 5000; // 5,000
      } elseif ($prize_4_count == 3) {
        $prize = 2500; // 2,500
      } elseif ($prize_5_count == 3) {
        $prize = 0;
      } else {
        $prize = 0;
      }



      // If prize is greater than 0 and user has not got prize
      if ($prize > 0 && $user_prize == false) {

        // Add prize to user virtual currency 1
        $update = $user_virtualcurrency1 + $prize;
        $stmt = $dbh->prepare('UPDATE users SET virtualcurrency1 = :virtualcurrency1  WHERE userid = :userid');
        $stmt->execute(['virtualcurrency1' => $update, 'userid' => $userid]);

        // User has got prize
        $update_user_prize = true;
        $stmt = $dbh->prepare('UPDATE scratchcards SET user_prize = :user_prize  WHERE userid = :userid');
        $stmt->execute(['user_prize' => $update_user_prize, 'userid' => $userid]);
      }

 
      // If user did not win
      if ($prize == 0) {
        echo '<h4>Oh well, better luck next time.</h4>';
      } else {
        // User won
        echo '<h4>Your Prize : ' . number_format($prize) . ' ' . $settings_virtualcurrency1 . '</h4>';
      }

      echo '<a class="btn btn-default" href="lottery.php?action=reset">Play again</a>';


    } // if ($scratch_off_count == 6) {

  }


?>



<?php
  include 'includes/footer.php';
?>