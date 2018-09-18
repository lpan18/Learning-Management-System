<?php
session_start();
if (isset($_SESSION['STUDEN']) == TRUE) {
	unset($_SESSION['STUDEN']);
	echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>";
	echo "<meta http-equiv='refresh' content='1;URL=//site2.io/login.php'>";
	echo "</head>";
	echo "<body><h4>欢迎您下次访问！</h4></body>";
	echo "</html>";
} else {
	echo "对不起，您无权限查看此页面！";
}

?>