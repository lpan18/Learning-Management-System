<?php
require_once '../../config.php';
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$ssno = $_POST["ssno"];
	$cno = $_POST["cno"];
	$teacher = $_SESSION['TEACH'];

	$sql2 = "select * from sc where scsno='$ssno' and sccno='$cno'";
	$results2 = mysqli_query($link, $sql2);
	$row2 = mysqli_num_rows($results2);
	if ($row2 == 1) {
		?>

<script language="javascript">
alert ("该学生已选此课，请重新添加学生");
</script>
<meta http-equiv='refresh' content='0;URL=changestudent.php'>
<?php
} elseif ($row2 < 1) {
		$sql3 = "select * from student where sno='$ssno'";
		$results3 = mysqli_query($link, $sql3);
		$row3 = mysqli_num_rows($results3);
		if ($row3 < 1) {
			?>

<script language="javascript">
alert ("此同学不存在，请重新输入");
</script>
<meta http-equiv='refresh' content='0;URL=changestudent.php'>
<?php
} else {
			$sql4 = "select * from course where cno='$cno'";
			$results4 = mysqli_query($link, $sql4);
			$row4 = mysqli_num_rows($results4);
			if ($row4 < 1) {
				?>

<script language="javascript">
alert ("此课程不存在，请重新输入");
</script>
<meta http-equiv='refresh' content='0;URL=changestudent.php'>
<?php
} else {
				$sql = "insert into sc values('$ssno','$cno','n')";
				$results = mysqli_query($link, $sql);
				?>
<script language="javascript">
alert ("添加学生成功！");
</script>
<meta http-equiv='refresh' content='0;URL=changestudent.php'>
<?php
}
		}
	}

} else {
	echo "对不起，您无权限查看此页面！";
}

?>