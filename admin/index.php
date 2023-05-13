<?php
include "./fun.php";
ifloginadmin();
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../../css/login.css">
    <title>后台登录</title>
</head>
<body>
    <div class="login">
        <img src="../../image/glgzs.png" alt="">
        <h1>登录</h1>
	    <form  method="post" action="./login.php">
        <span>用户名：</span><input type="text"  name="user_name" /><br>
        <span>密码：</span><input type="password" name="user_pass" /><br>
        <input class="submit" type="submit" value="登录"/>
	    </form>
    </div>
	
</body>
</html>