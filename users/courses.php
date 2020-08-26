<?php session_start(); ?>
<?php include('../db/connect.php'); ?>
<?php include('../partials/s_header.php'); ?>
<?php require_once('../helpers/function.php'); ?>

<?php if(!isset($_SESSION['userid'], $_SESSION['username']))
	redirect_to('../login.php');
?>

<!-- ---------------- Get user for specific id ----------------- -->
<?php
	$student=getUser($_SESSION['userid']);

	$studentId=$student['id'];
	$username=$student['username'];
	$name=$student['name'];
	$type=$student['type'];
	$email=$student['email'];

	if($type=='faculty')
		redirect_to('user.php');
?>

<?php include('../partials/s_nav.php'); ?>

<div class="container">
	<div class="row">
		<div class="col-md-7 course-list">
			<div class="row">
			<div class="col-md-12 cl-inner">
				<h2>Your Courses</h2>
				<hr>

				<?php
					$query="SELECT classes.*, tags.tag FROM classes INNER JOIN enrollments ON classes.id=enrollments.classId AND enrollments.userId='{$studentId}' INNER JOIN tags ON classes.tagId=tags.id ORDER BY id DESC";
					$res=mysqli_query($connection, $query);
					while($row=mysqli_fetch_array($res)){
				?>
				<div class="courses">
					<a href="classroom.php?class_id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a>
					<span style="float: right">
						<span class="label label-default"><?php echo $row['tag']; ?></span>
						<button>Edit</button>
						<button>Delete</button>
					</span>
				</div>
				<br>
				<?php
					}
				?>

			</div>
			</div>
		</div>
		<div class="col-md-5 add-course">
			<div class="row">
			<div class="col-md-12 ac-inner">
				<h3>Enroll to Class</h3>
				<hr>
				<?php
					if(isset($_SESSION['classNotFound'])){
				?>
				<div class="alert alert-danger"><?php echo $_SESSION['classNotFound']; ?></div>
				<?php
					unset($_SESSION['classNotFound']);	
				}?>
				<?php
					if(isset($_SESSION['classAccessSuccess'])){
				?>
				<div class="alert alert-success"><?php echo $_SESSION['classAccessSuccess']; ?></div>
				<?php
					unset($_SESSION['classAccessSuccess']);	
				}?>
				<?php
					if(isset($_SESSION['classAccessError'])){
				?>
				<div class="alert alert-danger"><?php echo $_SESSION['classAccessError']; ?></div>
				<?php
					unset($_SESSION['classAccessError']);	
				}?>
				<form action="../controllers/courses.php" method="POST">
					<div class="form-group">
						<input type="hidden" name="user-id" value="<?php echo $studentId; ?>">
						<label for="access">Access code: </label>
						<input type="text" name="access" class="form-control" id="access" placeholder="Class access code">
					</div>
					<div class="form-group">
						<button type="submit" name="classAccess" class="btn btn-warning">Access</button>
					</div>
				</form>
			</div>
			</div>
		</div>
	</div>
</div>

<?php include('../partials/s_footer.php'); ?>
<?php include('../db/close.php'); ?>
