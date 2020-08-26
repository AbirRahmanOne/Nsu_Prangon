<?php session_start(); ?>
<?php include('../db/connect.php'); ?>
<?php include('../helpers/function.php'); ?>

<?php
	if(isset($_POST['login'])){
		$username=mysqli_real_escape_string($connection, $_POST['username']);
		$password=mysqli_real_escape_string($connection, $_POST['password']);

		$query="SELECT * FROM users WHERE username='{$username}' AND password='{$password}'";
		$result=mysqli_query($connection, $query);

		if(mysqli_num_rows($result)>0){
			while($row=mysqli_fetch_array($result)){
				$db_user_id=$row['id'];
				$db_username=$row['username'];

				$_SESSION['userid']=$db_user_id;
				$_SESSION['username']=$db_username;
				redirect_to('../users/user.php');
			}
		}
		else{
			$_SESSION['loginError']="Username or password is invalid!";
			redirect_to('../login.php');
		}
	}
?>

<?php include('../db/close.php'); ?>