<?php
session_start();
if (isset($_SESSION['STUDEN']) == TRUE) {
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title> 查看已提交作业 </title>
</head>
<body>

<?php
require_once '../../config.php';
	$sname = $_SESSION['STUDEN'];
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$sql = "select * from showsh_stude where sname='$sname' order by shsubdate desc";
	$results = mysqli_query($link, $sql);
	$rows = mysqli_num_rows($results);
	if ($rows < 1) {
		echo '<p align="center"><b><font size=6>您未提交任何作业</font></b></p>';
	} else {
		?>
<br><p align="center"><b><font size="6">您已提交以下作业：</font></b></p><br>
<table border='1' space="1" align='center' width=800  Cellpadding=10>
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
最近一次提交时间
</th>
<th>
截止时间
</th>
<th>
评分
</th>
<th>
评语
</th>
</tr>
<?php
while ($row = mysqli_fetch_assoc($results)) {
			echo "<tr>";
			echo "<td><center>";
			echo $row["cname"];
			echo "</center></td>";
			echo "<td><center>";
			echo $row["tname"];
			echo "</center></td>";
			echo "<td><center>";
			echo $row["shhname"];
			echo "</center></td>";
			echo "<td><center>";
			echo $row["shsubdate"];
			echo "</center></td>";
			echo "<td><center>";
			echo $row["htimeend"];
			echo "</center></td>";

			echo "<td><center>";
			$aaa = $row[shscore];
			if ($aaa) {
				echo $aaa;
			} else {
				echo "未评";
			}
			echo "</center></td>";

			echo "<td><center>";
			$bbb = $row[shremark];
			if ($bbb) {
				echo $bbb;
			} else {
				echo "未评";
			}
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