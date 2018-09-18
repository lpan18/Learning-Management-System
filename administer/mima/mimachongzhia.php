<?php
session_start();
if (isset($_SESSION['ADMIN']) == TRUE) {
	?>

<p align="center"><b><font size="6">密码重置</font></b></p>
<?php
require_once '../../config.php';
	$namea = $_SESSION['ADMIN'];
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);

	$sql = "select * from student where sname='$namea'";
	$result = mysqli_query($link, $sql);
	$row2 = mysqli_fetch_assoc($result);
	$snoa = $row2["sno"];
	$sql = "select * from manager_student where manager_student.scsno='$snoa' and ifmanager='n' order by cname,sno";
	$results = mysqli_query($link, $sql);
	$rows = mysqli_num_rows($results);
	if ($rows < 1) {
		echo '<p align="center">学生列表为空</p>';
	} else {
		?>
<table border='1' space="1" align='center' width=1000  Cellpadding=10>

<tr bgcolor="pink" align="center">
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
密码重置（慎用）
</th>
</tr>


<?php
while ($row = mysqli_fetch_assoc($results)) {
			echo "<tr>";
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
			echo "<a  href=chongzhia.php?sno=" . $row["sno"] . "&type=reset onclick=\"return confirm('您真的要重置该学生的密码吗？')\">重置</a>";
			echo "</td>";
			echo "<tr>";
		}
		echo "</table>";
	}

} else {
	echo "对不起，您无权限查看此页面！";
}

?>
