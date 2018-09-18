<?php
class myDataGridClass {
	var $sql;
	var $max_line;
	var $begin_record;
	var $total_records;
	var $current_records;
	var $result;
	var $total_pages;
	var $current_page;
	function myDataGridClass($pmax_line) {
		$this->max_line = $pmax_line;
		$this->begin_record = 0;
	}
	function __destruct() {

	}
	function __get($property_name) {
		if (isset($this->$property_name)) {
			return ($this->$property_name);
		} else {
			return (NULL);
		}
	}
	function __set($property_name, $value) {
		$this->$property_name = $value;
	}
	function read_data() {
		$psql = $this->sql;
		$this->begin_record = isset($_GET["begin_record"]) ? $_GET["begin_record"] : null;
		if ($this->begin_record == null) {
			$this->begin_record = 0;
		}

		require_once "../config.php";

		// $mysqli = new DataBase(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS, LMS_DB_NAME);
		// $mysqli->mSqlString = $psql;
		// $result = $mysqli->query() or die(mysqli_error());
		$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
		if (!$link) {
			die('Not connected : ' . mysqli_error());
		}
		mysqli_select_db($link, LMS_DB_NAME);
		$result = mysqli_query($link, $psql);

		$this->total_records = mysqli_num_rows($result);
		// $this->total_records = count($result);
		if ($this->total_records > 0) {
			$psql = $psql . " LIMIT " . $this->begin_record . " , " . $this->max_line;
			$result = mysqli_query($link, $psql) or die(mysqli_error());
			$this->current_records = mysqli_num_rows($result);
			$i = 0;
			while ($row = mysqli_fetch_Array($result)) {
				$this->result[$i] = $row;
				$i++;
			}
		}
	}
	function navigate() {

		echo "<hr>";
		echo "<hr>";
		$this->total_pages = ceil($this->total_records / $this->max_line);
		$this->current_page = $this->begin_record / $this->max_line + 1;
		echo "<div align=center>";
		echo "<font color = red size ='4'>第" . $this->current_page . "页/共" . $this->total_pages . "页</font>";
		echo "    ";
		$first = 0;
		$next = $this->begin_record + $this->max_line;
		$prev = $this->begin_record - $this->max_line;
		$last = ($this->total_pages - 1) * $this->max_line;

		if ($this->begin_record >= $this->max_line) {
			echo "<A href=" . $_SERVER['PHP_SELF'] . "?begin_record=" . $first . ">首页</A>|";
		}

		if ($prev >= 0) {
			echo "<A href=" . $_SERVER['PHP_SELF'] . "?begin_record=" . $prev . ">上一页</A>|";
		}

		if ($next < $this->total_records) {
			echo "<A href=" . $_SERVER['PHP_SELF'] . "?begin_record=" . $next . ">下一页</A>|";
		}

		if ($this->total_pages != 0 && $this->current_page < $this->total_pages) {
			echo "<A href=" . $_SERVER['PHP_SELF'] . "?begin_record=" . $last . ">末页</A>";
		}

		echo "</div>";
	}

}
?>