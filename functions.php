<?php
require_once 'config.php';
session_start();

function lms_get_current_user() {
	if (!isset($_SESSION['current_login_user'])) {
		// 没有当前登录用户信息，意味着没有登录
		header('Location: /login.php');
		exit(); // 没有必要再执行之后的代码
	} else {
		return $_SESSION['current_login_user'];
	}
}

function lms_get_user_role() {
	if (!isset($_SESSION['user_role'])) {
		return '';
	} else {
		return $_SESSION['user_role'];
	}
}

function lms_fetch_all($sql) {
	$conn = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS, LMS_DB_NAME);
	if (!$conn) {
		exit('Connection Failed');
	}
	$result = array();
	$query = mysqli_query($conn, $sql);
	if (!$query) {
		// 查询失败
		return false;
	}

	while ($row = mysqli_fetch_assoc($query)) {
		$result[] = $row;
	}

	mysqli_free_result($query);
	mysqli_close($conn);
	return $result;
}

function lms_fetch_one($sql) {
	$res = lms_fetch_all($sql);
	return isset($res[0]) ? $res[0] : null;
}

function lms_execute($sql) {
	$conn = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS, LMS_DB_NAME);
	if (!$conn) {
		exit('Connection Failed');
	}

	$query = mysqli_query($conn, $sql);
	if (!$query) {
		// 查询失败
		return false;
	}

	// 对于增删修改类的操作都是获取受影响行数
	$affected_rows = mysqli_affected_rows($conn);

	mysqli_close($conn);

	return $affected_rows;
}
?>