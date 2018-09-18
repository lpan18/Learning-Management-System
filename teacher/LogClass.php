<?php
require_once "../config.php";
require_once "database.php";
require_once "myDataGridClass.php";
class Log {
	var $mInforArray;
	var $PAGE_MAX_LINE = 10;
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

	function write_Log($pCreateTime, $ip) {
		$ip = $this->getip();
		$exp = $this->getBrowser();
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
		$no = $_SESSION['ID'];
		$db = new DataBase(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS, LMS_DB_NAME);
		echo "<h1 align=left ><font size=3>【操作时间】:" . $pCreateTime;
		$view = new myDataGridClass($PAGE_MAX_LINE);
		$temp = "select * from Log where ltime='$pCreateTime'";
		$temp = "select sccno,sname,lsno,lip,ltime from student,course,sc,mylog where course.ctno='" . $no . "'and course.cno=sc.sccno and sc.scsno=mylog.lsno and student.sno=mylog.lsno";
		$view->__set("sql", $temp);
		$view->read_data();
		if ($view->current_records == 0) {
			echo "<tr><td colbegin_record=4> </td></tr>";
			return;
		}
		echo "<table width='80%' border='1' align='center'>";
		echo "<tr bgcolor='pink' height=30>";
		echo "<th>课号</th>";
		echo "<th>姓名</th>";
		echo "<th>学号</th>";
		echo "<th>IP地址</th>";
		echo "<th>时间</th>";
		echo "</tr>";
		for ($i = 0; $i < $view->current_records; $i++) {
			if (ceil($i / 2) * 2 == $i) {
				$bgc = "white";
			} else {
				$bgc = "yellow";
			}

			echo "<tr bgcolor=$bgc><td>";
			echo $view->result[$i]["sccno"];
			echo "</td><td>";
			echo $view->result[$i]["sname"];
			echo "</td><td>";
			echo $view->result[$i]["lsno"];
			echo "</td><td>";
			echo $view->result[$i]["lip"];
			echo "</td><td>";
			echo $view->result[$i]["ltime"];
			echo "</td><tr>";

		}
		echo "</table>";
		$view->navigate();
		$db->__destruct();
	}
	function ShowByCourseNoAndStudentNum($course_no, $student_num) {
		$no = $_SESSION['ID'];
		$db = new DataBase(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS, LMS_DB_NAME);
		$view = new myDataGridClass($PAGE_MAX_LINE);
		$temp = "";
		if ($course_no !== "abcdefg" && $student_num == "abcdefg") {
			$temp = "select  sccno,sname,lsno,lip,ltime,lbrowser from student,course,sc,mylog where course.cno='" . $course_no . "' and course.ctno='" . $no . "'and course.cno=sc.sccno and sc.scsno=mylog.lsno and student.sno=mylog.lsno";
		}
		if ($student_num !== "abcdefg" && $course_no === "abcdefg") {
			$temp = "select  sccno,sname,lsno,lip,ltime,lbrowser from student,course,sc,mylog where student.sname='" . $student_num . "' and course.ctno='" . $no . "'and course.cno=sc.sccno and sc.scsno=mylog.lsno and student.sno=mylog.lsno";
		}
		if ($course_no !== "abcdefg" && $student_num != "abcdefg") {
			$temp = "select sccno,sname,lsno,lip,ltime,lbrowser from student,course,sc,mylog where course.cno='" . $course_no . "' and course.ctno='" . $no . "'and course.cno=sc.sccno and sc.scsno=mylog.lsno and student.sno=mylog.lsno and student.sname='" . $student_num . "'";
		}
		$view->__set("sql", $temp);
		$view->read_data();
		if ($view->current_records == 0) {
			echo "<tr><td colbegin_record=4> </td></tr>";
			echo "暂无相关登陆日志!";
			return;
		}
		echo "<table width='80%' border='1' align='center'>";
		echo "<tr bgcolor='pink' height=30>";
		echo "<th>课号</th>";
		echo "<th>姓名</th>";
		echo "<th>学号</th>";
		echo "<th>IP地址</th>";
		echo "<th>时间</th>";
		echo "<th>浏览器类型</th>";
		echo "</tr>";
		for ($i = 0; $i < $view->current_records; $i++) {
			if (ceil($i / 2) * 2 == $i) {
				$bgc = "white";
			} else {
				$bgc = "yellow";
			}

			echo "<tr bgcolor=$bgc><td>";
			echo $view->result[$i]["sccno"];
			echo "</td><td>";
			echo $view->result[$i]["sname"];
			echo "</td><td>";
			echo $view->result[$i]["lsno"];
			echo "</td><td>";
			echo $view->result[$i]["lip"];
			echo "</td><td>";
			echo $view->result[$i]["ltime"];
			echo "</td><td>";
			echo $view->result[$i]["lbrowser"];
			echo "</td><tr>";
		}
		echo "</table>";

		$view->navigate();

		$db->__destruct();
	}
	function ShowByCourseGroup($course_no) {
		if (isset($_SESSION['ID'])) {
			$no = $_SESSION['ID'];
		}
		$db = new DataBase(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS, LMS_DB_NAME);
		$PAGE_MAX_LINE = 10;
		$view = new myDataGridClass($PAGE_MAX_LINE);
		$temp = "select S.sno myno,S.sname myname,count(*) mycount from student S,mylog M,sc SC where SC.sccno='" . $course_no . "' and S.sno=M.lsno and SC.scsno=S.sno group by S.sno";
		$view->__set("sql", $temp);
		$view->read_data();
		if ($view->current_records == 0) {
			echo "<tr><td colbegin_record=4> </td></tr>";
			echo "暂无相关登陆日志!";
			return;
		}
		echo "<table width='80%' border='1' align='center'>";
		echo "<tr bgcolor='pink' height=30>";
		echo "<th>学号</th>";
		echo "<th>姓名</th>";
		echo "<th>次数</th>";
		echo "</tr>";
		for ($i = 0; $i < $view->current_records; $i++) {
			if (ceil($i / 2) * 2 == $i) {
				$bgc = "white";
			} else {
				$bgc = "yellow";
			}

			echo "<tr bgcolor=$bgc><td>";
			echo $view->result[$i]["myno"];
			echo "</td><td>";
			echo $view->result[$i]["myname"];
			echo "</td><td>";
			echo $view->result[$i]["mycount"];
			echo "</td><tr>";
		}
		echo "</table>";
		$view->navigate();
		$db->__destruct();
	}

}
?>