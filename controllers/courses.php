<?php session_start(); ?>
<?php include('../db/connect.php'); ?>
<?php include('../helpers/function.php'); ?>

<?php
	if(isset($_POST['classAccess'])){
		$userId=(int)$_POST['user-id'];
		$accessCode=htmlentities($_POST['access']);

		$query1="SELECT * FROM classes WHERE code='{$accessCode}'";
		$res1=mysqli_query($connection, $query1);

		if(mysqli_num_rows($res1)>0){
			while($row=mysqli_fetch_array($res1)){
				$classAccessCode=(int)$row['id'];
				$classTitle=$row['title'];
				$capacity=(int)$row['capacity'];

				$query3="SELECT count(id) FROM enrollments WHERE classId='{$classAccessCode}'";
				$res3=mysqli_query($connection, $query3);
				$eNum=(int)mysqli_num_rows($res3);
				if($eNum>=$capacity){
					$_SESSION['classAccessError']="No vacancy!";
					redirect_to('../users/courses.php');
				}

				$query2="INSERT INTO enrollments(classId, userId) VALUES('{$classAccessCode}', '{$userId}')";
				if(mysqli_query($connection, $query2)){
					$_SESSION['classAccessSuccess']="Your are successfully accessed in <b>".$classTitle."</b> class!";
					redirect_to('../users/courses.php');
				}else{
					$_SESSION['classAccessError']="Your are already accessed in <b>".$classTitle."</b> class!";
					redirect_to('../users/courses.php');
				}
			}
		}else{
			$_SESSION['classNotFound']="No class exists for this access code!";
			redirect_to('../users/courses.php');
		}
	}
?>

<?php include('../db/close.php'); ?>