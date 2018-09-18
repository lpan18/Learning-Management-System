<?php
require_once 'config.php';
require_once "student/LogClass.php";
date_default_timezone_set('America/Los_Angeles');
session_start();
if ($_POST["radio"] == "student") {

	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);

	$no = $_REQUEST["user"];
	$compare = md5($no);
	$pass = md5($_REQUEST["password"]);

	$sql = "select distinct sname from sc_student1 where sno='$no'&& spassword='$pass' and
     sname not in (select distinct sname from sc_student1 where ifmanager='y')";
	$result = mysqli_query($link, $sql);

	if (@mysqli_num_rows($result) != 0) {
		$numrows = mysqli_num_rows($result);
		if ($numrows == 1) {
			$row1 = mysqli_fetch_assoc($result);
			$_SESSION['STUDEN'] = $row1["sname"];
			$_SESSION['ID'] = $no;
		}
		$log = new Log();
		$t = date("Y-m-d H:i:s", time());
		$log->write_Log($t);
		echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=gb2312'>";

		if ($compare == $pass) {echo "<meta http-equiv='refresh' content='1;URL=/student/mima/1gaimimas.php'>";} else {echo "<meta http-equiv='refresh' content='1;URL=/student/student.php'>";}

		echo "</head>";
		echo "<body><h4>您好，" . $row1["sname"] . "同学！登录成功，1秒后进入系统……</h4></body>";
		echo "</html>";

	} else {
		echo "<body><h4>用户名或密码错误！即将返回登入页面……</h4></body>";
		echo "<meta http-equiv='refresh' content='1;URL=/login.php'>";
	}

} elseif ($_POST["radio"] == "teacher") {
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);

	$no = $_REQUEST["user"];
	$compare = md5($no);
	$pass = md5($_REQUEST["password"]);
	$sql = "select * from teacher where tno='$no'&& tpassword='$pass'";
	$result = mysqli_query($link, $sql);

	if (@mysqli_num_rows($result) != 0) {
		$numrows = mysqli_num_rows($result);
		if ($numrows == 1) {
			$row2 = mysqli_fetch_assoc($result);
			$_SESSION['TEACH'] = $row2["tname"];
			$_SESSION['ID'] = $no;
		}
		$log = new Log();
		$t = date("Y-m-d H:i:s", time());
		$log->write_Log($t);
		echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=gb2312'>";

		if ($compare == $pass) {echo "<meta http-equiv='refresh' content='1;URL=/teacher/mima/1gaimimat.php'>";} else {echo "<meta http-equiv='refresh' content='1;URL=/teacher/teacher.php'>";}

		echo "</head>";
		echo "<body><h4>您好，" . $row2["tname"] . "老师！登录成功，1秒后进入系统……</h4></body>";
		echo "</html>";

	} else {
		echo "<body><h4>用户名或密码错误！即将返回登入页面……</h4></body>";
		echo "<meta http-equiv='refresh' content='1;URL=/login.php'>";
	}
} elseif ($_POST["radio"] == "manager") {
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);

	$no = $_REQUEST["user"];
	$compare = md5($no);
	$pass = md5($_REQUEST["password"]);

	$sql = "select distinct sno,sname from sc_student1 where sno='$no'&& spassword='$pass' && ifmanager='y'";
	$result = mysqli_query($link, $sql);

	if (@mysqli_num_rows($result) != 0) {
		$numrows = mysqli_num_rows($result);
		if ($numrows == 1) {
			$row3 = mysqli_fetch_assoc($result);
			$_SESSION['ADMIN'] = $row3["sname"];
			$_SESSION['ID'] = $no;
		}
		$log = new Log();
		$t = date("Y-m-d H:i:s", time());
		$log->write_Log($t);
		echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=gb2312'>";

		if ($compare == $pass) {echo "<meta http-equiv='refresh' content='1;URL=/administer/mima/1gaimimaa.php'>";} else {echo "<meta http-equiv='refresh' content='1;URL=/administer/administer.php'>";}

		echo "</head>";
		echo "<body><h4>您好，" . $row3["sname"] . "管理员！登录成功，1秒后进入系统……</h4></body>";
		echo "</html>";

	} else {
		# test
		echo $compare;
		echo $pass;
		echo "<body><h4>用户名或密码错误！即将返回登入页面……</h4></body>";
		echo "<meta http-equiv='refresh' content='1;URL=/login.php'>";
	}
} else {
	echo "<body><h4>非法登入！即将返回登入页面……</h4></body>";
	echo "<meta http-equiv='refresh' content='1;URL=/login.php'>";
}

?>

