<?php
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	?>

<html><head>
<title>上传学生信息表</title></head>
<body>
<form enctype="multipart/form-data" action="" method="post">
<font size='5'>请选择文件： </font><br>
<input name="upload_file" type="file"  style="font-size:20;">&nbsp;&nbsp;&nbsp;
<input type="submit" value="上传" style="height:30px;width:100px;" style="font-size:20;">
</form>
</body>
</html>

<?php
require_once '../../config.php';
	$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
	if (!$link) {
		die('Not connected : ' . mysqli_error());
	}
	mysqli_select_db($link, LMS_DB_NAME);
	if (isset($_FILES['upload_file']) && $_FILES['upload_file']['name'] !== null) {
		$type = $_FILES['upload_file']['name'];
		$type2 = strstr($type, '.');

		$temp = file($type); //连接EXCEL文件,格式为.csv

		for ($i = 1; $i < count($temp); $i++) {
			if ($type2 != ".csv") {
				echo '上传类型错误,必须上传.csv文件，方法为将EXCEL另存为.csv文件';
				exit;
			}
			$string = explode(",", $temp[$i]); //通过循环得到EXCEL文件中每行记录的值
			//将EXCEL文件中每行记录的值插入到数据库中
			$q = "insert into sc values('$string[0]','$string[1]','$string[2]');";
			mysqli_query($link, $q) or die(mysqli_error());

			echo $string[3] . "\n";
			unset($string);
		}
		if (!mysqli_error());
		{
			echo " 成功导入数据!";
		}
	}
	?>
<br><br>
<p align="center"><b><font size="6">学生名单</font></b></p>
<?php
$namet = $_SESSION['TEACH'];
	$sql = "select * from changestudent_teacher where changestudent_teacher.tname='$namet'";
	$results = mysqli_query($link, $sql);
	$rows = @mysqli_num_rows($results);

	if ($rows < 1) {
		echo '<p align="center">没有学生</p>';
	} else {
		?>
<table border='1' space="1" align='center' width=800  Cellpadding=10>

<tr bgcolor="pink" align="center">
<th>
学号
</th>
<th>
姓名
</th>
<th>
性别
</th>
<th>
专业
</th>
<th>
课程
</th>
<th>
课程编号
</th>
</tr>


<?php
while ($row = mysqli_fetch_assoc($results)) {
			echo "<tr>";
			echo "<td>";
			echo $row["sno"];
			echo "</td>";
			echo "<td>";
			echo $row["sname"];
			echo "</td>";
			echo "<td>";
			echo $row["ssex"];
			echo "</td>";
			echo "<td>";
			echo $row["smajor"];
			echo "</td>";
			echo "<td>";
			echo $row["cname"];
			echo "</td>";
			echo "<td>";
			echo $row["cno"];
			echo "</td>";

			echo "<tr>";
		}
		echo "</table>";
	}

} else {
	echo "对不起，您无权限查看此页面！";
}

?>