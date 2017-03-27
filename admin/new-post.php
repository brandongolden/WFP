<?php
	include '../includes/database-connection.php';
	include 'includes/header.php';


	if($_SERVER['REQUEST_METHOD'] == 'POST') {

		$post_title = $_POST['title'];
		$post_content = $_POST['content'];
		$post_userid = $_SESSION['user_id'];
		$datetime = date('Y-m-d H:i:s');




		$stmt = $dbh->prepare("INSERT INTO blog_posts (post_userid, post_title, post_content, post_date)VALUES(:post_userid, :post_title, :post_content, :post_date)");
		$stmt->bindParam(':post_userid', $post_userid);
		$stmt->bindParam(':post_title', $post_title);
		$stmt->bindParam(':post_content', $post_content);
		$stmt->bindParam(':post_date', $datetime);
		$stmt->execute();	

		header('Location: blog.php');
	}
	

?>

<ol class="breadcrumb">
  <li><a href="index.php">Admin Control Panel</a></li>
  <li><a href="blog.php">Blog</a></li>
  <li class="active">Add New Post</li>
</ol>

<h1>Add New Post</h1>

<form action="new-post.php" method="post">
	<div class="form-group">
		<input type="text" class="form-control" name="title" id="title" placeholder="Title" required>
	</div>
	<div class="form-group">
		<textarea name="content" id="content" class="form-control" rows="8" required></textarea>
	</div>

	<input type="submit" name="submit" class="btn btn-primary" value="Publish">
</form>


<?php
	include('includes/footer.php');
?>