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

	if($type=='student')
		redirect_to('user.php');
?>

<?php include('../partials/s_nav.php'); ?>

<?php if(!isset($_GET['id'])){ ?>
<div class="container">
	<div class="row">
		<div class="col-md-7 course-list">
			<div class="row">
			<div class="col-md-12 cl-inner">
				<h2>Your Classes</h2>
				<hr>
				<?php
					$query="SELECT classes.*, tags.tag FROM classes INNER JOIN tags ON classes.tagId=tags.id AND classes.userId='{$studentId}' ORDER BY classes.id DESC";
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
				<?php } ?>
			</div>
			</div>
		</div>
		<div class="col-md-5 add-course">
			<div class="row">
			<div class="col-md-12 ac-inner">
				<h3>Add Class</h3>
				<hr>
				<?php if(isset($_SESSION['courseAddSuccess'])){ ?>
				<div class="alert alert-success"><?php echo $_SESSION['courseAddSuccess']; ?></div>
				<?php
						unset($_SESSION['courseAddSuccess']);
					} ?>
				<form action="../controllers/classes.php" method="POST">
					<input type="hidden" name="userId" value="<?php echo $studentId; ?>">
					<input type="text" name="title" class="form-control" placeholder="Course title" required><br>
					<input type="text" name="name" class="form-control" placeholder="Course name" required><br>
					<div class="row">
					<div class="col-md-12">
						<div class="row">
						<div class="col-md-6">
							<select name="tag" class="selectpicker" data-live-search="true" required>
								<option value="">Course tag</option>
							  <?php
									$query="SELECT * FROM tags ORDER BY tag ASC";
									$res=mysqli_query($connection, $query);
									while($row=mysqli_fetch_array($res)){
								?>
								<option value="<?php echo $row['id']; ?>"><?php echo strtoupper($row['tag']); ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-6">
							<input type="number" name="capacity" class="form-control" placeholder="Student Capacity" required><br>
						</div>
						</div>
					</div>
					</div>
					<button type="submit" name="course-add" class="btn btn-default">Add Course</button>
				</form>
			</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<?php if(isset($_GET['id'])){redirect_to('classes.php');} ?>

<?php include('../partials/s_footer.php'); ?>
<?php include('../db/close.php'); ?>
