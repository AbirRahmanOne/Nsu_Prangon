<!-- ....... For faculty ........ -->
<?php if($type=='faculty'){ ?>
<div role="tabpanel" class="tab-pane" id="grades">
	<br><br>
	<h4>PROVIDE EXAM MARKS:</h4>
	<hr>

	<!-- ------------------------ Session flash message with modal show with js ------------------------ -->
	<?php if(isset($_SESSION['quizMarksAdded'])){ ?>
	<div class="alert alert-success"><?php echo $_SESSION['quizMarksAdded']; ?></div>
	<script>
		$('#homeTl, #home').removeClass('active');
		$('#gradesTl, #grades').addClass('active');
	</script>
	<?php unset($_SESSION['quizMarksAdded']);} ?>

	<?php if(isset($_SESSION['atdcMarksAdded'])){ ?>
	<div class="alert alert-success"><?php echo $_SESSION['atdcMarksAdded']; ?></div>
	<script>
		$('#homeTl, #home').removeClass('active');
		$('#gradesTl, #grades').addClass('active');
	</script>
	<?php unset($_SESSION['atdcMarksAdded']);} ?>

	<?php if(isset($_SESSION['midtermMarksAdded'])){ ?>
	<div class="alert alert-success"><?php echo $_SESSION['midtermMarksAdded']; ?></div>
	<script>
		$('#homeTl, #home').removeClass('active');
		$('#gradesTl, #grades').addClass('active');
	</script>
	<?php unset($_SESSION['midtermMarksAdded']);} ?>

	<?php if(isset($_SESSION['hwMarksAdded'])){ ?>
	<div class="alert alert-success"><?php echo $_SESSION['hwMarksAdded']; ?></div>
	<script>
		$('#homeTl, #home').removeClass('active');
		$('#gradesTl, #grades').addClass('active');
	</script>
	<?php unset($_SESSION['hwMarksAdded']);} ?>

	<?php if(isset($_SESSION['finalMarksAdded'])){ ?>
	<div class="alert alert-success"><?php echo $_SESSION['finalMarksAdded']; ?></div>
	<script>
		$('#homeTl, #home').removeClass('active');
		$('#gradesTl, #grades').addClass('active');
	</script>
	<?php unset($_SESSION['finalMarksAdded']);} ?>

		
	<div class="row">
		<div class="col-md-12">
		<div class="btn-group btn-group-justified" role="group">
		<div class="btn-group" role="group"><button class="btn btn-info attendaceModal" data-toggle="modal" data-target="#attendanceModal">Attendance</button></div>
		<div class="btn-group" role="group"><button class="btn btn-info quizModal" data-toggle="modal" data-target="#quizModal">Quiz</button></div>
		<div class="btn-group" role="group"><button class="btn btn-info midtermModal" data-toggle="modal" data-target="#midtermModal">Midterm</button></div>
		<div class="btn-group" role="group"><button class="btn btn-info hwModal" data-toggle="modal" data-target="#hwModal">HW</button></div>
		<div class="btn-group" role="group"><button class="btn btn-info finalModal" data-toggle="modal" data-target="#finalModal">Final</button></div>
		</div>
		</div>

		<div class="col-md-12"><br><br><br><h4>STUDENT'S STATISTICS:</h4><hr></div>
		<div class="row">

		<!-- ---------------------------- Attendance Mark show ---------------------------- -->
		<div class="col-md-12">
			<?php
				$query8="SELECT exam_marks.*, enrollments.userId FROM exam_marks INNER JOIN enrollments ON exam_marks.enrollmentId=enrollments.id AND enrollments.classId='{$classId}' WHERE exam_marks.type='attendance'";
				$res8=mysqli_query($connection, $query8);
				if(mysqli_num_rows($res8)>0){
			?>
			<div class="col-md-2"><button class="btn btn-info btn-block attendaceModal" data-toggle="modal" data-target="#atdcMark">Attendance</button></div>

			<div class="modal" id="atdcMark" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="myModalLabel">Attendance Marks</h4>
				      </div>
				      <div class="modal-body">
				      	<table class="table table-striped">
				      		<thead>
				      			<tr>
				      				<th>#</th>
				      				<th>Name</th>
				      				<th>Total Mark</th>
				      				<th>Obtained Mark</th>
				      				<th><?php echo getMarkDist($classId)['attendance']; ?>% Mark</th>
				      			</tr>
				      		</thead>
				      		<tbody>
				      		<?php
				      			$aC=0;
				      			$query9="SELECT exam_marks.*, enrollments.userId FROM exam_marks INNER JOIN enrollments ON exam_marks.enrollmentId=enrollments.id AND exam_marks.type='attendance' WHERE enrollments.classId='{$classId}'";
				      			$res9=mysqli_query($connection, $query9);
				      			while($row=mysqli_fetch_array($res9)){
				      				$aC++;
				      		?>
				      			<tr>
		    						<td><?php echo $aC; ?></td>
		    						<td><?php echo ucwords(getUser($row['userId'])['name']); ?></td>
		    						<td><?php echo $row['total_mark']; ?></td>
		    						<td><?php echo $row['mark']; ?></td>
		    						<td><?php
		    							$total=(int)$row['total_mark'];
		    							$obtained=(int)$row['mark'];
		    							$percent=(int)getMarkDist($classId)['attendance'];
		    							$res=($obtained*$percent)/$total;
		    							echo number_format($res, 2);
		    						?></td>
								</tr>
				      		<?php
				      			}
				      		?>
				      		</tbody>
			      		</table>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				      </div>
				    </div>
				  </div>
				</div>
			<?php
				}
			?>
		</div>

		<div class="col-md-12"><br></div>

		<!-- ------------------------------ Quiz Mark show -------------------------------- -->
		<div class="col-md-12">
			<?php
				// ------------------ Filter quiz number ---------------------
				$quizCount=[];
				$query5="SELECT exam_marks.*, enrollments.userId FROM exam_marks INNER JOIN enrollments ON exam_marks.enrollmentId=enrollments.id AND enrollments.classId='{$classId}' WHERE exam_marks.type='quiz'";
				$res5=mysqli_query($connection, $query5);
				while($row=mysqli_fetch_array($res5)){
					array_push($quizCount, $row['exam']);
				}

				$allQuizzes=array_unique($quizCount);

				// ----------------- Get quiz marks ------------------
				if(!empty($allQuizzes)){
					foreach($allQuizzes as $val){
				?>
				<div class="col-md-2"><button class="btn btn-info btn-block quizModal" data-toggle="modal" data-target="#<?php echo $val; ?>"><?php
							$qNum=filter_var($val, FILTER_SANITIZE_NUMBER_INT);
							$qArr=explode($qNum, $val);
							echo ucfirst($qArr['0']).' '.$qNum;
						?></button><br></div>

						<div class="modal" id="<?php echo $val; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="myModalLabel"><?php echo ucfirst($qArr['0']).' '.$qNum; ?>:&nbsp;&nbsp;Students Marks</h4>
						      </div>
						      <div class="modal-body">
						      	<table class="table table-striped">
						      		<thead>
						      			<tr>
						      				<th>#</th>
						      				<th>Name</th>
						      				<th>Total Mark</th>
						      				<th>Obtained Mark</th>
						      				<th><?php echo getMarkDist($classId)['quiz']; ?>% Mark</th>
						      			</tr>
						      		</thead>
						      		<tbody>
						      			
						      		
				<?php
						$qC=0;
						$query6="SELECT exam_marks.*, enrollments.userId FROM exam_marks INNER JOIN enrollments ON exam_marks.enrollmentId=enrollments.id AND exam_marks.exam='{$val}' WHERE enrollments.classId='{$classId}'";
						$res6=mysqli_query($connection, $query6);
						while($row=mysqli_fetch_array($res6)){
							$qC++;
				?>
				<tr>
					<td><?php echo $qC; ?></td>
					<td><?php echo ucwords(getUser($row['userId'])['name']); ?></td>
					<td><?php echo $row['total_mark']; ?></td>
					<td><?php echo $row['mark']; ?></td>
					<td><?php
						$total=(int)$row['total_mark'];
						$obtained=(int)$row['mark'];
						$percent=(int)getMarkDist($classId)['quiz'];
						$res=($obtained*$percent)/$total;
						echo number_format($res, 2);
					?></td>
				</tr>
				<?php
						}
				?>
						</tbody>
					      	</table>
					</div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					  </div>
					</div>
				<?php
					}
				}
			?>
		</div>

		<div class="col-md-12"><br></div>

		<!-- ------------------------------ Midterm Mark show ----------------------------- -->
		<div class="col-md-12">
			<?php
				// ------------------ Filter midterm number ---------------------
				$midtermCount=[];
				$query11="SELECT exam_marks.*, enrollments.userId FROM exam_marks INNER JOIN enrollments ON exam_marks.enrollmentId=enrollments.id AND enrollments.classId='{$classId}' WHERE exam_marks.type='midterm'";
				$res11=mysqli_query($connection, $query11);
				while($row=mysqli_fetch_array($res11)){
					array_push($midtermCount, $row['exam']);
				}

				$allMidterms=array_unique($midtermCount);

				// ----------------- Get midterm marks ------------------
				if(!empty($allMidterms)){
					foreach($allMidterms as $val){
				?>
				<div class="col-md-2"><button class="btn btn-info btn-block midtermModal" data-toggle="modal" data-target="#<?php echo $val; ?>"><?php
							$mNum=filter_var($val, FILTER_SANITIZE_NUMBER_INT);
							$mArr=explode($mNum, $val);
							echo ucfirst($mArr['0']).' '.$mNum;
						?></button></div>

						<div class="modal" id="<?php echo $val; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="myModalLabel"><?php echo ucfirst($mArr['0']).' '.$mNum; ?>:&nbsp;&nbsp;Students Marks</h4>
						      </div>
						      <div class="modal-body">
						      	<table class="table table-striped">
						      		<thead>
						      			<tr>
						      				<th>#</th>
						      				<th>Name</th>
						      				<th>Total Mark</th>
						      				<th>Obtained Mark</th>
						      				<th><?php echo getMarkDist($classId)['midterm']; ?>% Mark</th>
						      			</tr>
						      		</thead>
						      		<tbody>
						      			
						      		
				<?php
						$mC=0;
						$query12="SELECT exam_marks.*, enrollments.userId FROM exam_marks INNER JOIN enrollments ON exam_marks.enrollmentId=enrollments.id AND exam_marks.exam='{$val}' WHERE enrollments.classId='{$classId}'";
						$res12=mysqli_query($connection, $query12);
						while($row=mysqli_fetch_array($res12)){
							$mC++;
				?>
				<tr>
					<td><?php echo $mC; ?></td>
					<td><?php echo ucwords(getUser($row['userId'])['name']); ?></td>
					<td><?php echo $row['total_mark']; ?></td>
					<td><?php echo $row['mark']; ?></td>
					<td><?php
						$total=(int)$row['total_mark'];
						$obtained=(int)$row['mark'];
						$percent=(int)getMarkDist($classId)['midterm'];
						$res=($obtained*$percent)/$total;
						echo number_format($res, 2);
					?></td>
				</tr>
				<?php
						}
				?>
						</tbody>
					      	</table>
					</div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					  </div>
					</div>
				<?php
					}
				}
			?>
		</div>

		<div class="col-md-12"><br></div>

		<!-- ------------------------------ HW Mark show ----------------------------- -->
		<div class="col-md-12">
			<?php
				// ------------------ Filter hw number ---------------------
				$hwCount=[];
				$query12="SELECT exam_marks.*, enrollments.userId FROM exam_marks INNER JOIN enrollments ON exam_marks.enrollmentId=enrollments.id AND enrollments.classId='{$classId}' WHERE exam_marks.type='hw'";
				$res12=mysqli_query($connection, $query12);
				while($row=mysqli_fetch_array($res12)){
					array_push($hwCount, $row['exam']);
				}

				$allhws=array_unique($hwCount);

				// ----------------- Get hw marks ------------------
				if(!empty($allhws)){
					foreach($allhws as $val){
				?>
				<div class="col-md-2"><button class="btn btn-info btn-block hwModal" data-toggle="modal" data-target="#<?php echo $val; ?>"><?php
							$hNum=filter_var($val, FILTER_SANITIZE_NUMBER_INT);
							$hArr=explode($hNum, $val);
							echo ucfirst($hArr['0']).' '.$hNum;
						?></button></div>

						<div class="modal" id="<?php echo $val; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="myModalLabel"><?php echo ucfirst($hArr['0']).' '.$hNum; ?>:&nbsp;&nbsp;Students Marks</h4>
						      </div>
						      <div class="modal-body">
						      	<table class="table table-striped">
						      		<thead>
						      			<tr>
						      				<th>#</th>
						      				<th>Name</th>
						      				<th>Total Mark</th>
						      				<th>Obtained Mark</th>
						      				<th><?php echo getMarkDist($classId)['hw']; ?>% Mark</th>
						      			</tr>
						      		</thead>
						      		<tbody>
						      			
						      		
				<?php
						$mC=0;
						$query12="SELECT exam_marks.*, enrollments.userId FROM exam_marks INNER JOIN enrollments ON exam_marks.enrollmentId=enrollments.id AND exam_marks.exam='{$val}' WHERE enrollments.classId='{$classId}'";
						$res12=mysqli_query($connection, $query12);
						while($row=mysqli_fetch_array($res12)){
							$mC++;
				?>
				<tr>
					<td><?php echo $mC; ?></td>
					<td><?php echo ucwords(getUser($row['userId'])['name']); ?></td>
					<td><?php echo $row['total_mark']; ?></td>
					<td><?php echo $row['mark']; ?></td>
					<td><?php
						$total=(int)$row['total_mark'];
						$obtained=(int)$row['mark'];
						$percent=(int)getMarkDist($classId)['hw'];
						$res=($obtained*$percent)/$total;
						echo number_format($res, 2);
					?></td>
				</tr>
				<?php
						}
				?>
						</tbody>
					      	</table>
					</div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					  </div>
					</div>
				<?php
					}
				}
			?>
		</div>

		<div class="col-md-12"><br></div>

		<!-- ---------------------------- Final Mark show ---------------------------- -->
		<div class="col-md-12">
			<?php
				$query12="SELECT exam_marks.*, enrollments.userId FROM exam_marks INNER JOIN enrollments ON exam_marks.enrollmentId=enrollments.id AND enrollments.classId='{$classId}' WHERE exam_marks.type='final'";
				$res12=mysqli_query($connection, $query12);
				if(mysqli_num_rows($res12)>0){
			?>
			<div class="col-md-2"><button class="btn btn-info btn-block finalModal" data-toggle="modal" data-target="#finalModal1">Final</button></div>

			<div class="modal" id="finalModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="myModalLabel">Final Marks</h4>
				      </div>
				      <div class="modal-body">
				      	<table class="table table-striped">
				      		<thead>
				      			<tr>
				      				<th>#</th>
				      				<th>Name</th>
				      				<th>Total Mark</th>
				      				<th>Obtained Mark</th>
				      				<th><?php echo getMarkDist($classId)['final']; ?>% Mark</th>
				      			</tr>
				      		</thead>
				      		<tbody>
				      		<?php
				      			$fC=0;
				      			$query13="SELECT exam_marks.*, enrollments.userId FROM exam_marks INNER JOIN enrollments ON exam_marks.enrollmentId=enrollments.id AND exam_marks.type='final' WHERE enrollments.classId='{$classId}'";
				      			$res13=mysqli_query($connection, $query13);
				      			while($row=mysqli_fetch_array($res13)){
				      				$fC++;
				      		?>
				      			<tr>
		    						<td><?php echo $fC; ?></td>
		    						<td><?php echo ucwords(getUser($row['userId'])['name']); ?></td>
		    						<td><?php echo $row['total_mark']; ?></td>
		    						<td><?php echo $row['mark']; ?></td>
		    						<td><?php
		    							$total=(int)$row['total_mark'];
		    							$obtained=(int)$row['mark'];
		    							$percent=(int)getMarkDist($classId)['final'];
		    							$res=($obtained*$percent)/$total;
		    							echo number_format($res, 2);
		    						?></td>
								</tr>
				      		<?php
				      			}
				      		?>
				      		</tbody>
			      		</table>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				      </div>
				    </div>
				  </div>
				</div>
			<?php
				}
			?>
		</div>

		<div class="col-md-12"><br><br></div>

		</div>


		<!--Attendance modal -->
		<?php include('modal/gradesTabAttendanceModal.php'); ?>

		<!--Quiz modal -->
		<?php include('modal/gradesTabQuizModal.php'); ?>

		<!--Midterm modal -->
		<?php include('modal/gradesTabMidtermModal.php'); ?>

		<!--HW modal -->
		<?php include('modal/gradesTabHwModal.php'); ?>

		<!--Final modal -->
		<?php include('modal/gradesTabFinalModal.php'); ?>

	</div>
	
</div>
<?php } ?>









<!-- ....... For student ........ -->
<?php if($type=='student'){ ?>
<div role="tabpanel" class="tab-pane" id="grades">
	<?php
		$attendancePercent=$quizPercent=$midtermPercent=$hwPercent=$finalPercent=[];

		$query="SELECT exam_marks.*, enrollments.userId FROM exam_marks INNER JOIN enrollments ON exam_marks.enrollmentId=enrollments.id AND enrollments.classId='{$classId}' WHERE enrollments.userId='{$studentId}'";
		$res=mysqli_query($connection, $query);
		while($row=mysqli_fetch_array($res)){
			$total=(int)$row['total_mark'];
			$obtained=(int)$row['mark'];

			switch($row['type']){
				case 'attendance': $attendanceMarksFromTable[$row['id']]=['exam'=>$row['exam'], 'total_mark'=>$row['total_mark'], 'mark'=>$row['mark'], 'enrollmentId'=>$row['enrollmentId']];
					$percent=(int)getMarkDist($classId)['attendance'];
					$convert=($obtained*$percent)/$total;
					array_push($attendancePercent, $convert);
					break;
				case 'quiz': $quizMarksFromTable[$row['id']]=['exam'=>$row['exam'], 'total_mark'=>$row['total_mark'], 'mark'=>$row['mark'], 'enrollmentId'=>$row['enrollmentId']];
					$percent=(int)getMarkDist($classId)['quiz'];
					$convert=($obtained*$percent)/$total;
					array_push($quizPercent, $convert);
					break;
				case 'midterm': $midtermMarksFromTable[$row['id']]=['exam'=>$row['exam'], 'total_mark'=>$row['total_mark'], 'mark'=>$row['mark'], 'enrollmentId'=>$row['enrollmentId']];
					$percent=(int)getMarkDist($classId)['midterm'];
					$convert=($obtained*$percent)/$total;
					array_push($midtermPercent, $convert);
					break;
				case 'hw': $hwMarksFromTable[$row['id']]=['exam'=>$row['exam'], 'total_mark'=>$row['total_mark'], 'mark'=>$row['mark'], 'enrollmentId'=>$row['enrollmentId']];
					$percent=(int)getMarkDist($classId)['hw'];
					$convert=($obtained*$percent)/$total;
					array_push($hwPercent, $convert);
					break;
				case 'final': $finalMarksFromTable[$row['id']]=['exam'=>$row['exam'], 'total_mark'=>$row['total_mark'], 'mark'=>$row['mark'], 'enrollmentId'=>$row['enrollmentId']];
					$percent=(int)getMarkDist($classId)['final'];
					$convert=($obtained*$percent)/$total;
					array_push($finalPercent, $convert);
					break;
				default: $do=false;
			}
		}
	?>
	<br><br>

	<!-- ---------------------------- Overall progress --------------------------- -->
	<div class="row">
		<div class="col-md-4">
			<div class="list-group">
				<a href="#" class="list-group-item disabled">Mark Distribution</a>
				<a href="#studentAttendanceMark" class="list-group-item">Attendance <span class="badge"><?php echo getMarkDist($classId)['attendance']; ?> %</span></a>
				<a href="#studentQuizMarks" class="list-group-item">Quizz's <span class="badge"><?php echo getMarkDist($classId)['quiz']; ?> %</span></a>
				<a href="#studentMidtermMarks" class="list-group-item">Midterm's <span class="badge"><?php echo getMarkDist($classId)['midterm']; ?> %</span></a>
				<a href="#studentHWMarks" class="list-group-item">Homework's <span class="badge"><?php echo getMarkDist($classId)['hw']; ?> %</span></a>
				<a href="#studentFinalMark" class="list-group-item">Final <span class="badge"><?php echo getMarkDist($classId)['final']; ?> %</span></a>
			</div>
		</div>

		<div class="col-md-8">
			<div class="list-group">
				<a href="#" class="list-group-item disabled">Name: Your name</a>
				<a href="#studentAttendanceMark" class="list-group-item">
					Attendance
					<span class="badge">
					<?php
						if(empty($attendancePercent))
							echo 'Not submitted';
						else{
							$eNum=count($attendancePercent);
							$eNumP=(float)array_sum($attendancePercent);
							echo number_format($eNumP/$eNum, 2);
						}
					?>
					</span>
				</a>
				<a href="#studentQuizMarks" class="list-group-item">
					Quizz's
					<span class="badge">
						<?php
							if(empty($quizPercent))
								echo 'Not submitted';
							else{
								$eNum=count($quizPercent);
								$eNumP=(float)array_sum($quizPercent);
								echo number_format($eNumP/$eNum, 2);
							}
						?>
					</span>
				</a>
				<a href="#studentMidtermMarks" class="list-group-item">
					Midterm's
					<span class="badge">
						<?php
							if(empty($midtermPercent))
								echo 'Not submitted';
							else{
								$eNum=count($midtermPercent);
								$eNumP=(float)array_sum($midtermPercent);
								echo number_format($eNumP/$eNum, 2);
							}
						?>
					</span>
				</a>
				<a href="#studentHWMarks" class="list-group-item">
					Homework's
					<span class="badge">
						<?php
							if(empty($hwPercent))
								echo 'Not submitted';
							else{
								$eNum=count($hwPercent);
								$eNumP=(float)array_sum($hwPercent);
								echo number_format($eNumP/$eNum, 2);
							}
						?>
					</span>
				</a>
				<a href="#studentFinalMark" class="list-group-item">
					Final
					<span class="badge">
						<?php
							if(empty($finalPercent))
								echo 'Not submitted';
							else{
								$eNum=count($finalPercent);
								$eNumP=(float)array_sum($finalPercent);
								echo number_format($eNumP/$eNum, 2);
							}
						?>
					</span>
				</a>
			</div>
		</div>
	</div>


	<br>
	<!-- --------------------------- Attendance mark ------------------------------ -->
	<h4 id="studentAttendanceMark">ATTENDANCE MARK:</h4>
	<hr>
	<?php if(empty($attendanceMarksFromTable)){ echo "<p style=\"color: red\">Attendance mark not given yet!</p>"; }
		else{
	?>
	<div style="background: #EEE; box-shadow: 0 2px 3px #CCC">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Exam</th>
				<th>Total Mark(%)</th>
				<th>Total <?php echo getMarkDist($classId)['attendance']; ?>%</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$count=0;
				foreach($attendanceMarksFromTable as $id=>$row){
					$count++;
			?>
				<tr>
					<td><?php echo $count; ?></td>
					<td><?php echo ucfirst($row['exam']); ?></td>
					<td><?php echo $row['total_mark']; ?></td>
					<td><?php echo $row['mark']; ?></td>
				</tr>
			<?php
				}
			?>
		</tbody>
	</table>
	</div>
	<?php } ?>

	<br>

	<!-- --------------------------- Quiz marks ------------------------------ -->
	<h4 id="studentQuizMarks">QUIZ MARKS:</h4>
	<hr>
	<?php if(empty($quizMarksFromTable)){ echo "<p style=\"color: red\">No Quiz marks given yet!</p>"; }
		else{
	?>
	<div style="background: #EEE; box-shadow: 0 2px 3px #CCC">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Exam</th>
				<th>Total Mark</th>
				<th>Obtained Mark</th>
				<th>Total <?php echo getMarkDist($classId)['quiz']; ?>%</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$count=0;
				foreach($quizMarksFromTable as $id=>$row){
					$count++;
			?>
				<tr>
					<td><?php echo $count; ?></td>
					<td><?php
						$qNum=filter_var($row['exam'], FILTER_SANITIZE_NUMBER_INT);
						$qArr=explode($qNum, $row['exam']);
						echo ucfirst($qArr[0]).' '.$qNum;
					?></td>
					<td><?php echo $row['total_mark']; ?></td>
					<td><?php echo $row['mark']; ?></td>
					<td><?php
						$total=(int)$row['total_mark'];
						$obtained=(int)$row['mark'];
						$percent=(int)getMarkDist($classId)['quiz'];
						$convert=($obtained*$percent)/$total;
						echo number_format($convert, 2);
					?></td>
				</tr>
			<?php
				}
			?>
		</tbody>
	</table>
	</div>
	<?php } ?>

	<br>

	<!-- --------------------------- Midterm marks ------------------------------ -->
	<h4 id="studentMidtermMarks">MIDTERM MARKS:</h4>
	<hr>
	<?php if(empty($midtermMarksFromTable)){ echo "<p style=\"color: red\">No Midterm marks given yet!</p>"; }
		else{
	?>
	<div style="background: #EEE; box-shadow: 0 2px 3px #CCC">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Exam</th>
				<th>Total Mark</th>
				<th>Obtained Mark</th>
				<th>Total <?php echo getMarkDist($classId)['midterm']; ?>%</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$count=0;
				foreach($midtermMarksFromTable as $id=>$row){
					$count++;
			?>
				<tr>
					<td><?php echo $count; ?></td>
					<td><?php
						$qNum=filter_var($row['exam'], FILTER_SANITIZE_NUMBER_INT);
						$qArr=explode($qNum, $row['exam']);
						echo ucfirst($qArr[0]).' '.$qNum;
					?></td>
					<td><?php echo $row['total_mark']; ?></td>
					<td><?php echo $row['mark']; ?></td>
					<td><?php
						$total=(int)$row['total_mark'];
						$obtained=(int)$row['mark'];
						$percent=(int)getMarkDist($classId)['midterm'];
						$convert=($obtained*$percent)/$total;
						echo number_format($convert, 2);
					?></td>
				</tr>
			<?php
				}
			?>
		</tbody>
	</table>
	</div>
	<?php } ?>

	<br>
	<!-- --------------------------- HW marks ------------------------------ -->
	<h4 id="studentHWMarks">HOMEWORKS MARKS:</h4>
	<hr>
	<?php if(empty($hwMarksFromTable)){ echo "<p style=\"color: red\">No HW marks given yet!</p>"; }
		else{
	?>
	<div style="background: #EEE; box-shadow: 0 2px 3px #CCC">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Exam</th>
				<th>Total Mark</th>
				<th>Obtained Mark</th>
				<th>Total <?php echo getMarkDist($classId)['hw']; ?>%</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$count=0;
				foreach($hwMarksFromTable as $id=>$row){
					$count++;
			?>
				<tr>
					<td><?php echo $count; ?></td>
					<td><?php
						$qNum=filter_var($row['exam'], FILTER_SANITIZE_NUMBER_INT);
						$qArr=explode($qNum, $row['exam']);
						echo ucfirst($qArr[0]).' '.$qNum;
					?></td>
					<td><?php echo $row['total_mark']; ?></td>
					<td><?php echo $row['mark']; ?></td>
					<td><?php
						$total=(int)$row['total_mark'];
						$obtained=(int)$row['mark'];
						$percent=(int)getMarkDist($classId)['hw'];
						$convert=($obtained*$percent)/$total;
						echo number_format($convert, 2);
					?></td>
				</tr>
			<?php
				}
			?>
		</tbody>
	</table>
	</div>
	<?php } ?>

	<br>
	<!-- --------------------------- Final marks ------------------------------ -->
	<h4 id="studentFinalMark">FINAL MARKS:</h4>
	<hr>
	<?php if(empty($finalMarksFromTable)){ echo "<p style=\"color: red\">Final marks not given yet!</p>"; }
		else{
	?>
	<div style="background: #EEE; box-shadow: 0 2px 3px #CCC">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Exam</th>
				<th>Total Mark</th>
				<th>Obtained Mark</th>
				<th><?php echo getMarkDist($classId)['final']; ?>%</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$count=0;
				foreach($finalMarksFromTable as $id=>$row){
					$count++;
			?>
				<tr>
					<td><?php echo $count; ?></td>
					<td><?php echo ucfirst($row['exam']); ?></td>
					<td><?php echo $row['total_mark']; ?></td>
					<td><?php echo $row['mark']; ?></td>
					<td><?php
						$total=(int)$row['total_mark'];
						$obtained=(int)$row['mark'];
						$percent=(int)getMarkDist($classId)['final'];
						$convert=($obtained*$percent)/$total;
						echo number_format($convert, 2);
					?></td>
				</tr>
			<?php
				}
			?>
		</tbody>
	</table>
	</div>
	<?php } ?>
	<br><br>

</div>
<?php } ?>