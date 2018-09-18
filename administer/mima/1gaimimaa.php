<?php
session_start();

if (isset($_SESSION['ADMIN']) == TRUE) {
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
var a=document.all;

if(a.old.value=="")
{
alert("请输入旧密码！");
a.old.focus();
return false;
}

if(a.newpass.value=="")
{
alert("请输入新密码！");
a.newpass.focus();
return false;
}

if(a.newpass.value==a.old.value)
{
alert("输入的新密码与旧密码相同！");
a.new1.focus();
return false;
}


if(a.new1.value!=a.newpass.value)
{
alert("两次密码输入不一致！");
a.new1.focus();
return false;
}

}


function chkpwd(obj){
var t=obj.value;
var id=getResult(t);

//定义对应的消息提示
var msg=new Array(4);
msg[0]="密码过短。";
msg[1]="密码强度太低。";
msg[2]="密码强度一般，仍不符合要求。";
msg[3]="密码强度高。";

var sty=new Array(4);
sty[0]=-45;
sty[1]=-30;
sty[2]=-15;
sty[3]=0;

var col = new Array(4);
col[0] = "gray";
col[1] = "#50AEDD";
col[2] = "#FF8213";
col[3] = "green";

//设置显示效果
var bImg="mimajiance.gif" //一张显示用的图片
var sWidth=300;
var sHeight=15;
var Bobj=document.getElementById("chkResult");

Bobj.style.fontSize="12px";
Bobj.style.color=col[id];
Bobj.style.width=sWidth + "px";
Bobj.style.height=sHeight + "px";
Bobj.style.lineHeight=sHeight + "px";
Bobj.style.background="url(" + bImg + ") no-repeat left " + sty[id] + "px";
Bobj.style.textIndent="20px";
Bobj.innerHTML="检测提示：" + msg[id];
}

//定义检测函数,返回0/1/2/3分别代表无效/差/一般/强
function getResult(s){
if(s.length < 6){
   return 0;
}
var ls = 0;
if (s.match(/[a-z]/ig)){
   ls++;
}
if (s.match(/[0-9]/ig)){
   ls++;
}
   if (s.match(/(.[^a-z0-9])/ig)){
   ls++;
}
if (s.length < 6 && ls > 0){
   ls--;
}
return ls
}

</script>

<title>初始密码修改</title>

<form id="formgaimi" name="formgaimi" method="post" action="1gaimimaa2.php" onsubmit="return check()">
<div align="center"><br><br><br><br><b><font size='6'>初始密码修改</font></b><br><br><br><br></div>
<table width="450" border="0" align="center">
<tr>
<td width="120">用户名：</td>
<td>
<?php
echo $_SESSION['ADMIN'];
	?>
</td>
</tr>
<tr>
<td>初始密码：</td>
<td><input type="password" name="old" id="old" onfocus="setStyle(this.id)" id="fname" onBlur="recoveryStyle(this.id)"></td>
<script language="javascript">
document.all.old.focus()
</script>
</tr>
<tr>
<td>新密码：</td>
<td><input type="password" name="newpass" id="newpass" onfocus="setStyle(this.id)" id="fname" onBlur="recoveryStyle(this.id)" onkeyup="chkpwd(this)"  style="height=25px;"></td>
</tr>
</tr>
<tr><td></td><td><div id="chkResult"></div> </td>
</tr>
<tr>
<td>确认密码：</td>
<td><input type="password" name="new1" id="new1" onfocus="setStyle(this.id)" id="fname" onBlur="recoveryStyle(this.id)"></td>
</tr>
<tr>
<td>&nbsp;<br><br><br></td>
<td><input type=submit name=submit id=submit value="更改密码">
<input type="reset" name="button" id="button" value="重新设置"></td>
</tr>
</table>
</form>

<p align="center"><font size="4" color="red"><br>注意：1、新密码必须为6-14位，且同时包含数字、字母及其它字符。<br><br>2、初始密码为您的学号。&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></p>



<?php
} else {
	echo "对不起，您无权限查看此页面！";
}

?>
