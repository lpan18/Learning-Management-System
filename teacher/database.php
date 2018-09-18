<?php
class DataBase {
	public $mConnId;
	public $mSqlString;
	public $mResultArray;
	function __construct($pHost, $pUser, $pPwd, $pDbName) {
		$this->mConnId = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
		mysqli_select_db($this->mConnId, LMS_DB_NAME);
	}
	function __destruct() {
		//mysql_close($this->mConnId);
	}
	function ExecuteSql() {

		mysqli_query($this->mConnId, $this->SqlString);
	}
	function Query() {

		$i = 0;
		///$query_result=mysql_query($this->SqlString,$this->mConnId);
		$query_result = mysqli_query($this->mConnId, $this->mSqlString);
		while ($row = mysqli_fetch_object($query_result)) {
			$this->mResultArray[$i++] = $row;
		}

		return $this->mResultArray;
	}

}

?>