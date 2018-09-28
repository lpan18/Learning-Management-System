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
			<h2 class="text-center">My Assignments</h2><br><br>
			<form class="form-inline justify-content-center" action="" method="post" enctype="multipart/form-data">
				<select name="select1" style="font-size:20px;">
				<?php
					echo "<option>--Please select a course--</option>";
					for ($i = 0; $i < count($courses); $i++) {
						$cname = $courses[$i]["cname"];
						echo "<option value='$cname'>$cname</option>";
					}
				?>
				</select>
				&nbsp&nbsp&nbsp&nbsp&nbsp
				<input id="submit" value="OK" name="submit" type="submit" style="height:35px;width:80px;font-size:20;">
			</form>
			<?php
			if (isset($_POST['submit'])) {
				$cname = $_POST['select1'];
				$sql2 = "select course.cname, teacher.name as tname, homework.hname, homework.htimeend, homework.hcontent from course, teacher, sc, student, homework where student.sno=sc.scsno and sc.sccno=course.cno and course.ctno=teacher.tno and homework.hcno=course.cno and course.cname='$cname' and student.name='$name'";
				$homeworks = lms_fetch_all($sql2);
				
				if (count($homeworks) < 1) {
			?>
				<script language="javascript">
					alert ("The assignment has not been posted.");
				</script>
			<?php
				} else {
			?>

			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Course Name</th>
						<th scope="col">Teacher Name</th>
						<th scope="col">Assignment Name</th>
						<th scope="col">Deadline</th>
						<th scope="col">Download</th>
					</tr>
				</thead>
				<?php
					for ($i = 0; $i < count($homeworks); $i++) {
						$homework = $homeworks[$i];
						echo "<tr>";
						echo "<td>";
						echo $homework["cname"];
						echo "</center></td>";
						echo "<td>";
						echo $homework["tname"];
						echo "</center></td>";
						echo "<td>";
						echo $homework["hname"];
						echo "</center></td>";
						echo "<td>";
						echo $homework["htimeend"];
						echo "</center></td>";
						echo "<td>";
						echo "<a href=downloadhome.php?cname=" . $homework["cname"] . "&hname=" . $homework["hname"] . "&hcontent=" . $homework["hcontent"] . "&type=download onclick=\"return confirm('Do you want to download this assignment?')\">Download</a>";
						echo "</center></td>";
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