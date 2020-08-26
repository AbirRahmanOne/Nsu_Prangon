<?php if($type=='faculty'){ ?>
<div role="tabpanel" class="tab-pane" id="structure">
	<br><br>
	<h3 style="color: gray;">MARK DISTRIBUTIONS</h3>
	<hr>

	<?php if(isset($_SESSION['markDistributionFailed'])){ ?>
	<div class="alert alert-danger"><?php echo $_SESSION['markDistributionFailed']; ?></div>
	<script>
		$('#homeTl, #home').removeClass('active');
		$('#structureTl, #structure').addClass('active');
	</script>
	<?php unset($_SESSION['markDistributionFailed']);} ?>

	<?php if(isset($_SESSION['markDistributionSuccess'])){ ?>
	<div class="alert alert-success"><?php echo $_SESSION['markDistributionSuccess']; ?></div>
	<script>
		$('#homeTl, #home').removeClass('active');
		$('#structureTl, #structure').addClass('active');
	</script>
	<?php unset($_SESSION['markDistributionSuccess']);} ?>

	<div class="row">
		<?php
    		$query3="SELECT * FROM mark_dis WHERE classId='{$classId}'";
    		$res3=mysqli_query($connection, $query3);
    		if(mysqli_num_rows($res3)<1){
    	?>
		<form action="../controllers/classroom.php" method="POST">
		<input type="hidden" name="class-id" value="<?php echo $classId; ?>">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-4"><label class="atdc" for="attendance">Attendance:</label></div>
				<div class="col-md-8"><input type="number" id="attendance" name="attendance" class="form-control" placeholder="How %?"></div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-3"><label for="quizzes">Quiz's:</label></div>
				<div class="col-md-9"><input type="number" id="quizzes" name="quizzes" class="form-control" placeholder="How %?"></div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-4"><label for="midterms">Midterm's:</label></div>
				<div class="col-md-8"><input type="number" id="midterms" name="midterms" class="form-control" placeholder="How %?"><br></div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-4"><label for="hws">HW's:</label></div>
				<div class="col-md-8"><input type="number" id="hws" name="hws" class="form-control" placeholder="How %?"></div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-3"><label for="final">Final:</label></div>
				<div class="col-md-9"><input type="number" id="final" name="final" class="form-control" placeholder="How %?"></div>
			</div>
		</div>
		<div class="col-md-4">
			<button type="submit" name="mark-distribution" class="btn btn-block btn-info">Save</button>
		</div>
		</form>

		<?php } ?>

	</div>
	<?php if(mysqli_num_rows($res3)>0){
		while($row=mysqli_fetch_array($res3)){
	?>
	<div class="md-lists">
	<p>
		Attendance: <span class="mark"><?php echo $row['attendance']; ?>%</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Quiz's: <span class="mark"><?php echo $row['quiz']; ?>%</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Midterm's: <span class="mark"><?php echo $row['midterm']; ?>%</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		HW/Assignment's: <span class="mark"><?php echo $row['hw']; ?>%</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Final: <span class="mark"><?php echo $row['final']; ?>%</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</p>

	<button class="btn btn-info edit-area-showBtn">Edit</button>

	<form action="../controllers/classroom.php" method="POST" hidden>
		<input type="hidden" name="class-id" value="<?php echo $classId; ?>">
		<div class="row">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-4"><label class="atdc" for="attendance">Attendance:</label></div>
				<div class="col-md-8"><input type="number" id="attendance" name="attendance" class="form-control" value="<?php echo $row['attendance']; ?>"></div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-4"><label for="quizzes">Quiz's:</label></div>
				<div class="col-md-8"><input type="number" id="quizzes" name="quizzes" class="form-control" value="<?php echo $row['quiz']; ?>"></div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-4"><label for="midterms">Midterm's:</label></div>
				<div class="col-md-8"><input type="number" id="midterms" name="midterms" class="form-control" value="<?php echo $row['midterm']; ?>"><br></div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-4"><label for="hws">HW's:</label></div>
				<div class="col-md-8"><input type="number" id="hws" name="hws" class="form-control" value="<?php echo $row['hw']; ?>"></div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-4"><label for="final">Final:</label></div>
				<div class="col-md-8"><input type="number" id="final" name="final" class="form-control" value="<?php echo $row['final']; ?>"></div>
			</div>
		</div>
		<div class="col-md-4">
			<button type="submit" name="mark-distribution-update" class="btn btn-block btn-info">Update</button>
			<br>
			<br>
		</div>
		</div>
		</form>
	</div>

	<?php
	}}?>

</div>

<?php } ?>