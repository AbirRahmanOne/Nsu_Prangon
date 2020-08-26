<!--- Midterm modal -->
<div class="modal" id="midtermModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	<form action="../controllers/classroom.php" method="POST" id="midtermModalForm">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php
        	$tempArr1=[];
        	$queryM="SELECT exam_marks.exam FROM exam_marks INNER JOIN enrollments ON exam_marks.enrollmentId=enrollments.id AND enrollments.classId='{$classId}' WHERE type='midterm'";
			$resM=mysqli_query($connection, $queryM);
			while($rowM=mysqli_fetch_array($resM))
				array_push($tempArr1, $rowM['exam']);
			$countMid=sizeof((array_unique($tempArr1)))+1;
        ?>
        <h4 class="modal-title" id="myModalLabel">Midterm <?php echo $countMid; ?></h4>
      </div>
      <div class="modal-body">
      		<div class="row">
      		<div class="col-md-12 text-center">
      			<div class="row">
  				<div class="col-md-8 text-right">Total Midterm mark:</div>
  				<div class="col-md-4">
  					<input type="number" class="form-control" id="totalMark" name="totalMark" placeholder="Enter midterm mark" required>
  				</div>
  				</div>
  			</div>
  			</div>
  			<br>
      	
      		<div class="row">
      			<br>
      		<input type="hidden" name="examType" value="midterm">
      		<input type="hidden" name="classId" value="<?php echo $classId; ?>">
      	<?php
      		$count=0;
      		$query10="SELECT * FROM enrollments WHERE classId='{$classId}'";
      		$res10=mysqli_query($connection, $query10);

      		while($row=mysqli_fetch_array($res10)){
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
        <button type="submit" name="midterm-marks" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>