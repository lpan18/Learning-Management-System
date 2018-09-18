<?php
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title> 查看删除课件或答案 </title>
</head>
<body>

<?php
require_once '../../config.php';
	$tname = $_SESSION['TEACH'];
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$sql = "select * from showanswer_teach where tname='$tname'";
	$results = mysqli_query($link, $sql);
	$rows = mysqli_num_rows($results);

	if ($rows < 1) {
		echo '<p align="center"><b><font size=5>您未发布任何课件或答案</font></b></p>';
	} else {
		?>
<br><p align="center"><b><font size="6">您已发布以下课件或答案</font></b></p>
<table border='1' space="1" align='center' width=600  Cellpadding=10>
<tr bgcolor="pink" align="center">
<th>
课程名称
</th>
<th>
文件名称
</th>
<th>
网络存放路径
</th>
<th>
删除
</th>
</tr>
<?php
while ($row = mysqli_fetch_assoc($results)) {
			echo "<tr>";
			echo "<td><center>";
			echo $row["cname"];
			echo "</center></td>";
			echo "<td><center>";
			echo $row["asname"];
			echo "</center></td>";
			echo "<td><center>";
			echo $row["ascontent"];
			echo "</center></td>";
			echo "<td><center>";
			echo "<a  href=/teacher/thomework/delanswer.php?cname=" . $row["cname"] . "&asname=" . $row["asname"] . "&ascontent=" . $row["ascontent"] . "&type=del onclick=\"return confirm('您真的要删除该课件或答案吗？')\">删除</a>";
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