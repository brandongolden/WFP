<?php
	include '../includes/database-connection.php';
	include 'includes/header.php';

	$post_id = $_GET['postid'];

	if($_SERVER['REQUEST_METHOD'] == 'POST') {

		$update_post_title = $_POST['title'];
		$update_post_content = $_POST['content'];
		//$post_userid = $_SESSION['user_id'];
		$datetime = date('Y-m-d H:i:s');


		$stmt = $dbh->prepare('UPDATE blog_posts SET post_title = :post_title, post_content = :post_content, post_modified = :post_modified WHERE id = :id');
		$stmt->execute(['post_title' => $update_post_title, 'post_content' => $update_post_content, 'post_modified' => $datetime, 'id' => $post_id]);

		echo '<div class="alert alert-success alert-dismissable">';
 		echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
  		echo '<strong>Success!</strong> Post has been updated';
		echo '</div>';
	}

	if (isset($_GET['action'])) {
		if ($_GET['action'] == "delete") {
			if (isset($_GET['postid'])) {
				$delete_postid = $_GET['postid'];
				$sth = $dbh -> prepare("DELETE from blog_posts WHERE id = :id");
				$sth->execute(['id' => $delete_postid]); 

				header('Location: blog.php');
			}
		}
	}


	$sth = $dbh -> prepare("SELECT post_title from blog_posts WHERE id = :post_id");
	$sth->execute(['post_id' => $post_id]); 
	$result = $sth -> fetch();
	$post_title = $result["post_title"];

	$sth = $dbh -> prepare("SELECT post_content from blog_posts WHERE id = :post_id");
	$sth->execute(['post_id' => $post_id]); 
	$result = $sth -> fetch();
	$post_content = $result["post_content"];
	

?>

<ol class="breadcrumb">
  <li><a href="index.php">Admin Control Panel</a></li>
  <li><a href="blog.php">Blog</a></li>
  <li class="active">Edit Post</li>
</ol>

<h1>Edit Post</h1>

<form action="" method="post">
	<div class="form-group">
		<input type="text" class="form-control" name="title" id="title" value="<?php echo $post_title; ?>" required>
	</div>
	<div class="form-group">
		<textarea name="content" id="content" class="form-control" rows="8" required><?php echo $post_content; ?></textarea>
	</div>

	<input type="submit" name="submit" class="btn btn-primary" value="Update">
</form>

<hr>
<h4>Delete Post</h4>
<?php
    echo '<p>This action is permanent.</p>';
    echo '<a href="edit-post.php?action=delete&postid=' . $post_id . '">';
    echo '<button type="button" class="btn btn-danger">Delete Post</button></a>';    
?>

<?php
	include('includes/footer.php');
?>