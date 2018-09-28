<?php
require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../functions.php';
$current_user = lms_get_current_user();
$name = $current_user['name'];
$user_role = lms_get_user_role();
if ($user_role !== 'teacher') {
	echo 'Unauthorized access.';
	exit;
}

$courses = lms_fetch_all("select * from course,teacher where course.ctno=teacher.tno and teacher.name='$name'");
?>

<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html"; charset="gb2312">
		<meta charset="utf-8">
		<title>Learning Management System</title>
		<link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap-datepicker.css">
		<link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
		<link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
		<link rel="stylesheet" href="/static/assets/css/user.css">
		<script src="/static/assets/vendors/jquery/jquery.js"></script>
		<script src="/static/assets/vendors/moment/moment.js"></script>
   		<script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
		<script src="/static/assets/vendors/bootstrap/js/bootstrap-datetimepicker.js"></script>
		<script src="/static/assets/vendors/nprogress/nprogress.js"></script>
	    <script src="/static/assets/vendors/chart/Chart.js"></script>
	</head>
	<body>
	    <script>NProgress.start()</script>
		<div class="main">
		    <?php include '../inc/navbar.php'?>
        	<?php include '../inc/sidebar.php'?>
			<form action="" method="post" enctype="multipart/form-data">
			<?php
			$sql = "SELECT cname, student.name as sname, shhname, shsubmit, shsubdate, htimeend FROM course 
			INNER JOIN sc ON sc.sccno = course.cno
			INNER JOIN student ON student.sno = sc.scsno
			INNER JOIN homework ON homework.hcno = course.cno
			INNER JOIN sh ON sh.shcno = course.cno";
			$submissions = lms_fetch_all($sql);
			
			if (count($submissions) < 1) {
				echo '<h5 class="text-center">No submission yet.</h5><br><br>';
			} else {
			?>
			<h5 class="text-center">Summary of Assignment Submissions</h5>
			<table class="table">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Course Name</th>
					<th scope="col">Student Name</th>
					<th scope="col">Assignment</th>
					<th scope="col">Submission Path</th>
					<th scope="col">Last Submitted</th>
					<th scope="col">Deadline</th>
				</tr>
			</thead>
			<?php
				for ($i = 0; $i < count($submissions); $i++) {
					echo "<tr>";
					echo "<td><center>";
					echo $submissions[$i]["cname"];
					echo "</center></td>";
					echo "<td><center>";
					echo $submissions[$i]["sname"];
					echo "</center></td>";
					echo "<td><center>";
					echo $submissions[$i]["shhname"];
					echo "</center></td>";
					echo "<td><center>";
					echo $submissions[$i]["shsubmit"];
					echo "</center></td>";
					echo "<td><center>";
					echo $submissions[$i]["shsubdate"];
					echo "</center></td>";
					echo "<td><center>";
					echo $submissions[$i]["htimeend"];
					echo "</center></td>";
					echo "</tr>";
				}
			    echo "</table><br><br>";
		    }
			echo "<h5 class=\"text-center\">Summary of Student Submissions</h5>";
			echo "<center><select name='select0' style=\"font-size:20px;\">";
			echo " <option>--Please select a course--</option>";
			for ($i = 0; $i < count($courses); $i++) {
				$cname = $courses[$i]["cname"];
				echo "<option value='$cname'>$cname</option>";
			}
			echo "</select>&nbsp&nbsp<input id='submit' value='OK' name='submit' type='submit' style=\"height:30px;width:60px;\" style='font-size:20px'></center><br>";
		
			if (isset($_POST['submit'])) {
				$cname = $_POST['select0'];
				$cno = lms_fetch_one("select * from course where cname='$cname'");
				$cno1 = $cno['cno'];
				$stusubs = lms_fetch_all("select * from allupload,student where allupload.shcno='$cno1'and allupload.shsno=student.sno");
				$count = lms_fetch_one("select count(*) from homework where hcno='$cno1'");
				$count1 = $count['count(*)'];
				$q4 = lms_fetch_all("select * from student where sno in(select distinct sno from teacher,course,student,sc where student.sno=sc.scsno and teacher.tno=course.ctno and course.cno=sc.sccno and teacher.name='$name' and course.cno='$cno1')and sno not in(select shsno from allupload where shcno='$cno1')");
			?>
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Course Name</th>
						<th scope="col">Student Name</th>
						<th scope="col">Total Assignments</th>
						<th scope="col">Submissions</th>
						<th scope="col">To be Submitted</th>
					</tr>
				</thead>
				<?php
				for ($i = 0; $i < count($stusubs); $i++) {
					echo "<tr>";
					echo "<td><center>";
					echo $cname;
					echo "</center></td>";
					echo "<td><center>";
					echo $stusubs["sname"];
					echo "</center></td>";
					echo "<td><center>";
					echo $count1;
					echo "</center></td>";
					echo "<td><center>";
					echo $stusubs["count(*)"];
					echo "</center></td>";
					echo "<td><center>";
					echo $count1 - $stusubs["count(*)"];
					echo "</center></td>";
					echo "</tr>";
				}
			
			    echo "</table><br><br>";
			
			    if (count($q4) < 1) {
					echo "<h5 class='text-center'>All students have at least one submitted assignment for course " . $cname . ".</h5>";
				} else {
					echo "<h5 class='text-center'>Students with no submission record for course " . $cname . ".</h5>";
				?>
				<table class="table">
					<thead class="thead-dark">
						<tr>
						    <th scope="col">Student Number</th>
							<th scope="col">Student Name</th>
							<th scope="col">Sex</th>
							<th scope="col">Major</th>
						</tr>
					</thead>
					<?php
					for ($i = 0; $i < count($q4); $i++) {
						echo "<tr>";
						echo "<td>";
						echo $q4[$i]["sno"];
						echo "</td>";
						echo "<td>";
						echo $q4[$i]["name"];
						echo "</td>";
						echo "<td>";
						echo $q4[$i]["sex"];
						echo "</td>";
						echo "<td>";
						echo $q4[$i]["major"];
						echo "</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
			}
			?>
		</div>
	    <script>NProgress.done()</script>
    </body>
</html>