<?php session_start(); ?>
<?php include('../db/connect.php'); ?>
<?php include('../helpers/function.php'); ?>

<?php
	if(isset($_POST['registration'])){
		$name=$_POST['name'];
		$email=$_POST['email'];
		$type=$_POST['type'];
		$username=$_POST['username'];
		$password=$_POST['password'];
		$password_con=$_POST['password_con'];

		if($password==$password_con){
			$query1="SELECT username FROM users";
			$result1=mysqli_query($connection, $query1);

			if(mysqli_num_rows($result1)>0){
				while($row=mysqli_fetch_array($result1)){
					$db_username=$row['username'];
					if($username==$db_username){
						$_SESSION['userFound']=$username;
						$_SESSION['registrationError']='Sorry, <b>'.$_SESSION['userFound'].'</b> already taken!';
						redirect_to('../registration.php');
					}
				}
			}

			$query="INSERT INTO users(name, type, email, username, password) ";
			$query.="VALUES('{$name}', '{$type}', '{$email}', '{$username}', '{$password}')";
			$result=mysqli_query($connection, $query);

			if($result){
				$_SESSION['registrationSuccess']='Registration successfully done!';
				redirect_to('../registration.php');
			}
		}
		else{
			$_SESSION['registrationError']='Sorry, password not matched!';
			redirect_to('../registration.php');
		}
	}
?>

<?php include('../db/close.php'); ?>