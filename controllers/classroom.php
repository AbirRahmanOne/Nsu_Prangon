<?php session_start(); ?>
<?php include('../db/connect.php'); ?>
<?php include('../helpers/function.php'); ?>

<?php
	if(isset($_POST['mark-distribution'])){
		$classId=$_POST['class-id'];
		$attendance=(int)$_POST['attendance'];
		$quizzes=(int)$_POST['quizzes'];
		$midterms=(int)$_POST['midterms'];
		$hws=(int)$_POST['hws'];
		$final=(int)$_POST['final'];

		$total=$attendance+$quizzes+$midterms+$hws+$final;
		
		if($total!=100){
			$_SESSION['markDistributionFailed']="Total marks should be equivalent to <b>100</b>";
			redirect_to('../users/classroom.php?class_id='.$classId);
		}else{
			$query="INSERT INTO mark_dis(classId, attendance, quiz, midterm, hw, final) VALUES('{$classId}', '{$attendance}', '{$quizzes}', '{$midterms}', '{$hws}', '{$final}')";
			if(mysqli_query($connection, $query))
				$_SESSION['markDistributionSuccess']="Successfully marks distributed!";
			redirect_to('../users/classroom.php?class_id='.$classId);
		}
	}
?>

<?php
	if(isset($_POST['mark-distribution-update'])){
		$classId=$_POST['class-id'];
		$attendance=(int)$_POST['attendance'];
		$quizzes=(int)$_POST['quizzes'];
		$midterms=(int)$_POST['midterms'];
		$hws=(int)$_POST['hws'];
		$final=(int)$_POST['final'];

		$total=$attendance+$quizzes+$midterms+$hws+$final;
		
		if($total!=100){
			$_SESSION['markDistributionFailed']="Total marks should be equivalent to <b>100</b>";
			redirect_to('../users/classroom.php?class_id='.$classId);
		}else{
			$query="UPDATE mark_dis SET classId='{$classId}', attendance='{$attendance}', quiz='{$quizzes}', midterm='{$midterms}', hw='{$hws}', final='{$final}' WHERE classId='{$classId}'";
			if(mysqli_query($connection, $query))
				$_SESSION['markDistributionSuccess']="Successfully marks distribution updated!";
			redirect_to('../users/classroom.php?class_id='.$classId);
		}
	}
?>

<!-- ---------------------------- Quiz mark submission ------------------------- -->
<?php
	if(isset($_POST['quiz-marks'])){
		$totalMark=(int)$_POST['totalMark'];
		$examType=$_POST['examType'];
		$classId=(int)$_POST['classId'];
		$userArr=$_POST['user'];

		$tempArr=[];
    	$queryC="SELECT exam_marks.exam FROM exam_marks INNER JOIN enrollments ON exam_marks.enrollmentId=enrollments.id AND enrollments.classId='{$classId}' WHERE type='quiz'";
		$resC=mysqli_query($connection, $queryC);
		while($rowC=mysqli_fetch_array($resC))
			array_push($tempArr, $rowC['exam']);
		$count=sizeof((array_unique($tempArr)))+1;
		$exam=$examType.$count;

		foreach($userArr as $key => $user){
			$enrollmentId=(int)$key;
			$quizMarks=(int)$user;

			$query2="INSERT INTO exam_marks(type, exam, total_mark, mark, enrollmentId) VALUES('{$examType}', '{$exam}', '{$totalMark}', '{$quizMarks}', '{$enrollmentId}')";
			mysqli_query($connection, $query2);
		}
		$_SESSION['quizMarksAdded']="Quiz marks successfully added!";
		redirect_to('../users/classroom.php?class_id='.$classId);
	}
?>


<!-- ---------------------- Add attendance --------------------- -->
<?php
	if(isset($_POST['add-attendance'])){
		$totalMark=(int)$_POST['attendanceMark'];
		$examType=$_POST['examType'];
		$classId=(int)$_POST['classId'];
		$exam='attendance';
		$userArr=$_POST['user'];

		foreach($userArr as $key=>$user){
			$enrollmentId=(int)$key;
			$atdcMark=(int)$user;

			$query="INSERT INTO exam_marks(type, exam, total_mark, mark, enrollmentId) VALUES('{$examType}', '{$exam}', '{$totalMark}', '{$atdcMark}', '{$enrollmentId}')";
			mysqli_query($connection, $query);
		}
		$_SESSION['atdcMarksAdded']="Attendance marks successfully added!";
		redirect_to('../users/classroom.php?class_id='.$classId);
	}
?>


<!-- ---------------------------- Midterm mark submission ------------------------- -->
<?php
	if(isset($_POST['midterm-marks'])){
		$totalMark=(int)$_POST['totalMark'];
		$examType=$_POST['examType'];
		$classId=(int)$_POST['classId'];
		$userArr=$_POST['user'];

		$tempArr=[];
    	$queryC="SELECT exam_marks.exam FROM exam_marks INNER JOIN enrollments ON exam_marks.enrollmentId=enrollments.id AND enrollments.classId='{$classId}' WHERE type='midterm'";
		$resC=mysqli_query($connection, $queryC);
		while($rowC=mysqli_fetch_array($resC))
			array_push($tempArr, $rowC['exam']);
		$count=sizeof((array_unique($tempArr)))+1;
		$exam=$examType.$count;

		foreach($userArr as $key => $user){
			$enrollmentId=(int)$key;
			$midtermMarks=(int)$user;

			$query2="INSERT INTO exam_marks(type, exam, total_mark, mark, enrollmentId) VALUES('{$examType}', '{$exam}', '{$totalMark}', '{$midtermMarks}', '{$enrollmentId}')";
			mysqli_query($connection, $query2);
		}
		$_SESSION['midtermMarksAdded']="Midterm marks successfully added!";
		redirect_to('../users/classroom.php?class_id='.$classId);
	}
?>

<!-- ---------------------------- HW mark submission ------------------------- -->
<?php
	if(isset($_POST['hw-marks'])){
		$totalMark=(int)$_POST['totalMark'];
		$examType=$_POST['examType'];
		$classId=(int)$_POST['classId'];
		$userArr=$_POST['user'];

		$tempArr=[];
    	$queryC="SELECT exam_marks.exam FROM exam_marks INNER JOIN enrollments ON exam_marks.enrollmentId=enrollments.id AND enrollments.classId='{$classId}' WHERE type='hw'";
		$resC=mysqli_query($connection, $queryC);
		while($rowC=mysqli_fetch_array($resC))
			array_push($tempArr, $rowC['exam']);
		$count=sizeof((array_unique($tempArr)))+1;
		$exam=$examType.$count;

		foreach($userArr as $key => $user){
			$enrollmentId=(int)$key;
			$hwMarks=(int)$user;

			$query2="INSERT INTO exam_marks(type, exam, total_mark, mark, enrollmentId) VALUES('{$examType}', '{$exam}', '{$totalMark}', '{$hwMarks}', '{$enrollmentId}')";
			mysqli_query($connection, $query2);
		}
		$_SESSION['hwMarksAdded']="HW marks successfully added!";
		redirect_to('../users/classroom.php?class_id='.$classId);
	}
?>

<!-- ---------------------- Final mark submission --------------------- -->
<?php
	if(isset($_POST['add-final'])){
		$totalMark=(int)$_POST['totalMark'];
		$examType=$_POST['examType'];
		$classId=(int)$_POST['classId'];
		$exam='final';
		$userArr=$_POST['user'];

		foreach($userArr as $key=>$user){
			$enrollmentId=(int)$key;
			$finalMark=(int)$user;

			$query="INSERT INTO exam_marks(type, exam, total_mark, mark, enrollmentId) VALUES('{$examType}', '{$exam}', '{$totalMark}', '{$finalMark}', '{$enrollmentId}')";
			mysqli_query($connection, $query);
		}
		$_SESSION['finalMarksAdded']="Attendance marks successfully added!";
		redirect_to('../users/classroom.php?class_id='.$classId);
	}
?>

<?php include('../db/close.php'); ?>