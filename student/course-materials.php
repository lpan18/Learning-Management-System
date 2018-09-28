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
			<h2 class="text-center">Course Materials</h2><br><br>
			<form action="" method="post" enctype="multipart/form-data">
				<?php
					$keys = lms_fetch_all("select * from showanswer_stude where sname='$name' order by cname, asname");
					if (count($keys) < 1) {
				?>
				<script language="javascript">
					alert("There is no course material available.");
				</script>
				<?php
					} else {
				?>
				<table class="table">
					<thead class="thead-dark">
						<tr>
							<th scope="col">Course Name</th>
							<th scope="col">Teacher Name</th>
							<th scope="col">File Name</th>
							<th scope="col">Download</th>
						</tr>
					</thead>
					<?php
						for ($i = 0; $i < count($keys); $i++) {
							$key = $keys[$i];
							echo "<tr>";
							echo "<td>";
							echo $key["cname"];
							echo "</td>";
							echo "<td>";
							echo $key["tname"];
							echo "</td>";
							echo "<td>";
							echo $key["asname"];
							echo "</td>";
							echo "<td>";
							echo "<a href=downloadans.php?cname=" . $key["cname"] . "&asname=" . $key["asname"] . "&ascontent=" . $key["ascontent"] . "&type=download onclick=\"return confirm('确定下载该答案吗？')\">Download</a>";
							echo "</td>";
							echo "</tr>";
						}
					}
					echo "</table>";
					?>
			</form>
		</div>
    	<script>NProgress.done()</script>
	</body>
</html>