<?php
	include '../includes/database-connection.php';
	include 'includes/header.php';

?>

<ol class="breadcrumb">
  <li><a href="index.php">Admin Control Panel</a></li>
  <li class="active">Blog</li>
</ol>

<h1>
Blog
<a href="new-post.php"><button type="button" class="btn btn-primary" style="float: right;">Add New Post</button></a>
</h1>


<table class="table">
<thead>
  <tr>
    <th>Title</th>
    <th>Author</th>
    <th style="text-align: right;">Date Modified</th>
    <th style="text-align: right;">Date Published</th>
  </tr>
</thead>
<tbody>
<?php


	$stmt = $dbh->prepare('SELECT * FROM blog_posts ORDER BY post_date DESC');
	$stmt->execute();
	$result = $stmt->fetchall(PDO::FETCH_ASSOC);




	foreach ($result as $row) {
	    $post_id = $row['id'];
	    $post_title = $row['post_title'];
	    $post_userid = $row['post_userid'];
	    $post_date = $row['post_date'];
	    $post_modified = $row['post_modified'];

	    if ($post_modified != null) {
			$post_modified = date('Y-m-d', strtotime($post_modified));
	    }

	    $sth = $dbh -> prepare("SELECT username from users WHERE userid = :userid");
		$sth->execute(['userid' => $post_userid]); 
		$result = $sth -> fetch();
		$post_author = $result["username"];


		$post_date = date('Y-m-d', strtotime($post_date));
        //$post_date = date('F d, Y', strtotime($post_date));


	    echo '<tr>';
	    echo '<td><a href="edit-post.php?postid=' . $post_id . '">' . $post_title . '</a></td>';
	   	echo '<td><a href="manageuser.php?userid=' . $post_userid . '">' . $post_author . '</a></td>';
	   	echo '<td style="text-align: right;">' . $post_modified . '</td>';
	   	echo '<td style="text-align: right;">' . $post_date . '</td>';



	    echo '</tr>';
  	}
?>	
</tbody>
</table>



<?php
	include('includes/footer.php');
?>