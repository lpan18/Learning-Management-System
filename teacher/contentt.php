<?php
require_once '../config.php';
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	?>
<p align="center"><b><font size="6">我的基本信息</font></b></p>
<?php

	$namet = $_SESSION['TEACH'];
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$sql = "select * from teacher where tname='$namet'";
	$result = mysqli_query($link, $sql);
	$row = mysqli_fetch_assoc($result);
	?>
	<html>
    <head>
    <link rel="stylesheet" href="../style.css">
    </style>
	</head>
    <body>
	<table>
	<tr>
	<th>
	教工号
	</th>
	<td>
	<?php echo $row["tno"] ?>
	</td>
	</tr>
	<tr>
	<th>
	姓名
	</th>
	<td>
	<?php echo $row["tname"] ?>
	</td>
	</tr>

	<tr>
	<th>
	身份
	</th>
	<td>
	教师
	</td>
	<tr>
	</table>
</body>
</html>
<?php
} else {
	echo "对不起，您无权限查看此页面！";
}

?>
