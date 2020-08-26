<?php session_start(); ?>
<?php include('../db/connect.php'); ?>
<?php include('../helpers/function.php'); ?>

<?php
	if(isset($_POST['student-post'])){
		$userId=$_POST['userId'];
		$title=htmlentities($_POST['post-title']);
		$tags=$_POST['post-tags'];
		$content=mysqli_real_escape_string($connection, $_POST['post-content']);

		$query="INSERT INTO posts(userId, title, content) VALUES('{$userId}', '{$title}', '{$content}')";
		$res=mysqli_query($connection, $query);

		if($res){
			$postId=mysqli_insert_id($connection);
			foreach($tags as $tag){
				$tagId=(int)$tag;
				$query2="INSERT into posttags(postId, tagId) VALUES('{$postId}', '{$tagId}')";
				mysqli_query($connection, $query2);
			}
		}
		$_SESSION['postAddSuccess']='Successfully post added!';
		redirect_to('../users/user.php');
	}
?>

<?php
	if(isset($_POST['post-delete'])){
		$postId=$_POST['post-id'];

		$query="DELETE FROM posttags WHERE postId='{$postId}'";
		mysqli_query($connection, $query);

		$query1="DELETE FROM comments WHERE postId='{$postId}'";
		mysqli_query($connection, $query1);

		$query2="DELETE FROM posts WHERE id={$postId}";
		mysqli_query($connection, $query2);

		$_SESSION['postDeleteSuccess']='Successfully post deleted!';
		redirect_to('../users/user.php');
	}
?>

<?php
	if(isset($_POST['userComment'])){
		$postId=$_POST['postId'];
		$comment=mysqli_real_escape_string($connection, $_POST['userComment']);

		echo $postId;
		echo $comment;
	}
?>

<!-- ---------------------- To post comment --------------------- -->
<?php
	if(isset($_POST['commentPosted'])){
		$userId=(int)$_POST['userId'];
		$postId=(int)$_POST['postId'];
		$comment=mysqli_real_escape_string($connection, $_POST['comment']);

		$query="INSERT INTO comments(userId, postId, comment) VALUES('{$userId}', '{$postId}', '{$comment}')";
		mysqli_query($connection, $query);
	}
?>

<!-- --------------------- Display comments --------------------- -->
<?php
	if(isset($_POST['commentDisplay'])){
		$id=(int)$_POST['id'];
		$query="SELECT * FROM comments WHERE postId='{$id}' ORDER BY id DESC";
		$res=mysqli_query($connection, $query);

		while($row=mysqli_fetch_array($res)){
?>
<p><b><a href="#"><?php echo ucwords(getUser($row['userId'])['name']); ?></a></b>&nbsp;&nbsp;<?php echo nl2br($row['comment']); ?></p>
<?php
		}
	}
?>
<?php include('../db/close.php'); ?>