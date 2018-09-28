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
		<link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
		<link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
		<link rel="stylesheet" href="/static/assets/css/user.css">
		<script src="/static/assets/vendors/jquery/jquery.js"></script>
   		<script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
		<script src="/static/assets/vendors/nprogress/nprogress.js"></script>
	    <script src="/static/assets/vendors/chart/Chart.js"></script>
	</head>

	<body>
		<script>NProgress.start()</script>
		<div class="main">
			<?php include '../inc/navbar.php'?>
        	<?php include '../inc/sidebar.php'?>
			<h2 class="text-center">My Courses</h2><br><br>
			<?php
				if (count($courses) < 1) {
					echo '<h5 class="text-center">No course found</h5>';
				} else {
			?>

			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Course No</th>
						<th scope="col">Course Name</th>
						<th scope="col">Teacher Name</th>
					</tr>
				</thead>
				<?php
				for ($i = 0; $i < count($courses); $i++) {
					$course = $courses[$i];
					echo "<tr>";
					echo "<td>";
					echo $course["cno"];
					echo "</td>";
					echo "<td>";
					echo $course["cname"];
					echo "</td>";
					echo "<td>";
					echo $course["name"];
					echo "</td>";
					echo "<tr>";
				}
				echo "</table>";
				}
				?>
		</div>
		<script>NProgress.done()</script>
	</body>
</html>