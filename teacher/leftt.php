<?php
session_start();
if (isset($_SESSION['TEACH']) == TRUE) {
	?>
    <html>
    <head>
    <script type="text/javascript">
    var myMenu;
    window.onload = function() {
    myMenu = new SDMenu("my_menu");
    myMenu.init();
    };
    </script>

    <style type="text/css">
    html,body{
    height:100%;
    margin:0;
    font-size:16px;
    }
    span{
    background:#F0DFBE;
    border:1px solid #ffffff;
    border-left:5px solid #F2A31B;
    width:240px;
    height:28px;
    display:block;
    line-height:23px;
    padding-left:20px;
    }
     a{
    padding:3px 0 3px 30px;
    display:block;
    color:#636363;
    }
    #my_menu{
    width:210px;
    background:#F7F2E4;
    height:100%;
    }
    div.sdmenu div.collapsed {
    height: 25px;
    }
    div.sdmenu div{
    overflow: hidden;
    }

a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration:underline;
	color:orange;
}
a:active {
	text-decoration: none;
        color:orange;
}
    </style>
   <style>
<!--
BODY{
scrollbar-face-color:#F0DFBE;
scrollbar-arrow-color:#F2A31B;
scrollbar-track-color: #f2f2f2;
scrollbar-highlight-color: #e9e9e9;
scrollbar-3dlight-color: #F7F2E4;
scrollbar-darkshadow-Color:white;
}
-->
</style>
    <script>
    function SDMenu(id) {
    if (!document.getElementById || !document.getElementsByTagName)
    return false;
    this.menu = document.getElementById(id);
    this.submenus = this.menu.getElementsByTagName("div");
    this.remember = true;
    this.speed = 1;
    this.markCurrent = true;
    this.oneSmOnly = false;
    }
    SDMenu.prototype.init = function() {
    var mainInstance = this;
    for (var i = 0; i < this.submenus.length; i++)
    this.submenus[i].getElementsByTagName("span")[0].onclick = function() {
    mainInstance.toggleMenu(this.parentNode);
    };
    if (this.markCurrent) {
    var links = this.menu.getElementsByTagName("a");
    for (var i = 0; i < links.length; i++)
    if (links[i].href == document.location.href) {
    links[i].className = "current";
    break;
    }
    }
    if (this.remember) {
    var regex = new RegExp("sdmenu_" + encodeURIComponent(this.menu.id) + "=([01]+)");
    var match = regex.exec(document.cookie);
    if (match) {
    var states = match[1].split("");
    for (var i = 0; i < states.length; i++)
    this.submenus[i].className = (states[i] == 0 ? "collapsed" : "");
    }
    }
    };
    SDMenu.prototype.toggleMenu = function(submenu) {
    if (submenu.className == "collapsed")
    this.expandMenu(submenu);
    else
    this.collapseMenu(submenu);
    };
    SDMenu.prototype.expandMenu = function(submenu) {
    var fullHeight = submenu.getElementsByTagName("span")[0].offsetHeight;
    var links = submenu.getElementsByTagName("a");
    for (var i = 0; i < links.length; i++)
    fullHeight += links[i].offsetHeight;
    var moveBy = Math.round(this.speed * links.length);
    var mainInstance = this;
    var intId = setInterval(function() {
    var curHeight = submenu.offsetHeight;
    var newHeight = curHeight + moveBy;
    if (newHeight < fullHeight)
    submenu.style.height = newHeight + "px";
    else {
    clearInterval(intId);
    submenu.style.height = "";
    submenu.className = "";
    mainInstance.memorize();
    }
    }, 30);
    this.collapseOthers(submenu);
    };
    SDMenu.prototype.collapseMenu = function(submenu) {
    var minHeight = submenu.getElementsByTagName("span")[0].offsetHeight;
    var moveBy = Math.round(this.speed * submenu.getElementsByTagName("a").length);
    var mainInstance = this;
    var intId = setInterval(function() {
    var curHeight = submenu.offsetHeight;
    var newHeight = curHeight - moveBy;
    if (newHeight > minHeight)
    submenu.style.height = newHeight + "px";
    else {
    clearInterval(intId);
    submenu.style.height = "";
    submenu.className = "collapsed";
    mainInstance.memorize();
    }
    }, 30);
    };
    SDMenu.prototype.collapseOthers = function(submenu) {
    if (this.oneSmOnly) {
    for (var i = 0; i < this.submenus.length; i++)
    if (this.submenus[i] != submenu && this.submenus[i].className != "collapsed")
    this.collapseMenu(this.submenus[i]);
    }
    };
    SDMenu.prototype.memorize = function() {
    if (this.remember) {
    var states = new Array();
    for (var i = 0; i < this.submenus.length; i++)
    states.push(this.submenus[i].className == "collapsed" ? 0 : 1);
    var d = new Date();
    d.setTime(d.getTime() + (30 * 24 * 60 * 60 * 1000));
    document.cookie = "sdmenu_" + encodeURIComponent(this.menu.id) + "=" + states.join("") + "; expires=" + d.toGMTString() + "; path=/";
    }
    };
    </script>
    </head>
    <body>
    <div style="float:left" id="my_menu" class="sdmenu">
    <div>
    <span> 个人信息</span>
    <a href="contentt.php" target="frmmain">> 首页</a>
    <a href="/teacher/mima/gaimimat.php" target="frmmain">> 修改密码</a>
    </div>
    <div>
    <span>课程信息管理</span>
    <a href="changestudent/mycourse.php" target="frmmain">> 我的课程</a>
    <a href="changestudent/pladdstudent.php" target="frmmain">> 批量导入课程信息</a>
    <a href="changestudent/changestudent.php" target="frmmain">> 个别学生信息管理</a>
    <a href="/teacher/managercontrol/scanmanager.php" target="frmmain">> 管理员管理</a>
    <a href="/teacher/mima/mimachongzhi.php" target="frmmain">> 为学生重置密码</a>
    </div>
    <div>
    <span> 作业信息管理</span>
    <a href="thomework/buzhizuoye.php" target="frmmain">> 导入作业信息</a>
    <a href="thomework/showhomeworkteach.php" target="frmmain" >> 查看和删除布置的作业</a>
    <a href="thomework/showuploadteach.php" target="frmmain" >> 全体学生作业上交情况</a>
    <a href="thomework/showupload2teach.php" target="frmmain" >> 个别学生作业上交详情</a>
    <a href="pigaizuoye/pigaiyemian.php" target="frmmain" >> 查看和批改上交的作业</a>
    <a href="thomework/ckguest.php" target="frmmain" >> 查看学生作业反馈信息</a>
    <a href="thomework/upanswer.php" target="frmmain" >> 发布课件或作业答案</a>
    <a href="thomework/showanswerteach.php" target="frmmain" >> 课件及作业答案管理</a>
    </div>
    </div>
    </body>
    </html>

<?php

} else {
	echo "对不起，您无权限查看此页面！";
}

?>
