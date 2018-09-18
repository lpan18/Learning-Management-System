<?php
session_start();
if (isset($_SESSION['STUDEN']) == TRUE) {
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
		<h1><b><font size='6'>我的课程</font></b></h1>
		<div id="inner">

<?php
require_once '../../config.php';

	$names = $_SESSION['STUDEN'];
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$sql = "select course.cno,course.cname,teacher.tname,ifmanager from course,teacher,sc,student where student.sno=sc.scsno and sc.sccno=course.cno and course.ctno=teacher.tno and student.sname='$names'";
	$results = mysqli_query($link, $sql);
	$rows = mysqli_num_rows($results);
	if ($rows < 1) {
		echo '<p align="center">我的课程为空</p>';
	} else {

		?>
<table border='1' space="0" align='center' width=700  Cellpadding=0 Cellspacing=0 BORDERCOLOR="pink">

<tr align="center" height=35>
<th>
课程编号
</th>
<th>
课程名称
</th>
<th>
任课老师
</th>
<th>
课程管理员<br>（y为是，n为否）
</th>
</tr>


<?php
while ($row = mysqli_fetch_assoc($results)) {
			echo "<tr height=35>";
			echo "<td>";
			echo $row["cno"];
			echo "</td>";
			echo "<td>";
			echo $row["cname"];
			echo "</td>";
			echo "<td>";
			echo $row["tname"];
			echo "</td>";
			echo "<td>";
			echo $row["ifmanager"];
			echo "</td>";
			echo "<tr>";
		}
		echo "</table>";
	}
	?>
		</div>
		<div style="height:5px;background-color:pink;line-height:0;">&nbsp;</div>
	</div>

</body>
</html>

<?php
} else {
	echo "对不起，您无权限查看此页面！";
}

?>
