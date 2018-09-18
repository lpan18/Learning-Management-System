<?php
require_once '../../config.php';
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title> 查看删除作业 </title>
</head>
<body>

<?php
$tname = $_SESSION['TEACH'];
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$sql = "select * from showhomework_teach where tname='$tname' order by cname,hname";
	$results = mysqli_query($link, $sql);
	$rows = mysqli_num_rows($results);

	if ($rows < 1) {
		echo '<p align="center"><b><font size=6>您未布置任何作业</font></b></p>';
	} else {
		?>
<br><p align="center"><b><font size="6">您已布置以下作业：</font></b></p>
<table border='1' space="1" align='center' width=800  Cellpadding=10>
<tr bgcolor="pink" align="center">
<th>
课程名称
</th>
<th>
作业名称
</th>
<th>
网络存放路径
</th>
<th>
提交截止时间
</th>
<th>
删除作业
</th>
</tr>
<?php
while ($row = mysqli_fetch_assoc($results)) {
			echo "<tr>";
			echo "<td><center>";
			echo $row["cname"];
			echo "</center></td>";
			echo "<td><center>";
			echo $row["hname"];
			echo "</center></td>";
			echo "<td><center>";
			echo $row["hcontent"];
			echo "</center></td>";
			echo "<td><center>";
			echo $row["htimeend"];
			echo "</center></td>";
			echo "<td><center>";
			echo "<a  href=/teacher/thomework/delhomework.php?cname=" . $row["cname"] . "&hname=" . $row["hname"] . "&hcontent=" . $row["hcontent"] . "&type=del onclick=\"return confirm('您真的要删除该作业吗？')\">删除</a>";
			echo "</center></td>";
			echo "</tr>";
		}
	}
	echo "</table>";
	?>
</body>
</html>
<?php
} else {
	echo "对不起，您无权限查看此页面！";
}

?>