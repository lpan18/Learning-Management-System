<?php
session_start();
if (isset($_SESSION['ADMIN']) == TRUE) {
	?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
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
	width:800px;
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
#inner{
	background-color:#F7F6F4;
	margin-top:14px;
	padding-bottom:15px;
	}
h2{
	padding:15px 0 15px 40px;
	font-size:18px;
  	}
.content{
	border:2px dashed #C6C6C6;
	background-color:#fff;
	width:480px;
	margin:0 auto 10px auto;
	}
.content ul{
	margin:10px 0 10px 30px;
	list-style:none;
	}
.content ul li{
	font-size:18px;
	line-height:1.5;
	}

a:link {
	text-decoration: none;
	color:#8793DF;
}
a:visited {
	text-decoration: none;
	color:purple;
}
a:hover {
	text-decoration:underline;
	color:#8793DF;
}
a:active {
	text-decoration: none;
}
-->
</style></head>

<body>
	<div id="container">
		<h1><b><font size='6'>管理的班级</font></b></h1>
<form id="form1" name="form1" method="post" action="myclass.php" >
<select name="select" style="font-size:20px;">
<?php
require_once '../../config.php';

	$names = $_SESSION['ADMIN'];
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$sql = "select course.cname from course,sc,student where course.cno=sc.sccno and student.sno=sc.scsno and  student.sname='$names' and ifmanager='y'";
	$results = mysqli_query($link, $sql);

	while ($row = mysqli_fetch_object($results)) {
		echo "<option value='$row->cname'>$row->cname</option>";
	}
	?>
echo "<option value='1'>查看全部</option>";
</select>

<input id="submit" value="查看" name=submit type=submit style="height:35px;width:90px;" style="font-size:20px;"><br>



<?php
if (isset($_POST['select'])) {
		$course = $_POST['select'];
		$names = $_SESSION['ADMIN'];
		$link1 = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
		if (!$link1) {
			die('Not connected : ' . mysqli_error());
		}
		mysqli_select_db($link1, LMS_DB_NAME);

		?>
</form>


<div id="inner">
<table border='1' space="0" align='center' width=800  Cellpadding=0 Cellspacing=0 BORDERCOLOR="pink">

<tr align="center" height=35>
<th>
课程名称
</th>
<th>
学号
</th>
<th>
姓名
</th>
<th>
性别
</th>
<th>
专业
</th>
</tr>

<?php

		if ($course == "1") {
			$sql1 = "select course.cname,student.sno,student.sname,ssex,smajor from course,sc,student where student.sno=sc.scsno and sc.sccno=course.cno and  ifmanager='n'  and sccno in (select sccno from scanmanager_teacher where sname='$names')";
		} else {
			$sql1 = "select course.cname,student.sno,student.sname,ssex,smajor from course,sc,student where student.sno=sc.scsno and sc.sccno=course.cno and course.cname='$course' and ifmanager='n'";
		}
		$resultss = mysqli_query($link1, $sql1);

		while ($row1 = mysqli_fetch_assoc($resultss)) {
			echo "<tr height=35>";
			echo "<td>";
			echo $row1["cname"];
			echo "</td>";
			echo "<td>";
			echo $row1["sno"];
			echo "</td>";
			echo "<td>";
			echo $row1["sname"];
			echo "</td>";
			echo "<td>";
			echo $row1["ssex"];
			echo "</td>";
			echo "<td>";
			echo $row1["smajor"];
			echo "</td>";
			echo "</tr>";
		}

		echo "</table>";

		?>


		</div>
		<div style="height:5px;background-color:pink;line-height:0;">&nbsp;</div>
	</div>

</body>
</html>



<?php
}
} else {
	echo "对不起，您无权限查看此页面！";
}

?>
