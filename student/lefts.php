<?php
session_start();
if (isset($_SESSION['STUDEN']) == TRUE) {
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
    width:200px;
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
    width:190px;
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
    <a href="contents.php" target="frmmain">> 首页</a>
    <a href="mima/gaimimas.php" target="frmmain">> 修改密码</a>
    <a href="LogView.php" target="frmmain">> 查看日志</a>
    </div>
    <div>
    <span>作业信息</span>
    <a href="mycourse/mycourse.php" target="frmmain">> 我的课程</a>
    <a href="shomework/showhomeworkstude.php" target="frmmain">> 查看已布置作业</a>
    <a href="shomework/tijiaozuoye.php" target="frmmain">> 提交作业</a>
    <a href="shomework/showuploadstude.php" target="frmmain">> 查看已提交作业</a>
    <a href="shomework/showanswerstude.php" target="frmmain">> 查看课件或作业答案</a>
    </div>
    </div>
    </body>
    </html>

<?php

} else {
	echo "对不起，您无权限查看此页面！";
}

?>
