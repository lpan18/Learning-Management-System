<?php
session_start();
if (isset($_SESSION['ADMIN']) == TRUE) {
	unset($_SESSION['ADMIN']);
	echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>";
	echo "<meta http-equiv='refresh' content='1;URL=/login.php'>";
	echo "</head>";
	echo "<body><h4>��ӭ���´η��ʣ�</h4></body>";
	echo "</html>";
} else {
	echo "�Բ�������Ȩ�޲鿴��ҳ�棡";
}

?>