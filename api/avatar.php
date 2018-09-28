<?php
require_once '../functions.php';
if (empty($_GET['username'])) {
	exit('Empty username.');
}
$username = $_GET['username'];
if (strlen($username) == 7) {
	$result = lms_fetch_one("SELECT * from student where sno = '{$username}' limit 1;")['avatar'];
} elseif (strlen($username) == 5) {
	$result = lms_fetch_one("SELECT * from teacher where tno = '{$username}' limit 1;")['avatar'];
} else {
	$result = "/static/assets/img/default.png";
}
echo $result;