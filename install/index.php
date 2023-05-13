<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
require "../function/Base.php";
 
output('连接数据库成功后，安装程序将被删除，如需重新安装请重新下载<br><br>');

output('<form action="deal_with.php" method="post">');
output('连接数据库：<br>');
output('<input type="text" placeholder="数据库地址" value="localhost" name="database_address">一般默认即可<br>');
output('<input type="text" placeholder="数据库端口" value="3306" name="database_port">一般默认即可，如果不正确请根据实际端口填写<br>');
output('<input type="text" placeholder="数据库用户名" name="database_username"><br>');
output('<input type="password" placeholder="数据库密码" name="database_pass"><br>');
output('<input type="text" placeholder="数据库名" name="database_name"><br>');
output('<input type="text" placeholder="数据库表前缀" value="Glgzs_" name="database_name_prefix"><br>');

output('设置网站信息<br>');
output('<input type="text" placeholder="网站名称" name="website_name"><br>');
output('<input type="text" placeholder="网站关键词" name="website_keywords"><br>');
output('<input type="text" placeholder="网站描述" name="website_description"><br>');

output('设置管理员信息<br>');
output('<input type="text" placeholder="用户名" value="admin" name="username"><br>');
output('<input type="password" placeholder="密码" name="password"><br>');
output('<input type="email" placeholder="邮箱" name="mail"><br>');
output('<input type="submit" name="submit" value="提交">');
output('</form>');


?>
</body>
</html>