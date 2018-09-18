<?php
require_once '../../config.php';
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$sno = $_REQUEST["sno"];
	$sname = $_REQUEST["sname"];
	$smajor = $_REQUEST["smajor"];
	$ysno = $_REQUEST["ysno"];
	if ($_POST["radio"] == "男") {
		$ssex = "男";
	} else {
		$ssex = "女";
	}

	$sql = "select * from course where cname='$smajor'";
	$result = mysqli_query($link, $sql);

	if ($ysno == $sno) {
		$sqlq = "update student set sname='$sname',ssex='$ssex',smajor='$smajor' where sno='$ysno'";
		mysqli_query($link, $sqlq);
		?>
<script language="javascript">
alert ("修改学生信息成功");
</script>
<meta http-equiv='refresh' content='0;URL=changestudent.php'>
<?php
} else {
		$sqlq = "update student set sname='$sname',ssex='$ssex',smajor='$smajor',sno='$sno' where sno='$ysno'";
		$result = mysqli_query($link, $sqlq);
		if ($result) {
			?>
<script language="javascript">
alert ("修改学生信息成功");
</script>
<meta http-equiv='refresh' content='0;URL=changestudent.php'>
<?php
} else {
			?>
<script language="javascript">
alert ("该学生学号不能与其他同学学号重复");
</script>
<meta http-equiv='refresh' content='0;URL=changestudent.php'>
<?php
}
	}

} else {
	echo "对不起，您无权限查看此页面！";
}

?>

