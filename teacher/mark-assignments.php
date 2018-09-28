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
			<h2 class="text-center">Mark Assignments</h2><br><br>
			<form name="form1" class="form-inline justify-content-center" action="mark-assignments.php" method="post">
				<?php
					$sql1 = "select distinct cno, cname from course, homework, teacher where homework.hcno=course.cno and course.ctno=teacher.tno and homework.htno=teacher.tno and teacher.name='$name'";
					$courses = lms_fetch_all($sql1);
				?>
				<select name="sell" onchange="return changeit()" style="font-size:20px;">
					<?php
						echo " <option value=\"abcdefg\">--Please select a course--</option>";
						for ($i = 0; $i < count($courses); $i++) {
							$cname = $courses[$i]["cname"];
							echo "<option value='$cname'>$cname</option>";
						}
					?>
				</select>
				&nbsp&nbsp&nbsp&nbsp
				<select name="zhangjie_name" style="font-size:20px;">
					<?php
						echo " <option value=\"abcdefg\">--Please select a chapter--</option>";
					?>
			    </select>
				<label>
					&nbsp;&nbsp;&nbsp;
					<input type="submit" name="submit" value="OK" style="height:35px;width:80px;" style="font-size:20;">
				</label>
			</form>
			
			<?php
				$sql = "select * from course,teacher where name='$name' and course.ctno=teacher.tno";
				$courses = lms_fetch_all($sql);
				for ($i = 0; $i < count($courses); $i++) {
					$course_nos[$i] = $courses[$i]['cno'];

					$sql = "select hname from homework,course where homework.hcno=course.cno and homework.hcno='" . $course_nos[$i] . "'";
					$course_no_names = lms_fetch_all($sql);

					for ($j = 0; $j < count($course_no_names); $j++) {
						$course_no_name[$i][$j] = $course_no_names[$j]['hname'];
					}
				}
				
				echo "<script language=\"javascript\"> ";
				echo "var map_array = new Array();";

				for ($i = 0; $i < count($courses); $i++) {
					$tmp = "";
					$j = 0;
					$tmp = "map_array[\"" . $course_nos[$i] . "\"] = new Array(";
					
					while ($j < count($course_no_name[$i])) {
						$tmp = $tmp . "\"" . $course_no_name[$i][$j] . "\"";
						if ($j < count($course_no_name[$i]) - 1) {
							$tmp = $tmp . ",";
						}
						
						$j++;
					}
					
					$tmp = $tmp . ");";
					echo $tmp;
				}
				
				$sql2 = "select hname from homework,teacher where homework.htno=teacher.tno and teacher.name='$name' order by hname";
				$homeworks = lms_fetch_all($sql2);

				for ($i = 0; $i < count($homeworks); $i++) {
					$zhangjie_names[$w] = $homeworks[$i]['hwname'];
				}
				
				$ttmp = "map_name_array = new Array(";
				for ($pp = 0; $pp < count($homeworks); $pp++) {
					$ttmp = $ttmp . "\"" . $row->hname . "\"";
					if ($pp < count($homeworks) - 1) {
						$ttmp = $ttmp . ",";
					}
				}
				
				$ttmp = $ttmp . ");";
				echo $ttmp;
				echo "</script>";
				echo "<br>";
			?>
			
			<script language="javascript">
			function changeit()
			{
				var id = document.form1.sell.value;
				document.form1.zhangjie_name.options.length = 0;
				var y=document.createElement('option');
				y.text= "--Please select a chapter--";
				y.value = "abcdefg";
				document.form1.zhangjie_name.options.add(y);
				var i = 0;
				
				if(id == "abcdefg") {
					for(i = 0;i< map_name_array.length;i++) {
						var y=document.createElement('option');
						y.text= map_name_array[i];
						y.value = map_name_array[i];
						document.form1.zhangjie_name.options.add(y);
					}
					document.form1.zhangjie_name.selectedIndex = 0;
					return;
				}
				
				for(i = 0;i< map_array[id].length;i++) {
					var y=document.createElement('option');
					y.text= map_array[id][i];
					y.value = map_array[id][i];
					document.form1.zhangjie_name.options.add(y);
				}
				document.form1.zhangjie_name.selectedIndex = 0;
			}
			</script>
			
			<h5 class="text-center">Note: Select a course first, then select a chapter. In case there is no option, please post an assignment first.</h5>
			<br>
			<br>
			<?php
			
			if (isset($_POST['submit'])) {
				$cno = $_POST['sell'];
				$hname = $_POST['zhangjie_name'];
				$sql2 = "select * from student,homework,sh where student.sno=sh.shsno and sh.shhid=homework.hid and hname='$hname' and hcno='$cno' order by sno";
				$result2 = lms_fetch_all($sql2);
				
				if (count($result2) < 1) {
					echo '<h5 class="text-center">No submission found for course ' . $cno . ' chapter ' . substr($hname, 0, 3) . '</h5>';
				} else {
					echo '<h5 class="text-center">The followings are submissions for course ' . $cno . ' chapter ' . substr($hname, 0, 3) . '</h5>';
			?>

			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Student No</th>
						<th scope="col">Student Name</th>
						<th scope="col">Submitted at</th>
						<th scope="col">Submission</th>
						<th scope="col">Score</th>
						<th scope="col">Note</th>
					</tr>
				</thead>
				
				<?php
				for ($i = 0; $i < count($result2); $i++) {
					$row = $results[$i];

					echo "<tr>";
					echo "<td><center>";
					echo $row["shsno"];
					echo "</center></td>";
					echo "<td><center>";
					echo $row["sname"];
					echo "</center></td>";
					echo "<td><center>";
					echo $row["shsubdate"];
					echo "</center></td>";
					echo "<td><center>";
	
					echo "<a  style=\"text-decoration:none; color:#0000FF\"  href=pingfen.php?sno=" . $row["shsno"] . "&cno=" . $cno . "&hname=" . $hname . "&type='reset' target=_blank>查看</a>";
					echo "</center></td>";
	
					echo "<td><center>";
					$aaa = $row[shscore];
	
					if ($aaa) {
						echo $aaa;
					} else {
						echo "Not marked";
					}
	
					echo "</center></td>";
					echo "<td width='250'><center>";
	
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

		}
		?>
		</div>
	    <script>NProgress.done()</script>
    </body>
</html>
