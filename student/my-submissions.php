<?php
require_once dirname(__FILE__) . '/../config.php';
require_once dirname(__FILE__) . '/../functions.php';
$current_user = lms_get_current_user();
$name = $current_user['name'];
$user_role = lms_get_user_role();
if ($user_role !== 'student') {
	echo 'Unauthorized access.';
	exit;
}

$courses = lms_fetch_all("select course.cno, course.cname, teacher.name from course, teacher, sc, student where student.sno=sc.scsno and sc.sccno=course.cno and course.ctno=teacher.tno and student.name='$name'");
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
			<h2 class="text-center">My Submissions</h2><br><br>
			<?php
				$submissions = lms_fetch_all("select * from showsh_stude where sname='$name' order by shsubdate desc");
				if (count($submissions) < 1) {
					echo '<p align="center"><font size=6>You have not submitted any assignment.</font></p>';
				} else {
			?>

			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Course Name</th>
						<th scope="col">Teacher Name</th>
						<th scope="col">Assignment Name</th>
						<th scope="col">Last Submission</th>
						<th scope="col">Deadline</th>
						<th scope="col">Score</th>
						<th scope="col">Remark</th>
					</tr>
				</thead>
				<?php
				for ($i = 0; $i < count($submissions); $i++) {
					$submission = $submissions[$i];
					echo "<tr>";
					echo "<td><center>";
					echo $submission["cname"];
					echo "</center></td>";
					echo "<td><center>";
					echo $submission["tname"];
					echo "</center></td>";
					echo "<td><center>";
					echo $submission["shhname"];
					echo "</center></td>";
					echo "<td><center>";
					echo $submission["shsubdate"];
					echo "</center></td>";
					echo "<td><center>";
					echo $submission["htimeend"];
					echo "</center></td>";
		
					echo "<td><center>";
					$aaa = $submission[shscore];
					if ($aaa) {
						echo $aaa;
					} else {
						echo "Not marked";
					}
					echo "</center></td>";
		
					echo "<td><center>";
					$bbb = $row[shremark];
					if ($bbb) {
						echo $bbb;
					} else {
						echo "Not marked";
					}
					echo "</center></td>";
		
					echo "</tr>";
				}
			}
			echo "</table>";
			?>
		</div>
    	<script>NProgress.done()</script>
	</body>
</html>