<?php
require_once '../config.php';
session_start();
if (isset($_SESSION['ADMIN']) == TRUE) {
	?>
<p align="center"><b><font size="6">My Account</font></b></p>
<?php

	$namea = $_SESSION['ADMIN'];
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$sql = "select * from student where sname='$namea'";
	$result = mysqli_query($link, $sql);
	$row = mysqli_fetch_assoc($result);

	echo "<table border='1' align='center' width=400  Cellpadding=10  frame='hsides'>";

	echo "<tr>";
	echo "<th  bgcolor='pink'>";
	echo "Student No";
	echo "</th>";
	echo "<td>";
	echo $row["sno"];
	echo "</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<th bgcolor='pink'>";
	echo "Student Name";
	echo "</th>";
	echo "<td>";
	echo $row["sname"];
	echo "</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<th bgcolor='pink'>";
	echo "Gender";
	echo "</th>";
	echo "<td>";
	echo $row["ssex"];
	echo "</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<th bgcolor='pink'>";
	echo "Major";
	echo "</th>";
	echo "<td>";
	echo $row["smajor"];
	echo "</td>";
	echo "<tr>";

	echo "<tr>";
	echo "<th bgcolor='pink'>";
	echo "Role";
	echo "</th>";
	echo "<td>";
	echo "Student Admin";
	echo "</td>";
	echo "<tr>";

	echo "</table>";

} else {
	echo "对不起，您无权限查看此页面！";
}

?>
