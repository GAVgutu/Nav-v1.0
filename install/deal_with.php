<?php
//安装初始化处理
if(empty($_POST['database_address'])||empty($_POST['database_port'])||empty($_POST['database_username'])||empty($_POST['database_pass'])||empty($_POST['database_name'])||empty($_POST['database_name_prefix'])||empty($_POST['website_name'])||empty($_POST['website_keywords'])||empty($_POST['website_description'])||empty($_POST['username'])||empty($_POST['password'])||empty($_POST['mail'])){
    echo "输入框有空";
}else{
    $conn=mysqli_connect($_POST['database_address'],$_POST['database_username'],$_POST['database_pass'],$_POST['database_name']) or die("数据库连接失败");
    
    mysqli_query($conn,'set names utf8');
   
    $database_address=$_POST['database_address']; //数据库地址
    $database_port=$_POST['database_port']; //数据库端口
    $database_username=$_POST['database_username']; //数据库用户名
    $database_pass=$_POST['database_pass']; //数据库密码
    $database_name=$_POST['database_name']; //数据库名
    $database_name_prefix=$_POST['database_name_prefix'];//数据库表前缀
    $website_name=$_POST['website_name']; //网站名称
    $website_keywords=$_POST['website_keywords']; //网站关键词
    $website_description=$_POST['website_description']; //网站描述
    $username=$_POST['username']; //用户名
    $password=$_POST['password']; //密码
    $mail=$_POST['mail']; //邮件
    $password = password_hash($password,PASSWORD_BCRYPT);
    // die("$password");
    $file = fopen("../admin/data/conn.php", "w") or die("Unable to open file!");
    $txt = "<?php\n";
    fwrite($file, $txt);
    $txt="\$conn=mysqli_connect(\"$database_address\",\"$database_username\",\"$database_pass\",\"$database_name\",\"$database_port\") or die(\"数据库连接失败\");\n";
    fwrite($file, $txt);
    $txt="mysqli_query(\$conn,'set names utf8');\n\$prefix=\"$database_name_prefix\"";
    fwrite($file, $txt);
    $txt="?>";
    fwrite($file, $txt);
    fclose($file);
    //引用数据库快照
    require "./snapdata.php";
    require "../function/Base.php";
 

    snapdata($database_name_prefix,$database_name,$website_name,$website_keywords,$website_description,$username,$password,$mail);

    unlink("./index.php");
    unlink("./deal_with.php");
    unlink("./snapdata.php");
    $file = fopen("./index.php", "w") or die("Unable to open file!");
    $txt="已安装";
    fwrite($file, $txt);
    fclose($file);
    fhref("./index.php");

}


?>