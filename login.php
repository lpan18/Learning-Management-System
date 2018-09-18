<html>

<head>
<meta http-equiv=content-type content="text/html;charset=utf-8">
<title>登录</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript">
//获得焦点输入背景设置为红色
function setStyle(x)
{
document.getElementById(x).style.background="#FFFFCC"
}
//失去焦点输入背景重置为白色
function recoveryStyle(y)
{
document.getElementById(y).style.background="White"
}
function check()
{
var l=document.all;
if(l.user.value=="")
{
alert("请输入用户名");
l.user.focus();
return false;
}
if(l.password.value=="")
{
alert("请输入用户密码");
l.password.focus();
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
var bImg="//192.168.1.230/mimajiance.gif" //一张显示用的图片
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
</head>

<body class="Login_bdWp">
<div class="Login_w">
<div class="Login_wIn">
<div class="Login_Head">
<h1 class="Logo"><a href="" target="_blank"><img src="logo.jpg"  /></a></h1>		</div>
<div class="Login_bg">
<div class="I_Style I_Style_1">
<div class="fmi_LgBx">
<div class="fmi_ACon " id="divACon">

<form id="form1" name="form1" action="record.php" method="post" onsubmit="return check()" >
<input type="hidden" name="username" id="txtUserName" value="" />
<fieldset class="fmi_LgBxWp">
<div class="fmi_LgBxCon">
<table border="0" cellspacing="0" cellpadding="0" class="LgBxLst_tb">
<tr >
<td><font size='3'>用 户</font></td>
<td width="300">&nbsp;
<input type="radio" name="radio" id="type" value=student  checked><font size='3'>普通学生</font>
<input type="radio" name="radio" id="type1" value=manager><font size='3'>学生管理员</font>
<input type="radio" name="radio" id="type2" value=teacher><font size='3'>教师</font></td>
</tr>
<tr>
<th nowrap><font size='3'>用户名</font></th>
<td width="200">&nbsp;<input type="text" id=user name=user style="width:190px;height:32px;" onfocus="setStyle(this.id)" onBlur="recoveryStyle(this.id)" style='font-size:20px'   >
<script language="javascript">
document.all.user.focus()
</script></td>
</tr>
<tr>
<th nowrap><font size='3'>密　码</font></th>
<td>&nbsp;<input type=password  id=password name=password style="width:190px;height:32px;" onfocus="setStyle(this.id)" onBlur="recoveryStyle(this.id)" style='font-size:20px'  ></td>								</tr>					<tr>
<th></th>
<td colspan="3" >&nbsp;<input id=submit type=submit value="登陆" name=submit style="height=35px;width=80px;"  style='font-size:20px'  ></td>
</tr>
<tr>
<th>&nbsp;</th>
<td colspan="3" nowrap class="Reg_Wp">											<span>&nbsp;&nbsp;<font color="red">温馨提示：若您是管理员，请从学生管理员账户登录！<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;如有疑问，请点击<b><a href="loginhelp.php" target="_blank" title="" tabindex="10">登陆帮助!</a></b></span>
</td>
</tr>
</table>
<div class="Error" id="divError"></div>
</div>
</fieldset>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>

