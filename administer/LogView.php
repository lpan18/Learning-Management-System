<?php
require_once '../config.php';

session_start();
echo "<b><h1 align=center ><font size='6'>登陆日志查询</b>";
unset($_SESSION['create_time']);

if (isset($_POST["btnSearch"])) {
	$create_time = $_POST["txtCreateTime"];
} else {
	$create_time = date("y-m-d");
}

if (isset($_GET["begin_record"])) {
	$_SESSION['g_begin_record'] = $_GET["begin_record"];
} else {
	$_SESSION['g_begin_record'] = 0;
}

?>

<div align=right>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method=post>
	<input type="text" name="txtCreateTime" value=<?php echo $create_time ?>>
	<input type="submit" name="btnSearch" value="查询">
</from>
</div>

<?php

require_once "LogClass.php";
$log = new Log();
$log->ShowByCreateTime($create_time);
?>