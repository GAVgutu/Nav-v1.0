<?php

//判空
function isorno($value){
    if(empty($value)){
        die("为空");
    }
}

//用户分级处理
function purview(){
    include "./data/conn.php";
    include "./../function/sql.php";
    $user_name=user_name();
    $prefix2=$prefix."user";
    $result=sql_lj("SELECT * FROM `$prefix2` WHERE `user_name` LIKE '$user_name'","./data/conn.php");
    if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_assoc($result);
        $grading=$row['grading'];
        echo $grading;
    }
}
// echo purview();

function time_c(){
    ini_set('date.timezone', 'Asia/Shanghai');
    $time=date('Y-m-d H:i:s', time());
    return $time;
}

//函数 传参操作
function operate($value){
    //多种单一操作，通过判断数字来选择多种操作

    //退出登录
    if($value==0){
        quit();
        echo "<script language='JavaScript' type='text/JavaScript'>;alert('退出成功！');location.href='../index.php';</script>";
    }else if($value==1){
        //一级分类 添加
        if(empty($_POST['graded1'])){
            echo "<script language='JavaScript' type='text/JavaScript'>;alert('添加内容为空');location.href='./page/classify.php';</script>";
        }else{
            $graded1=$_POST['graded1'];
            include "./data/conn.php";
            include "./../function/sql.php";
            $prefix2=$prefix."sort1";
            $result=sql_lj("SELECT * FROM `$prefix2` WHERE `graded1` LIKE '$graded1' ","./data/conn.php");
                if (mysqli_num_rows($result) > 0) {
                echo "<script language='JavaScript' type='text/JavaScript'>;alert('该一级分类已存在');location.href='./page/classify.php';</script>";
              }else{
                //   echo "还不存在";
                  $result=sql_lj("SELECT * FROM `$prefix2` WHERE 1 order by id DESC ","./data/conn.php");
                  if(mysqli_num_rows($result)>0){
                    $row = mysqli_fetch_assoc($result);
                    $id=$row['id'];
                    $id++;
                    }else{
                    $id=1;
                    }
                    $time=time_c();
                    sql_lj("INSERT INTO `glgzs_sort1` (`id`, `graded1`, `time`) VALUES ('$id', '$graded1', '$time');","./data/conn.php");
                    echo "<script language='JavaScript' type='text/JavaScript'>;alert('添加一级分类成功');location.href='./page/classify.php';</script>";
                  

              }
        }
    }else if($value==2){
        //二级分类 添加
        // echo $_POST['graded1'];
        // echo $_POST['graded2'];
        classify_sort2($_POST['graded1'],$_POST['graded2']);
    }else if($value==3){
        //删除一级分类
        $id= $_GET['id'];

        include "./data/conn.php";
        include "./../function/sql.php";
        $prefix2=$prefix."sort1";
        sql_lj("DELETE FROM `$prefix2` WHERE `$prefix2`.`id` = $id ","./data/conn.php");
        echo "<script language='JavaScript' type='text/JavaScript'>;alert('删除一级分类成功');location.href='./page/classify.php';</script>";
    }else if($value==4){
        //修改一级分类页面
        // include "../fun.php";
        iflogin();
        admin_head();
        admin_nav();
        admin_link_f("./page/main.php","./page/classify.php","./page/link.php","./page/article.php","./page/comment.php","./page/user.php","./page/modify.php");
        admin_content("modify_graded1");
        admin_footer();
        admin_end();
    }else if($value==5){
        //删除二级分类
        $graded1=$_GET['graded1'];
        $graded2=$_GET['graded2'];
        include "./data/conn.php";
        include "./../function/sql.php";
        $prefix2=$prefix."sort2";
        sql_lj("DELETE FROM `$prefix2` WHERE `$prefix2`.`graded1` = '$graded1' AND `$prefix2`.`graded2` = '$graded2';","./data/conn.php");
        echo "<script language='JavaScript' type='text/JavaScript'>;alert('删除一级分类成功');location.href='./page/classify.php';</script>";
    }else if($value==6){
        //修改二级分类页面
        // include "../fun.php";
        iflogin();
        admin_head();
        admin_nav();
        admin_link_f("./page/main.php","./page/classify.php","./page/link.php","./page/article.php","./page/comment.php","./page/user.php","./page/modify.php");
        admin_content("modify_graded2");
        admin_footer();
        admin_end();
    }else if($value==7){
        //一级分类修改处理
        classify_sort1_modify();
    }else if($value==8){
        //二级分类修改处理
        classify_sort2_modify();
    }else if($value==9){
        //添加link
        link_add();
    }else if($value==10){
        //删除链接
        link_delete();
    }else if($value==11){
        //修改链接页面
        iflogin();
        admin_head();
        admin_nav();
        admin_link_f("./page/main.php","./page/classify.php","./page/link.php","./page/article.php","./page/comment.php","./page/user.php","./page/modify.php");
        admin_content("modify_link");
        admin_footer();
        admin_end();
    }else if($value==12){
        //修改链接处理
        link_modify_link();
    }else if($value==13){
        //删除用户
    }else if($value==14){
        //修改用户
    }else if($value==15){
        //修改资料
        modify();
    }
}

//登录
function login($result,$user_name,$user_pass){
    if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_assoc($result);
        if(password_verify($user_pass,$row['user_pass'])){
            session_start();
            $_SESSION["user"]=$user_name;
            $user=$_SESSION["user"];
            echo "ok";
            header("location:./page/main.php");
            
            // header("location:main.php");//跳转到主页面
            // 获取ip和登录时间
            // $ip = $_SERVER['REMOTE_ADDR'];
            // date_default_timezone_set("Asia/Shanghai");
            // $dlriqi=date("Y-m-d H:i:s");
            // $sql = "UPDATE `user` SET `ip` = '$ip', `dlriqi` = '$dlriqi' WHERE `$prefix`.`user_name` = '$user'";
            // $result=mysqli_query($conn,$sql) or die("查询失败");/* die("插入失败".$sql); */
        }
        else{
            echo "<script language='JavaScript' type='text/JavaScript'>;alert('密码不正确');location.href='index.php';</script>";
        }
    }
    else{
        echo "<script language='JavaScript' type='text/JavaScript'>;alert('用户名不正确');location.href='index.php';</script>";
    }
}

//常用判断是否登录
function iflogin(){
    session_start();
    if(empty($_SESSION["user"])) header("location:../index.php");
}

//判断已登录跳转到后台
function ifloginadmin(){
    session_start();
    if(!empty($_SESSION["user"])){
        header("location:./page/main.php");
    }

}


//退出登录
function quit(){
    unset($_SESSION["user"]);
}

//用户名
function user_name(){
    return $_SESSION["user"];
    
}

//管理页面HTML代码分析
//admin head
function admin_head(){
    echo "<html lang=\"zh\">
	<head>
		<meta charset=\"utf-8\">
		<link rel=\"stylesheet\" type=\"text/css\" href=\"../../css/main.css\">
		<title>后台</title>
	</head>
	<body>\n";
}

//admin nav
function admin_nav(){
    $user_name=user_name();
    echo "<div id=\"nav\">
			<img src=\"../../image/glgzs.png\" alt=\"logo\">
			<ul>
				<li>账号：$user_name</li>
				<li><a href=\"#\">资料</a></li>
				<li><a href=\"../operate.php?value=0\">退出</a></li>
				<li><a href=\"../../index.php\">返回前台</a></li>
			</ul>
		</div>\n";
}

//admin link
function admin_link(){
    echo "<div id=\"link\">
    <ul>
        <li><a href=\"./main.php\">管理首页</a></li>
        <li><a href=\"./classify.php\">分类管理</a></li>
        <li><a href=\"./link.php\">链接管理</a></li>
        <li><a href=\"./article.php\">文章管理</a></li>
        <li><a href=\"./comment.php\">评论管理</a></li>
        <li><a href=\"./user.php\">用户管理</a></li>
        <li><a href=\"./modify.php\">修改资料</a></li>
    </ul>
</div>\n";
}
function admin_link_f($main,$classify,$link,$article,$comment,$user,$modify){
    echo "<div id=\"link\">
    <ul>
        <li><a href=\"$main\">管理首页</a></li>
        <li><a href=\"$classify\">分类管理</a></li>
        <li><a href=\"$link\">链接管理</a></li>
        <li><a href=\"$article\">文章管理</a></li>
        <li><a href=\"$comment\">评论管理</a></li>
        <li><a href=\"$user\">用户管理</a></li>
        <li><a href=\"$modify\">修改资料</a></li>
    </ul>
</div>\n";
}
//admin content
function admin_content($value){
    if($value=="main"){
        //首页
        page_main();
    }else if($value=="classify"){
        //分类管理
        page_classify();
    }else if($value=="link"){
        //链接管理
        page_link();
    }else if($value=="user"){
        //用户管理
        page_user();
    }else if($value=="modify"){
        //修改资料
        page_modify();
    }else if($value=="modify_graded1"){
        //修改一级分类
        page_modify_graded1();
    }else if($value=="modify_graded2"){
        //修改二级分类
        page_modify_graded2();
    }else if($value=="modify_link"){
        //修改链接
        page_modify_link();
    }
}

//admin footer
function admin_footer(){
    echo "<div id=\"footer\">
    <p>Copyright ©2020 归类阁着手 All Rights Reserved.</p>
</div>\n";
}

//admin end
function admin_end(){
    echo "	</body>
    </html>";
}

//页面主内容
        //首页
function page_main(){
    include "../data/conn.php";
    include "../../function/sql.php";
    //链接数量 一级分类数量 二级分类数量 用户数量
    $prefix2=$prefix."link";
    $result=sql_lj("SELECT count(*) from $prefix2","../data/conn.php");
    $row = mysqli_fetch_assoc($result);
    $link_count= $row['count(*)'];

    $prefix2=$prefix."sort1";
    $result=sql_lj("SELECT count(*) from $prefix2","../data/conn.php");
    $row = mysqli_fetch_assoc($result);
    $sort1_count= $row['count(*)'];

    $prefix2=$prefix."sort2";
    $result=sql_lj("SELECT count(*) from $prefix2","../data/conn.php");
    $row = mysqli_fetch_assoc($result);
    $sort2_count= $row['count(*)'];

    $prefix2=$prefix."user";
    $result=sql_lj("SELECT count(*) from $prefix2","../data/conn.php");
    $row = mysqli_fetch_assoc($result);
    $user_count= $row['count(*)'];
    echo "链接数量：".$link_count."<br>一级分类数量：".$sort1_count."<br>二级分类 数量：".$sort2_count."<br>用户数量".$user_count;
}
        //分类管理
function page_classify(){
    echo <<<text
    <form action="../operate.php?value=1" method="post">
    <input type="text" name="graded1" placeholder="一级分类" />
    <input type="submit"  value="添加" />
</form>
text;
include "../data/conn.php";
include "../../function/sql.php";
$prefix2=$prefix."sort1";
$result=sql_lj("SELECT * FROM `$prefix2` WHERE 1 order by id ","../data/conn.php");
  if (mysqli_num_rows($result) > 0) {
      echo ' <form action="../operate.php?value=2" method="post">
      <select name="graded1">';
    while ($row = mysqli_fetch_assoc($result)) {
        // $id= $row['id'];
        $graded1= $row['graded1'];
        echo "<option value =\"$graded1\">$graded1</option>";
    }
    echo '</select>
            <input type="text" name="graded2" placeholder="二级分类" />
            <input type="submit"  value="添加" />
        </form>';
    }
    //输出一级分类列表
    $result=sql_lj("SELECT * FROM `$prefix2` WHERE 1 order by id ","../data/conn.php");
    if (mysqli_num_rows($result) > 0) {    
    echo <<<text
    <table border="1">
    <tr>
        <th>ID</th>
        <th>一级分类</th>
        <th>时间</th>
        <th>操作</th>
    </tr>
    text;
    while ($row = mysqli_fetch_assoc($result)) {
        $id=$row['id'];
        $graded1=$row['graded1'];
        $time=$row['time'];
        echo "<tr>
        <td>$id</td>
        <td>$graded1</td>
        <td>$time</td>
            <td>
            <a href=\"../operate.php?value=4&id=$id&graded1=$graded1\">修改</a>|<a href=\"../operate.php?value=3&id=$id\">删除</a>
            </td>
    </tr>";
    }
    echo "</table>";
}

//切换数据库表
$prefix2=$prefix."sort2";
//输出二级分类列表
$result=sql_lj("SELECT * FROM `$prefix2` WHERE 1 order by graded1 ","../data/conn.php");
    if (mysqli_num_rows($result) > 0) {    
    echo <<<text
    <table border="1">
    <tr>
        <th>一级分类</th>
        <th>二级分类</th>
        <th>时间</th>
        <th>操作</th>
    </tr>
    text;
    while ($row = mysqli_fetch_assoc($result)) {
        $graded1=$row['graded1'];
        $graded2=$row['graded2'];
        $time=$row['time'];
        echo "<tr>
        <td>$graded1</td>
        <td>$graded2</td>
        <td>$time</td>
            <td><a href=\"../operate.php?value=6&graded1=$graded1&graded2=$graded2\">修改</a>|<a href=\"../operate.php?value=5&graded1=$graded1&graded2=$graded2\">删除</a></td>
    </tr>";
    }
    echo "</table>";
}
}
        //链接管理
function page_link(){
    include "../data/conn.php";
    include "../../function/sql.php";
    $prefix2=$prefix."sort1";
    $result=sql_lj("SELECT * FROM `$prefix2` WHERE 1  ","../data/conn.php");
    if (mysqli_num_rows($result) > 0) {
        $prefix2=$prefix."sort2";
        $result=sql_lj("SELECT * FROM `$prefix2` WHERE 1  ","../data/conn.php");
        if (mysqli_num_rows($result) > 0) {
                $prefix2=$prefix."sort1";
                $result=sql_lj("SELECT * FROM `$prefix2` WHERE 1 order by id ","../data/conn.php");
                if (mysqli_num_rows($result) > 0) {
                 echo ' <form action="../operate.php?value=9" method="post">
                   <select name="graded1">';
                  while ($row = mysqli_fetch_assoc($result)) {
                      $graded1= $row['graded1'];
                      echo "<option value =\"$graded1\">$graded1</option>";
                }
                echo '</select>';
            }
            $prefix2=$prefix."sort2";
            $result=sql_lj("SELECT * FROM `$prefix2` WHERE 1 ","../data/conn.php");
            if (mysqli_num_rows($result) > 0) {
             echo '<select name="graded2">';
              while ($row = mysqli_fetch_assoc($result)) {
                  $graded2= $row['graded2'];
                  echo "<option value =\"$graded2\">$graded2</option>";
            }
            echo '</select>
            <input type="text" name="webname" placeholder="网站名" />
            <input type="text" name="link" placeholder="链接" />
            <input type="text" name="icolink" placeholder="图标链接" />
            <input type="text" name="website_describe" placeholder="网站描述" />
            <input type="submit"  value="添加" />
            </form>';
            $prefix2=$prefix."link";

            $result=sql_lj("SELECT * FROM `$prefix2` WHERE 1 order by id DESC ","../data/conn.php");
                if (mysqli_num_rows($result) > 0) {    
                echo <<<text
                <table border="1">
                <tr>
                    <th>ID</th>
                    <th>一级分类</th>
                    <th>二级分类</th>
                    <th>网站名称</th>
                    <th>网站链接</th>
                    <th>图标链接</th>
                    <th>网站描述</th>
                    <th>添加时间</th>
                    <th>最近访问</th>
                    <th>访问量</th>
                    <th>操作</th>
                </tr>
                text;
                while ($row = mysqli_fetch_assoc($result)) {
                    $id=$row['id'];
                    $graded1=$row['graded1'];
                    $graded2=$row['graded2'];
                    $webname=$row['webname'];
                    $link=$row['link'];
                    $icolink=$row['icolink'];
                    $website_describe=$row['website_describe'];
                    $time=$row['time'];
                    $calltime=$row['calltime'];
                    $views=$row['views'];
                    echo "<tr>
                    <td>$id</td>
                    <td>$graded1</td>
                    <td>$graded2</td>
                    <td>$webname</td>
                    <td>$link</td>
                    <td>$icolink</td>
                    <td>$website_describe</td>
                    <td>$time</td>
                    <td>$calltime</td>
                    <td>$views</td>
                    <td><a href=\"../operate.php?value=11&id=$id\">修改</a>|<a href=\"../operate.php?value=10&id=$id\">删除</a></td>
                    ";
                }
                echo "</table>";
            }
        }

        }else{
            echo "无二级分类";
        }
      }else {
          echo "无一级分类";
      }
}
        //用户管理
function page_user(){
    include "../data/conn.php";
    include "../../function/sql.php";
    $prefix2=$prefix."user";

    $result=sql_lj("SELECT * FROM `$prefix2` WHERE 1 order by id DESC ","../data/conn.php");
        if (mysqli_num_rows($result) > 0) {    
        echo <<<text
        <table border="1">
        <tr>
            <th>ID</th>
            <th>用户名</th>
            <th>邮箱</th>
            <th>权限(0为普通用户,   1为管理)</th>
            <th>注册时间</th>
            <th>最近登录时间</th>
            <th>操作</th>
        </tr>
        text;
        while ($row = mysqli_fetch_assoc($result)) {
            $id=$row['id'];
            $user_name=$row['user_name'];
            $mail=$row['mail'];
            $grading=$row['grading'];
            $regist_time=$row['regist_time'];
            $login_time=$row['login_time'];
            echo "<tr>
            <td>$id</td>
            <td>$user_name</td>
            <td>$mail</td>
            <td>$grading</td>
            <td>$regist_time</td>
            <td>$login_time</td>
            <td><a href=\"#\">修改</a>|<a href=\"#\">删除</a></td>
            ";
        }
        echo "</table>";
    }
}
        //修改资料
function page_modify(){
    include "../data/conn.php";
    include "../../function/sql.php";
    $prefix2=$prefix."user";
    $user_name=user_name();

    $result=sql_lj("SELECT * FROM `$prefix2` WHERE `user_name` LIKE '$user_name' ","../data/conn.php");
        if (mysqli_num_rows($result) > 0) {    
        
        while ($row = mysqli_fetch_assoc($result)) {
            $id=$row['id'];
            $mail=$row['mail'];
            echo "<form action=\"../operate.php?value=15&id=$id\" method=\"post\">
            <input type=\"text\" name=\"mail\" value=\"$mail\" />
            <input type=\"submit\" value=\"修改\" />
        </form>";
        }
        echo "</table>";
    }
}
        //一级分类修改
function page_modify_graded1(){
    $id=$_GET['id'];
    $graded1=$_GET['graded1'];
    echo "<form action=\"./operate.php?value=7&id=$id\" method=\"post\">
    <input type=\"text\" name=\"graded1\" value=\"$graded1\" />
    <input type=\"submit\" value=\"修改\" />
</form>";
}
        //二级分类修改
function page_modify_graded2(){
    $graded1=$_GET['graded1'];
    $graded2=$_GET['graded2'];
    echo "<form action=\"./operate.php?value=8&graded1=$graded1&graded2=$graded2\" method=\"post\">
    <input type=\"text\" name=\"graded2\" value=\"$graded2\" />
    <input type=\"submit\" value=\"修改\" />
</form>";
}

        //修改链接
function page_modify_link(){
    $id=$_GET['id'];
    include "./data/conn.php";
    include "./../function/sql.php";
    $prefix2=$prefix."link";
    $result=sql_lj("SELECT * FROM `$prefix2` WHERE `id` = $id","./data/conn.php");
    if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $webname=$row['webname'];
    $link=$row['link'];
    $icolink=$row['icolink'];
    $website_describe=$row['website_describe'];
    // echo $graded1.$graded2.$webname.$link.$icolink.$website_describe;
    echo "<form action=\"./operate.php?value=12&id=$id\" method=\"post\">
    <input type=\"text\" name=\"webname\" value=\"$webname\" />
    <input type=\"text\" name=\"link\" value=\"$link\" />
    <input type=\"text\" name=\"icolink\" value=\"$icolink\" />
    <input type=\"text\" name=\"website_describe\" value=\"$website_describe\" />
    <input type=\"submit\" value=\"修改\" />
</form>";
    }
}

//页面处理
//二级分类添加处理
function classify_sort2($graded1,$graded2){
    if($graded2==""){
        echo "<script language='JavaScript' type='text/JavaScript'>;alert('添加内容为空');location.href='./page/classify.php';</script>";
    }else{
        include "./data/conn.php";
        include "./../function/sql.php";
        $prefix2=$prefix."sort2";
        $result=sql_lj("SELECT * FROM `$prefix2` WHERE `graded1` LIKE '$graded1' AND `graded2` LIKE '$graded2' ","./data/conn.php");
            if (mysqli_num_rows($result) > 0) {
            echo "<script language='JavaScript' type='text/JavaScript'>;alert('该二级分类已存在');location.href='./page/classify.php';</script>";
          }else{
            echo "还不存在";
            $time=time_c();
            sql_lj("INSERT INTO `glgzs_sort2` (`graded1`, `graded2`, `time`) VALUES ('$graded1', '$graded2', '$time');","./data/conn.php");
            echo "<script language='JavaScript' type='text/JavaScript'>;alert('添加二级分类成功');location.href='./page/classify.php';</script>";
          }
    }
}

//一级分类修改处理
function classify_sort1_modify(){
    $id=$_GET['id'];
    $graded1=$_POST['graded1'];
    include "./data/conn.php";
    include "./../function/sql.php";
    $prefix2=$prefix."sort1";
    $result=sql_lj("UPDATE `$prefix2` SET `graded1` = '$graded1' WHERE `$prefix2`.`id` = $id; ","./data/conn.php");
    echo "<script language='JavaScript' type='text/JavaScript'>;alert('修改一级分类成功');location.href='./page/classify.php';</script>";

}
//二级分类修改处理
function classify_sort2_modify(){
    $graded1=$_GET['graded1'];
    $graded2=$_GET['graded2'];
    $graded_post=$_POST['graded2'];
    // die($graded2.$graded_post);
    include "./data/conn.php";
    include "./../function/sql.php";
    $prefix2=$prefix."sort2";
    $result=sql_lj("UPDATE `$prefix2` SET `graded2` = '$graded_post' WHERE `$prefix2`.`graded1` = '$graded1' AND `$prefix2`.`graded2` = '$graded2'; ","./data/conn.php");
    echo "<script language='JavaScript' type='text/JavaScript'>;alert('修改二级分类成功');location.href='./page/classify.php';</script>";

}

//链接添加处理
function link_add(){
    include "./data/conn.php";
    include "./../function/sql.php";
    $graded1=$_POST['graded1'];
    $graded2=$_POST['graded2'];
    $webname=$_POST['webname'];
    $link=$_POST['link'];
    $icolink=$_POST['icolink'];
    $website_describe=$_POST['website_describe'];
    // echo $graded1.$graded2.$webname.$link.$icolink.$website_describe;
    $prefix2=$prefix."link";
    $result=sql_lj("SELECT * FROM `$prefix2` WHERE `webname` LIKE '$webname'","./data/conn.php");
    if (mysqli_num_rows($result) > 0) {
        echo "<script language='JavaScript' type='text/JavaScript'>;alert('已存在该网站名称');location.href='./page/link.php';</script>";
    }else{
        $result=sql_lj("SELECT * FROM `$prefix2` WHERE 1 order by id DESC ","./data/conn.php");
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $id=$row['id'];
            $id++;
        }else{
            $id=1;
        }
            $time=time_c();
            sql_lj("INSERT INTO `$prefix2` (`id`, `graded1`, `graded2`, `webname`, `link`, `icolink`, `website_describe`, `time`, `calltime`, `views`) VALUES ('$id', '$graded1', '$graded2', '$webname', '$link', '$icolink', '$website_describe', '$time', '$time', '0'); ","./data/conn.php");
            echo "<script language='JavaScript' type='text/JavaScript'>;alert('添加链接成功');location.href='./page/link.php';</script>";
    }
}

//删除链接处理
function link_delete(){
    $id=$_GET['id'];
    // DELETE FROM `glgzs_link` WHERE `glgzs_link`.`id` = 2
    include "./data/conn.php";
    include "./../function/sql.php";
    $prefix2=$prefix."link";
    sql_lj("DELETE FROM `$prefix2` WHERE `$prefix2`.`id` = $id","./data/conn.php");
    echo "<script language='JavaScript' type='text/JavaScript'>;alert('删除链接成功');location.href='./page/link.php';</script>";
}

//修改链接处理
function link_modify_link(){
    $id=$_GET['id'];
    $webname=$_POST['webname'];
    $link=$_POST['link'];
    $icolink=$_POST['icolink'];
    $website_describe=$_POST['website_describe'];
    include "./data/conn.php";
    include "./../function/sql.php";
    $prefix2=$prefix."link";
    sql_lj("UPDATE `$prefix2` SET `webname` = '$webname', `link` = '$link', `icolink` = '$icolink', `website_describe` = '$website_describe' WHERE `$prefix2`.`id` = $id;","./data/conn.php");
    echo "<script language='JavaScript' type='text/JavaScript'>;alert('修改链接成功');location.href='./page/link.php';</script>";
}

function modify(){
    $id=$_GET['id'];
    $mail=$_POST['mail'];
    include "./data/conn.php";
    include "./../function/sql.php";
    $prefix2=$prefix."user";
    sql_lj("UPDATE `$prefix2` SET `mail` = '$mail' WHERE `$prefix2`.`id` = $id;","./data/conn.php");
    echo "<script language='JavaScript' type='text/JavaScript'>;alert('修改资料成功');location.href='./page/modify.php';</script>";
}

//用户分级处理
function scope(){

}
?>