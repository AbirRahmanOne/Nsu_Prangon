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
			<div class="panel-heading"><span class="glyphicon glyphicon-registration-mark" aria-hidden="true"></span>&nbsp;&nbsp;User Login</div>

			<div class="panel-body">
				<?php
					if(isset($_SESSION['loginError'])){
				?>
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<?php echo $_SESSION['loginError']; ?>
				</div>
				<?php
						unset($_SESSION['loginError']);
					}
				?>
				
				<!-- ------------------ Registration form submits to registration controller ------------------- -->
				<form action="controllers/login.php" method="POST">
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
						<div class="col-md-12">
							<div class="row pull-right">
								<a href="registration.php" class="btn btn-default"><span class="glyphicon glyphicon-tower" aria-hidden="true"></span>&nbsp;&nbsp;Create new account!</a>
								&nbsp;&nbsp;
								<button type="submit" name="login" class="btn btn-default pull-right"><span class="glyphicon glyphicon-log-in"></span>&nbsp;&nbsp;Login</button>
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
	
