<!--Attendance modal -->
<div class="modal" id="attendanceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form action="../controllers/classroom.php" method="POST" id="atdcModalForm">
    	<?php
    		$query7="SELECT exam_marks.* FROM exam_marks INNER JOIN enrollments ON exam_marks.enrollmentId=enrollments.id AND enrollments.classId='{$classId}' WHERE exam_marks.type='attendance'";
    		$res7=mysqli_query($connection, $query7);
    	?>		

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Class Attendance Students Marks</h4>
      </div>
      <div class="modal-body">
      	<?php if(mysqli_num_rows($res7)<1){ ?>
      	<div class="row">
      		<div class="col-md-12 text-center">
      			<div class="row">
  				<div class="col-md-8 text-right">Attendance(%):</div>
  				<div class="col-md-4">
  					<input type="number" class="form-control" id="attendanceMark" name="attendanceMark" value="<?php echo (int)getMarkDist($classId)['attendance']; ?>" readonly>
  				</div>
  				</div>
  			</div>
  			</div>
  			<br>
      	
      		<div class="row">
      			<br>
      		<input type="hidden" name="examType" value="attendance">
      		<input type="hidden" name="classId" value="<?php echo $classId; ?>">
      	<?php
      		$count=0;
      		$query4="SELECT * FROM enrollments WHERE classId='{$classId}'";
      		$res4=mysqli_query($connection, $query4);

      		while($row=mysqli_fetch_array($res4)){
      			$count++;
			?>
					<div class="col-md-2">#<?php echo $count; ?></div>
					<div class="col-md-6"><?php echo ucwords(getUser($row['userId'])['name']); ?></div>
					<div class="col-md-4"><input type="number" class="form-control" name="user[<?php echo $row['id']; ?>]" max="<?php echo (int)getMarkDist($classId)['attendance']; ?>" placeholder="Enter marks" required>
					<br></div>
      	<?php
      		}
      	?>
      		</div>
      	<?php }else{ echo "<p style=\"color: green\">Attendance marks already submitted!"; } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <?php if(mysqli_num_rows($res7)<1){ ?>
        <button type="submit" name="add-attendance" class="btn btn-primary">Submit</button>
        <?php } ?>
      </div>
      
      </form>
    </div>
  </div>
</div>