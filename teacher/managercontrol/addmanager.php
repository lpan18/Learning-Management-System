<?php
require_once '../../config.php';
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);

	$msno = $_POST["msno"];
	$mcno = $_POST["mcno"];
	$teacher = $_SESSION['TEACH'];
	$sql = "select * from sc,teacher,course  where scsno='$msno' and sccno='$mcno' and sc.sccno=course.cno and course.ctno=teacher.tno and teacher.tname='$teacher'";
	$results = mysqli_query($link, $sql);
	$row = mysqli_num_rows($results);
	if ($row < 1) {
		?>

<script language="javascript">
alert ("管理员学号或课程编号输入错误，请重新输入！");
</script>
<meta http-equiv='refresh' content='0;URL=scanmanager.php'>
<?php
} elseif ($row == 1) {

		$rowadd = mysqli_fetch_assoc($results);
		if ($rowadd[ifmanager] == 'y') {

			?>
<script language="javascript">
alert ("该管理员已经存在，请添加其它管理员！");
</script>
<meta http-equiv='refresh' content='0;URL=scanmanager.php'>
<?php
} else {

			$sqladd = "update sc set ifmanager='y' where scsno='$msno' and sccno='$mcno'";
			if (mysqli_query($link, $sqladd)) {
				?>
<script language="javascript">
alert ("添加管理员成功！");
</script>
<meta http-equiv='refresh' content='0;URL=scanmanager.php'>
<?php
}
		}
	}

} else {
	echo "对不起，您无权限查看此页面！";
}

?>