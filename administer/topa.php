<?php
session_start();
if (isset($_SESSION['ADMIN']) == TRUE) {

	?>
    <html>
    <head>
    <style>
    <!--
    body{
    margin:0px;
    padding:10px;
    filter:progid:DXImageTransform.microsoft.gradient(gradienttype=0,startColorStr=#F0DFBE,endColorStr=white);
    }
    -->
    </style>
    </head>
    <body>
    <p></p>
    </body>
    </html>
<?php
echo "<br><b>作业提交与发布系统</b><br><br>";
	echo "欢迎你,";
	echo $_SESSION['ADMIN'];
	echo "管理员! &nbsp;&nbsp;&nbsp;";
	echo '<font size=4><a style="text-decoration:none; color:#0000FF" href="/administer/quitADMIN.php" target="_parent">退出</a></font><br><br><br>';
} else {
	echo "对不起，您无权限查看此页面！";
}

?>
