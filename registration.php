<?php require_once('helpers/session.php'); ?>
<?php include('db/connect.php'); ?>
<?php include('partials/s_header.php'); ?>
<?php include('partials/s_nav.php'); ?>
<?php include('helpers/function.php'); ?>

<?php if(isset($_SESSION['userid'], $_SESSION['username']))
	redirect_to('users/user.php');
?>

<div class="container">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading"><span class="glyphicon glyphicon-registration-mark" aria-hidden="true"></span>&nbsp;&nbsp;User Registration</div>

			<div class="panel-body">
				<?php
					if(isset($_SESSION['registrationSuccess'])){
				?>
				<div class="alert alert-success" role="alert"><?php echo $_SESSION['registrationSuccess']; ?></div>
				<?php
						unset($_SESSION['registrationSuccess']);
					}
				?>
				<?php
					if(isset($_SESSION['registrationError'])){
						if(isset($_SESSION['userFound'])){
				?>
				<div class="alert alert-danger" role="alert"><?php echo $_SESSION['registrationError']; ?></div>
				<?php
							unset($_SESSION['userFound']);
						}
						else{
				?>
				<div class="alert alert-danger" role="alert"><?php echo $_SESSION['registrationError']; ?></div>
				<?php
						}
						unset($_SESSION['registrationError']);
					}
				?>
				
				<!-- ------------------ Registration form submits to registration controller ------------------- -->
				<form action="controllers/registration.php" method="POST" userAuth>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label for="name">Name:</label>
							</div>
							<div class="col-md-9">
								<input type="text" name="name" class="form-control" id="name" placeholder="Your name" required>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label for="email">Email:</label>
							</div>
							<div class="col-md-9">
								<input type="email" name="email" class="form-control" id="email" placeholder="Your email" required>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label for="type">Type:</label>
							</div>
							<div class="col-md-9">
								<select name="type" class="form-control" id="type" required>
									<optgroup label="Select Type">
										<option value="student">Student</option>
										<option value="faculty">Faculty</option>
									</optgroup>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label for="username">Username:</label>
							</div>
							<div class="col-md-9">
								<input type="text" name="username" class="form-control" id="username" placeholder="Pick username" required>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label for="password">Password:</label>
							</div>
							<div class="col-md-9">
								<input type="password" name="password" class="form-control" id="password" placeholder="Pick password" required>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label for="password_con">Confrim Password:</label>
							</div>
							<div class="col-md-9">
								<input type="password" name="password_con" class="form-control" id="password_con" placeholder="Pick password_con" required>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12">
							<div class="row pull-right">
								<a href="login.php" class="btn btn-default"><span class="glyphicon glyphicon-log-in"></span>&nbsp;&nbsp;Already have an account! Login</a>
								&nbsp;&nbsp;
								<button type="submit" name="registration" class="btn btn-default pull-right"><span class="glyphicon glyphicon-tower" aria-hidden="true"></span>&nbsp;&nbsp;Register</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php include('partials/s_footer.php'); ?>
<?php include('db/close.php'); ?>
	
