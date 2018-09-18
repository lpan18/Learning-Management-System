<?php
session_start();
if (isset($_SESSION['STUDEN']) == TRUE) {
	?>
<html>
<head>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title> 查看老师布置的作业 </title>
</head>
<body>

<form action="" method="post" enctype="multipart/form-data">
<br><p align="center"><b><font size="6">查看已布置作业<br><br></font></b></p>

<p align="center"><font size="5">
<select name="select1" style="font-size:25px;">
<?php
require_once '../../config.php';
	$sname = $_SESSION['STUDEN'];
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$sql1 = "select course.cname from course,student,sc where student.sno=sc.scsno and course.cno=sc.sccno and student.sname='$sname'";
	$result1 = mysqli_query($link, $sql1);
	echo " <option>--请选择查看的课程--</option>";
	while ($row1 = mysqli_fetch_object($result1)) {
		echo "<option value='$row1->cname'>$row1->cname</option>";
	}
	?>
</select>
&nbsp
<label>
  <select name="select2" style="font-size:25px;">
    <option>--查看第几章--</option>
    <option>1</option>
    <option>2</option>
    <option>3</option>
    <option>4</option>
    <option>5</option>
    <option>6</option>
    <option>7</option>
    <option>8</option>
    <option>9</option>
    <option>10</option>
  </select>
  </label>&nbsp&nbsp&nbsp&nbsp&nbsp
<input id="submit" value="查看" name="submit" type="submit" style="height:35px;width:130px;" style="font-size:20;">
</font></p>

<?php
if (isset($_POST['submit'])) {
		$cname = $_POST['select1'];
		$hhname = $_POST['select2'];
		$str = $hhname . '-' . '%.pdf';
		$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
		if (!$link) {
			die('Not connected : ' . mysqli_error());
		}
		mysqli_select_db($link, LMS_DB_NAME);
		$sql2 = "select * from showhomework_stude where sname='$sname' and cname='$cname' and hname like '$str'";
		$result2 = mysqli_query($link, $sql2);
		$row2 = mysqli_num_rows($result2);
		if ($row2 < 1) {
			?>
<script language="javascript">
alert ("作业尚未布置！");
</script>
<?php
} else {
			?>
<table border='1' space="0" align='center' width=700  Cellpadding=10>
<tr bgcolor="pink" align="center">
<th>
课程名称
</th>
<th>
任课老师
</th>
<th>
作业名称
</th>
<th>
提交截止时间
</th>
<th>
下载作业
</th>
</tr>
<?php
while ($row2 = mysqli_fetch_assoc($result2)) {
				echo "<tr>";
				echo "<td><center>";
				echo $row2["cname"];
				echo "</center></td>";
				echo "<td><center>";
				echo $row2["tname"];
				echo "</center></td>";
				echo "<td><center>";
				echo $row2["hname"];
				echo "</center></td>";
				echo "<td><center>";
				echo $row2["htimeend"];
				echo "</center></td>";
				echo "<td><center>";
				echo "<a  href=downloadhome.php?cname=" . $row2["cname"] . "&hname=" . $row2["hname"] . "&hcontent=" . $row2["hcontent"] . "&type=download onclick=\"return confirm('确定下载该作业吗？')\">下载</a>";
				echo "</center></td>";
				echo "</tr>";
			}
		}
	}
	echo "</table>";
	?>
</form>
</body>
</html>
<?php
} else {
	echo "对不起，您无权限查看此页面！";
}

?>