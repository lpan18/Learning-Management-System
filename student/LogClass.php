<?php

class Log {

	var $mInforArray;
	function getip() {
		if (getenv("HTTP_X_FORWARDED_FOR")) {
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		} elseif (getenv("HTTP_CLIENT_IP")) {
			$ip = getenv("HTTP_CLIENT_IP");
		} elseif (getenv("REMOTE_ADDR")) {
			$ip = getenv("REMOTE_ADDR");
		} else {
			$ip = "Unknown";
		}
		return $ip;
	}
	function getBrowser() {
		$agent = $_SERVER["HTTP_USER_AGENT"];
		if (strpos($agent, "MSIE")) {
			$exp = "IE";
		} elseif (strpos($agent, "Firefox")) {
			$exp = "Firefox ";
		} elseif (strpos($agent, "Maxthon")) {
			$exp = "Maxthon";
		} elseif (strpos($agent, "Chrome")) {
			$exp = "Google Chrome";
		} elseif (strpos($agent, "netscape")) {
			$exp = "Netscape";
		} elseif (strpos($agent, "Safari")) {
			$exp = "Safari";
		} elseif (strpos($agent, "Opera")) {
			$exp = "Opera";
		} else {
			$exp = "未知浏览器";
		}

		return $exp;
	}

	function write_Log($pCreateTime) {
		$ip = $this->getip();
		$exp = $this->getBrowser();
		require_once "database.php";
		$db = new DataBase(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS, LMS_DB_NAME);

		$db->SqlString = "insert into mylog";
		$db->SqlString = $db->SqlString . "(lsno,ltime,lip,lbrowser) ";
		$db->SqlString = $db->SqlString . " values (";
		$db->SqlString = $db->SqlString . "'" . $_SESSION['ID'] . "',";
		$db->SqlString = $db->SqlString . "'" . $pCreateTime . "',";
		$db->SqlString = $db->SqlString . "'" . $ip . "',";
		$db->SqlString = $db->SqlString . "'" . $exp . "'";
		$db->SqlString = $db->SqlString . ") ";

		$db->ExecuteSql();
		$db->__destruct();
	}

	function ShowByCreateTime($pCreateTime) {
		require_once "myDataGridClass.php";
		require_once "database.php";
		$db = new DataBase(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS, LMS_DB_NAME);
		echo "<h1 align=left ><font size=3>【操作时间】:" . $pCreateTime;
		$PAGE_MAX_LINE = 10;
		$view = new myDataGridClass($PAGE_MAX_LINE);
		///$temp="select * from Log where ltime='$pCreateTime'";

		$temp = "select * from mylog where ltime like '%$pCreateTime%' and lsno='" . $_SESSION['ID'] . "'";
		$view->__set("sql", $temp);
		$view->read_data();

		if ($view->current_records == 0) {
			echo "<tr><td colbegin_record=4> </td></tr>";
			return;
		}

		echo "<table width='95%' border='1' align='center'>";
		echo "<tr bgcolor='pink'>";
		echo "<td>序号</td>";
		echo "<td>时间</td>";
		echo "<td>IP地址</td>";
		echo "<td>浏览器类型</td>";
		echo "</tr>";
		for ($i = 0; $i < $view->current_records; $i++) {
			if (ceil($i / 2) * 2 == $i) {
				$bgc = "white";
			} else {
				$bgc = "yellow";
			}

			echo "<tr bgcolor=$bgc><td>";
			echo $view->result[$i]["lid"];
			echo "</td><td>";
			echo $view->result[$i]["ltime"];
			echo "</td><td>";
			echo $view->result[$i]["lip"];
			echo "</td><td>";
			echo $view->result[$i]["lbrowser"];
			echo "</td><tr>";

		}
		echo "</table>";

		$view->navigate();

		$db->__destruct();
	}

}
?>