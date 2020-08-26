<!--- Midterm modal -->
<div class="modal" id="hwModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	<form action="../controllers/classroom.php" method="POST" id="hwModalForm">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php
        	$tempArr2=[];
        	$queryH="SELECT exam_marks.exam FROM exam_marks INNER JOIN enrollments ON exam_marks.enrollmentId=enrollments.id AND enrollments.classId='{$classId}' WHERE type='hw'";
			$resH=mysqli_query($connection, $queryH);
			while($rowH=mysqli_fetch_array($resH))
				array_push($tempArr2, $rowH['exam']);
			$countHw=sizeof((array_unique($tempArr2)))+1;
        ?>
        <h4 class="modal-title" id="myModalLabel">HW <?php echo $countHw; ?></h4>
      </div>
      <div class="modal-body">
      		<div class="row">
      		<div class="col-md-12 text-center">
      			<div class="row">
  				<div class="col-md-8 text-right">Total HW mark:</div>
  				<div class="col-md-4">
  					<input type="number" class="form-control" id="totalMark" name="totalMark" placeholder="Enter HW mark" required>
  				</div>
  				</div>
  			</div>
  			</div>
  			<br>
      	
      		<div class="row">
      			<br>
      		<input type="hidden" name="examType" value="hw">
      		<input type="hidden" name="classId" value="<?php echo $classId; ?>">
      	<?php
      		$count=0;
      		$query11="SELECT * FROM enrollments WHERE classId='{$classId}'";
      		$res11=mysqli_query($connection, $query11);

      		while($row=mysqli_fetch_array($res11)){
      			$count++;
			?>
					<div class="col-md-2">#<?php echo $count; ?></div>
					<div class="col-md-6"><?php echo ucwords(getUser($row['userId'])['name']); ?></div>
					<div class="col-md-4"><input type="number" class="form-control" name="user[<?php echo $row['id']; ?>]" max="" placeholder="Enter marks" required>
					<br></div>
			<?php
      		}
      	?>
      		</div>
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="hw-marks" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>