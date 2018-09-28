<?php
require_once '../../config.php';
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	$old = md5($_REQUEST["old"]);
	$passs = $_REQUEST["newpass"];
	$newpass = md5($_REQUEST["newpass"]);
	$names = $_SESSION['TEACH'];
	$sqlq = "select * from teacher where tname='$names' and tpassword='$old'";
	$results = mysqli_query($link, $sqlq);
	$row = mysqli_num_rows($results);
	if ($row < 1) {
		?>

<script language="javascript">
alert ("原始密码错误，密码修改失败！");
</script>
<meta http-equiv='refresh' content='0;URL=1gaimimat.php'>
<?php
} elseif ($row >= 1) {
		$sql2 = "update teacher set tpassword='$newpass' where tname='$names'";
		if (preg_match("/^(?!\D+$)(?![^a-zA-Z]+$)(?![a-zA-Z0-9]+$).{6,14}$/", $passs)) {

			if (mysqli_query($link, $sql2)) {
				?>
<script language="javascript">
alert ("密码修改成功");
</script>
<meta http-equiv='refresh' content='0;URL=/teacher/teacher.php'>
<?php
}

		} else {
			?>
   <script language="javascript">
   alert ("新密码格式不正确");
   </script>
    <meta http-equiv='refresh' content='0;URL=1gaimimat.php'>
    <?php

		}

	}
} else {
	echo "对不起，您无权限查看此页面！";
}

?>