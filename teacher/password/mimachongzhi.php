<?php
require_once '../../config.php';
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	?>

<p align="center"><b><font size=6>我的学生列表</font></b></p>
<?php
$namet = $_SESSION['TEACH'];
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$sql = "select * from mima_student where mima_student.tname='$namet'";
	$results = mysqli_query($link, $sql);
	$rows = mysqli_num_rows($results);
	if ($rows < 1) {
		echo '<p align="center">学生列表为空</p>';
	} else {
		?>
<table border='1' space="0" align='center' width=750  Cellpadding=5>

<tr bgcolor="pink" align="center">
<th>
课程编号
</th>
<th>
课程名称
</th>
<th>
学生学号
</th>
<th>
学生姓名
</th>
<th>
学生密码
</th>
<th>
密码重置<br>（慎用）
</th>
</tr>


<?php
while ($row = mysqli_fetch_assoc($results)) {
			echo "<tr>";
			echo "<td>";
			echo $row["sccno"];
			echo "</td>";
			echo "<td>";
			echo $row["cname"];
			echo "</td>";
			echo "<td>";
			echo $row["sno"];
			echo "</td>";
			echo "<td>";
			echo $row["sname"];
			echo "</td>";
			echo "<td>";
			echo $row["spassword"];
			echo "</td>";
			echo "<td align='center'>";
			echo "<a  href=chongzhi.php?sno=" . $row["sno"] . "&type=reset onclick=\"return confirm('您真的要重置该学生的密码吗？')\">重置</a>";
			echo "</td>";
			echo "<tr>";
		}
		echo "</table>";
	}

} else {
	echo "对不起，您无权限查看此页面！";
}

?>

