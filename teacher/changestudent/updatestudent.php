<?php
session_start();

if (isset($_SESSION['TEACH']) == TRUE) {

	?>

<script language="javascript">
//获得焦点输入背景设置为红色
function setStyle(x)
{
document.getElementById(x).style.background="pink"
}
//失去焦点输入背景重置为白色
function recoveryStyle(y)
{
document.getElementById(y).style.background="White"
}

function check()
{
var t=document.all;
var patrn=/^[0-9]{6,7}$/;
var patrn2=/^[\u2E80-\uFE4F]+$/;

if(!patrn.exec(t.sno.value))
{
alert("新学号必须是6-7位的数字！");
t.sno.focus();
return false;
}

if(!patrn2.exec(t.sname.value))
{
alert("姓名必须是中文！");
t.sname.focus();
return false;
}


if(!patrn2.exec(t.smajor.value))
{
alert("专业必须是中文！");
t.smajor.focus();
return false;
}





if(t.sno.value=="")
{
alert("请输入新学号！");
t.sno.focus();
return false;
}




if(t.sname.value=="")
{
alert("请输入新姓名！");
t.sno.focus();
return false;
}


if(t.smajor.value=="")
{
alert("请输入专业！");
t.smajor.focus();
return false;
}

}

</script>



<form id="formupdatestudent" name="formupdatestudent" method="post" action="updatestudent2.php" onsubmit="return check()">
<div align="center"><b><font size='5'>学生基本信息修改</font></b><br><br><br><br></div>
<table width="337" border="1" align="center" cellpadding=5>
<tr>
<td width="90">原学号：</td>
<td>
<?php
$ysno = $_GET['sno'];
	echo "$ysno";
	?>
</td>
</tr>
<tr>
<td width="81">学号：</td>
<input type="hidden" id="ysno" name="ysno" value="<? echo $_GET['sno']; ?>" />

<td><input type="text" name="sno" id="sno" value="<? echo $_GET['sno']; ?>" onfocus="setStyle(this.id)" id="fname" onBlur="recoveryStyle(this.id)" style="height=25px;"></td>
</tr>
<tr>
<td>姓名：</td>
<td><input type="text" name="sname" id="sname" onfocus="setStyle(this.id)" id="fname" onBlur="recoveryStyle(this.id)" style="height=25px;">
<script language="javascript">
document.all.sname.focus()
</script></td>
</tr>
<tr>
<td>性别：</td>
<td><label>
<input type="radio" name="radio" id="type" value=男  checked>
</label>
男
&nbsp;&nbsp;&nbsp;
<input type="radio" name="radio" id="type1" value=女>
</label>
女
</td>
</tr>
<tr>
<td>专业：</td>
<td><input type="text" name="smajor" id="smajor" onfocus="setStyle(this.id)" id="fname" onBlur="recoveryStyle(this.id)" style="height=25px;"></td>
</tr>
<tr>
<td>&nbsp;<br><br><br></td>
<td><input type=submit name=submit id=submit value="更改信息" style="height=30px;width=90px;">
<input type="reset" name="button" id="button" value="重新设置" style="height=30px;width=90px;"></td>
</tr>
</table>
</form>



<p align="center"><font size="4" color="red">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注意：1、学号必须是6-7位数字且在系统中唯一，建议对此项谨慎修改。<br><br>
2、除学号外其他修改项中不得出现数字。</font></p>



<?php
} else {
	echo "对不起，您无权限查看此页面！";
}

?>



<br><p align="center"><b><font size="4">原始学生基本信息</font></b></p>
<?php
require_once '../../config.php';
$link = mysqli_connect(LMS_DB_HOST, LMS_DB_USER, LMS_DB_PASS);
if (!$link) {
	die('Not connected : ' . mysqli_error());
}
mysqli_select_db($link, LMS_DB_NAME);
$sno = $_GET[sno];
$sqll = "select * from student where sno='$sno'";
$results = mysqli_query($link, $sqll);
$rowss = mysqli_num_rows($results);
if ($rowss < 1) {
	echo '<p align="center">学生列表为空</p>';
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
		echo "<tr>";

	}
	echo "</table>";
}

?>


