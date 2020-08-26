<?php session_start(); ?>
<?php include('../db/connect.php'); ?>
<?php include('../helpers/function.php'); ?>

<?php
	if(isset($_POST['course-add'])){
		$userId=$_POST['userId'];
		$title=$_POST['title'];
		$name=$_POST['name'];
		$tagId=(int)$_POST['tag'];
		$capacity=$_POST['capacity'];

		addCourse($userId, $title, $name, $capacity, $tagId);
		$_SESSION['courseAddSuccess']="Successfully course added!";
		redirect_to('../users/classes.php');
	}
?>

<?php include('../db/close.php'); ?>