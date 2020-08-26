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
?>

<?php include('../partials/s_nav.php'); ?>

<?php if(isset($_GET['class_id'])){ ?>
<?php
	$classId=(int)(mysqli_real_escape_string($connection, $_GET['class_id']));

	if($type=='student'){
		$check="SELECT id FROM enrollments WHERE userId='{$studentId}' AND classId='{$_GET['class_id']}'";
		$checkRes=mysqli_query($connection, $check);
		if(mysqli_num_rows($checkRes)<1)
			redirect_to('courses.php');
	}else{
		$check="SELECT id FROM classes WHERE userId='{$studentId}' AND id='{$_GET['class_id']}'";
		$checkRes=mysqli_query($connection, $check);
		if(mysqli_num_rows($checkRes)<1)
			redirect_to('classes.php');
	}
?>

<div class="container">
	<div class="row">
		<div class="col-md-9" style="padding: 0 10px">
			<div class="col-md-12 classRoom-components">
				<div>

				  <!-- Nav tabs -->
				  <ul class="nav nav-pills nav-justified" role="tablist">
				    <li role="presentation" class="active" id="homeTl"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
				    <li role="presentation" id="materialsTl"><a href="#materials" aria-controls="materials" role="tab" data-toggle="tab">Class Materials</a></li>
				    <li role="presentation" id="gradesTl"><a href="#grades" aria-controls="grades" role="tab" data-toggle="tab">Grades</a></li>
				    <?php if($type=='faculty'){ ?>
				    <li role="presentation" id="structureTl"><a href="#structure" aria-controls="structure" role="tab" data-toggle="tab">Modify Course Structure</a></li>
				    <?php } ?>
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">
				    <div role="tabpanel" class="tab-pane active" id="home">...</div>
				    <!-- ---------------------------- Materials area ------------------------ -->
				    <?php include('partials/materialsTab.php'); ?>


				    <!-- ---------------------------- Grades area ------------------------ -->
				    <?php include('partials/gradesTab.php'); ?>


				    <!-- ----------------------- Modify course structure -------------------------- -->
				    <?php include('partials/modifyCSTab.php'); ?>
				  </div>

				</div>
			</div>
		</div>


		<!-- ---------------------------------- Classroom right sidebar --------------------------------- -->
		<div class="col-md-3" style="padding: 0 10px">
		<div class="col-md-12 classRightSidebar">
			<?php
				$query1="SELECT classes.*, tags.tag FROM classes INNER JOIN tags ON classes.tagId=tags.id AND classes.id='{$_GET['class_id']}'";
				$res1=mysqli_query($connection, $query1);
				if(mysqli_num_rows($res1)<1)
					$type=='student' ? redirect_to('courses.php') : redirect_to('classes.php');

				while($row=mysqli_fetch_array($res1)){
					if($studentId){
			?>
			<h4><?php echo ucwords($row['title']); ?></h4>
			<hr>
			<p class="text-center"><span class="label label-default"><?php echo $row['tag']; ?></span></p>
			<p class="text-center">Name: <span style="color: gray"><?php echo ucwords($row['name']); ?></span></p>
			<p class="text-center">Faculty: <span style="color: gray"><?php echo ucwords(getUser($row['userId'])['name']); ?></span></p>
			<p class="text-center">Access Code: <span class="accessCode"><?php echo $row['code']; ?></span></p>
			<?php }else{ redirect_to('classes.php'); }} ?>
			<br>
			<h4>Students</h4>
			<hr>
			<div class="student-lists">
			<?php
				$query2="SELECT users.* FROM users INNER JOIN enrollments ON enrollments.classId='{$classId}' AND enrollments.userId=users.id";
				$res2=mysqli_query($connection, $query2);
				if(mysqli_num_rows($res2)>0){
					while($row=mysqli_fetch_array($res2)){
				?>
				<p><?php echo ucwords($row['name']); ?></p>
				<?php
					}
				}else{
					echo "No students";
				}
			?>
			</div>
		</div>
		</div>
	</div>
</div>

<?php }else{$type=='student' ? redirect_to('courses.php') : redirect_to('classes.php');} ?>

<script>
	// ---------------------- modify course structure(edit area show) ----------------------------------
	$('.edit-area-showBtn').click(function(){
		$('.md-lists p, .edit-area-showBtn').hide();
		$('.md-lists form').fadeIn(500);
	});
</script>

<?php include('../partials/s_footer.php'); ?>
<?php include('../db/close.php'); ?>
