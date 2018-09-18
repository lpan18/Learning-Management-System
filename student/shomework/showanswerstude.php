<?php
session_start();
if (isset($_SESSION['STUDEN']) == TRUE) {
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title> 老师发布的课件或作业答案 </title>
</head>
<body>

<form action="" method="post" enctype="multipart/form-data">
<br><p align="center"><b><font size="6">查看老师已发布的课件或作业答案<br><br></font></b></p>
<p align="center"><font size="5">
<?php
require_once '../../config.php';

	$sname = $_SESSION['STUDEN'];
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$sql2 = "select * from showanswer_stude where sname='$sname' order by cname,asname";
	$result2 = mysqli_query($link, $sql2);
	$row2 = mysqli_num_rows($result2);
	if ($row2 < 1) {
		?>
<script language="javascript">
alert ("答案尚未发布！");
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
答案名称
</th>
<th>
下载答案
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
			echo $row2["asname"];
			echo "</center></td>";
			echo "<td><center>";
			echo "<a href=downloadans.php?cname=" . $row2["cname"] . "&asname=" . $row2["asname"] . "&ascontent=" . $row2["ascontent"] . "&type=download onclick=\"return confirm('确定下载该答案吗？')\">下载</a>";
			echo "</center></td>";
			echo "</tr>";
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