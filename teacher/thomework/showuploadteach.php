<?php
require_once '../../config.php';
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title> 查看已提交作业 </title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
<?php
$tname = $_SESSION['TEACH'];
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$sql = "select * from showsh_teach where tname='$tname'";
	$results = mysqli_query($link, $sql);
	$sql0 = "select course.cname from course,teacher where teacher.tno=course.ctno and teacher.tname='$tname'";
	$result0 = mysqli_query($link, $sql0);
	$rows = mysqli_num_rows($results);
	if ($rows < 1) {
		echo '<p align="center"><b>未有学生提交任何作业</b></p>';
	} else {
		?>
<br><p align="center"><b><font size="6">您的学生已提交以下作业：</font></b></p>
<table border='1' space="1" align='center' width=1100  Cellpadding=10>
<tr bgcolor="pink" align="center">
<th>
课程名称
</th>
<th>
学生姓名
</th>
<th>
作业名称
</th>
<th>
网络提交路径
</th>
<th>
最近一次提交时间
</th>
<th>
截止时间
</th>
</tr>
<?php
while ($row = mysqli_fetch_assoc($results)) {
			echo "<tr>";
			echo "<td><center>";
			echo $row["cname"];
			echo "</center></td>";
			echo "<td><center>";
			echo $row["sname"];
			echo "</center></td>";
			echo "<td><center>";
			echo $row["shhname"];
			echo "</center></td>";
			echo "<td><center>";
			echo $row["shsubmit"];
			echo "</center></td>";
			echo "<td><center>";
			echo $row["shsubdate"];
			echo "</center></td>";
			echo "<td><center>";
			echo $row["htimeend"];
			echo "</center></td>";
			echo "</tr>";
		}
	}
	echo "</table><br><br><br><br>";
	echo "<b><center><font size=\"6\">学生提交情况汇总</font></b><br><br>";
	echo "<select name='select0' style=\"font-size:20px;\">";
	echo " <option>--请选择查看的课程--</option>";
	while ($row0 = mysqli_fetch_object($result0)) {
		echo "<option value='$row0->cname'>$row0->cname</option>";
	}
	echo "</select>&nbsp&nbsp&nbsp<input id='submit' value='查看' name='submit' type='submit' style=\"height:30px;width:60px;\"  style='font-size:20px'></center><br>";

	if (isset($_POST['submit'])) {
		$cname = $_POST['select0'];
		$q1 = mysqli_query($link, "select * from course where cname='$cname'");
		$cno = mysqli_fetch_assoc($q1);
		$cno1 = $cno['cno'];
		$q2 = mysqli_query($link, "select * from allupload,student where allupload.shcno='$cno1'and allupload.shsno=student.sno");
		$q3 = mysqli_query($link, "select count(*) from homework where hcno='$cno1'");
		$count = mysqli_fetch_assoc($q3);
		$count1 = $count['count(*)'];
		$q4 = mysqli_query($link, "select student.sname from student where sno in(select distinct sno from teacher,course,student,sc where student.sno=sc.scsno and teacher.tno=course.ctno and course.cno=sc.sccno and teacher.tname='$tname' and course.cno='$cno1')and sno not in(select shsno from allupload where shcno='$cno1')");
		?>
<table border='1' space="1" align='center' width=600  Cellpadding=10>
<tr bgcolor="pink" align="center">
<th>
课程名称
</th>
<th>
学生姓名
</th>
<th>
布置作业数
</th>
<th>
已提交作业数
</th>
<th>
缺交作业数
</th>
</tr>
<?php
while ($row = mysqli_fetch_assoc($q2)) {
			echo "<tr>";
			echo "<td><center>";
			echo $cname;
			echo "</center></td>";
			echo "<td><center>";
			echo $row["sname"];
			echo "</center></td>";
			echo "<td><center>";
			echo $count1;
			echo "</center></td>";
			echo "<td><center>";
			echo $row["count(*)"];
			echo "</center></td>";
			echo "<td><center>";
			echo $count1 - $row["count(*)"];
			echo "</center></td>";
			echo "</tr>";
		}
		echo "</table><br><br>";
		$row4 = mysqli_num_rows($q4);
		if ($row4 < 1) {
			echo "<b><center><font size=\"6\">不存在从未提交" . $cname . "课程作业的学生</font></b><br><br>";
		} else {
			echo "<br><br><br><b><center><font size=\"6\">从未提交" . $cname . "课程作业的学生</font></b><br><br>";
			?>
<table border='1' space="1" align='center' width=200  Cellpadding=10>
<tr bgcolor="pink" align="center">
<th>
学生姓名
</th>
</tr>
<?php
while ($row = mysqli_fetch_assoc($q4)) {
				echo "<tr>";
				echo "<td><center>";
				echo $row["sname"];
				echo "</center></td>";
				echo "</tr>";
			}
			echo "</table>";
		}
	}
	?>
</body>
</html>
<?php
} else {
	echo "对不起，您无权限查看此页面！";
}

?>