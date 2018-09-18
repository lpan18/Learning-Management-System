<?php
require_once '../../config.php';
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">

<style type="text/css">
<!--
@import url(student/css/public.css);
body {
	margin-left: 10px;
	margin-top: 5px;
	background-color:white;
}
*{
	padding:0;
	margin:0;
	}
#container{
	width:700px;
	margin:6px auto 0 auto;
	background-color:#fff;
	border:1px dashed #C6C6C6;
	padding:7px;
	}
h1{
	color:black;
	font-size:24px;
	text-align:center;
	background-color:pink;
	height:50px;
	line-height:50px;
	}



-->
</style>

<title> 查看某学生已提交作业 </title>
</head>
<body>
<center>
<div id="container">
		<h1><font size='6'>个别学生作业上交详情</font></h1>
	<div style="height:5px;background-color:pink;line-height:0;">&nbsp;</div>
	</div><br>
</center>
<form action="" method="post" enctype="multipart/form-data">
<center>
<?php
$tname = $_SESSION['TEACH'];
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$sql0 = "select course.cname from course,teacher where teacher.tno=course.ctno and teacher.tname='$tname'";
	$result0 = mysqli_query($link, $sql0);
	$sql1 = "select distinct sname from teacher,course,student,sc where student.sno=sc.scsno and teacher.tno=course.ctno and course.cno=sc.sccno and teacher.tname='$tname'";
	$result1 = mysqli_query($link, $sql1);
	?>

<select name="select0" style="font-size:25px;">
<?php
echo " <option>--请选择查看的课程--</option>";
	while ($row0 = mysqli_fetch_object($result0)) {
		echo "<option value='$row0->cname'>$row0->cname</option>";
	}
	?>
</select>

&nbsp&nbsp&nbsp&nbsp
<select name="select1" style="font-size:25px;">
<?php
echo " <option>--请选择查看的学生--</option>";
	while ($row1 = mysqli_fetch_object($result1)) {
		echo "<option value='$row1->sname'>$row1->sname</option>";
	}
	?>
</select>

&nbsp&nbsp&nbsp&nbsp
<input id="submit" value="查看" name="submit" type="submit" style="height:38px;width:80px;"  style='font-size:25px'>
</center>
<br><br>

<?php
if (isset($_POST['submit'])) {
		$cname = $_POST['select0'];
		$sname = $_POST['select1'];
		$q1 = mysqli_query($link, "select * from student where sname='$sname'");
		$q2 = mysqli_query($link, "select * from course where cname='$cname'");
		$sno = mysqli_fetch_assoc($q1);
		$cno = mysqli_fetch_assoc($q2);
		$sno1 = $sno['sno'];
		$cno1 = $cno['cno'];
		$sql1 = "select subdatev.subname,count(*) from subdatev,showsh_teach where subdatev.subsname=showsh_teach.sname and subdatev.subsname='$sname' and subdatev.cname=showsh_teach.cname and subdatev.cname='$cname' and subdatev.subname=showsh_teach.shhname group by subdatev.subname";
		$result1 = mysqli_query($link, $sql1);
		$row1 = mysqli_num_rows($result1);
		$sql2 = "select * from subdatev,showsh_teach where subdatev.subsname=showsh_teach.sname and subdatev.subsname='$sname' and subdatev.cname=showsh_teach.cname and subdatev.cname='$cname' and subdatev.subname=showsh_teach.shhname order by subdatev.subname";
		$result2 = mysqli_query($link, $sql2);
		$row2 = mysqli_num_rows($result2);
		$sql3 = "select * from homework left join sh on homework.hcno=sh.shcno and mid(homework.hname,1,3)=mid(sh.shhname,1,3) and shsno='$sno1'where hcno='$cno1' and shhname is null";
		$result3 = mysqli_query($link, $sql3);
		$row3 = mysqli_num_rows($result3);
		if ($row1 < 1) {
			echo '<p align="center"><font size=5><b>学生' . $sname . '未提交任何' . $cname . '课作业</b></font></p>';
		} else {
			echo '<p align="center"><b><font size="5">学生' . $sname . $cname . '课已提交作业汇总：</font></b></p>';
			?>
<table border='1' space="1" align='center' width=400  Cellpadding=10>
<tr bgcolor="pink" align="center" height=50>
<th>
作业名称
</th>
<th>
提交次数
</th>
</tr>
<?php
while ($row1 = mysqli_fetch_assoc($result1)) {
				echo "<tr height=40>";
				echo "<td><center>";
				echo $row1["subname"];
				echo "</center></td>";
				echo "<td><center>";
				echo $row1["count(*)"];
				echo "</center></td>";
				echo "</tr>";
			}
			echo "</table><br><br>";
			echo '<p align="center"><b><font size="5">以上作业的每次提交明细：</font></b></p>';
			?>
<table border='1' space="1" align='center' width=700  Cellpadding=10>
<tr bgcolor="pink" align="center" height=50>
<th>
作业名称
</th>
<th>
每次提交时间
</th>
<th>
截止时间
</th>
</tr>
<?php
while ($row2 = mysqli_fetch_assoc($result2)) {
				echo "<tr height=40>";
				echo "<td><center>";
				echo $row2["subname"];
				echo "</center></td>";
				echo "<td><center>";
				echo $row2["subdate"];
				echo "</center></td>";
				echo "<td><center>";
				echo $row2["htimeend"];
				echo "</center></td>";
				echo "</tr>";
			}
			echo "</table><br><br>";
			if ($row3 < 1) {
				echo '<p align="center"><b>学生' . $sname . '没有欠交作业</b></p>';
			} else {
				echo '<p align="center"><b><font size="5">学生' . $sname . $cname . '课欠交作业情况：</font></b></p>';
				?>
<table border='1' space="1" align='center' width=300  Cellpadding=10>
<tr bgcolor="pink" align="center" height=50>
<th>
欠交作业
</th>
<th>
截止时间
</th>
</tr>
<?php
while ($row3 = mysqli_fetch_assoc($result3)) {
					echo "<tr height=40>";
					echo "<td><center>";
					echo $row3["hname"];
					echo "</center></td>";
					echo "<td><center>";
					echo $row3["htimeend"];
					echo "</center></td>";
					echo "</tr>";
				}
				echo "</table>";
			}
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


