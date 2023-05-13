<?php

//获取user
function sess_user(){
    session_start();
    $user=$_SESSION["user"];
    if(!empty($user)){
        return "1";
    }else{
        return "0";
    }
}

function time_c(){
    ini_set('date.timezone', 'Asia/Shanghai');
    $time=date('Y-m-d H:i:s', time());
    return $time;
}

//函数 传参操作
function operate($value){
    //多种单一操作，通过判断数字来选择多种操作

    //未登录评论
    if($value==0){
        $id=$_GET['id'];
        if(empty($_POST['name'])||empty($_POST['mail'])||empty($_POST['website'])||empty($_POST['content'])){
            echo "<script language='JavaScript' type='text/JavaScript'>;alert('有空未填');location.href='../page/link_$id.html';</script>";
        }else{
            $name=$_POST['name'];
            $mail=$_POST['mail'];
            $website=$_POST['website'];
            $content=$_POST['content'];
            include "../admin/data/conn.php";
            include "./sql.php";
            $prefix2=$prefix."comment";
            $result=sql_lj("SELECT * FROM `$prefix2` WHERE 1 order by id DESC","../admin/data/conn.php");
            $prefix2=$prefix."link";
            $result2=sql_lj("SELECT * FROM `$prefix2`  WHERE `id` = $id","../admin/data/conn.php");
            $row2 = mysqli_fetch_assoc($result2);
            $graded1=$row2['graded1'];
            $graded2=$row2['graded2'];
            // die($graded1.$graded2);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $id2=$row['id'];
                $id2++;
            }else{
                $id2=1;
            }
            $time=time_c();
            $prefix2=$prefix."comment";
            $result=sql_lj("INSERT INTO `$prefix2` (`id`, `graded1`, `graded2`, `articleid`, `user_name`, `name`, `mail`, `website`, `content`, `textlogo`, `time`, `state`) VALUES ('$id2', '$graded1', '$graded2', '$id', '0', '$name', '$mail', '$website', '$content', '0', '$time', '1');","../admin/data/conn.php");
            echo "<script language='JavaScript' type='text/JavaScript'>;alert('评论成功，审核后才能看见');location.href='../page/link_$id.html';</script>";
    
        }
    }else if($value==1){
        //登录评论
        $id=$_GET['id'];
        iflogin();
        session_start();
        $user=$_SESSION["user"];


        if(empty($_POST['content'])){
            echo "<script language='JavaScript' type='text/JavaScript'>;alert('有空未填');location.href='../page/link_$id.html';</script>";
        }else{
            $content=$_POST['content'];
            include "../admin/data/conn.php";
            include "./sql.php";
            $prefix2=$prefix."user";
            // die("SELECT * FROM `$prefix2` WHERE `user_name` LIKE '$user'");
            $result3=sql_lj("SELECT * FROM `$prefix2` WHERE `user_name` LIKE '$user'","../admin/data/conn.php");
            $row3 = mysqli_fetch_assoc($result3);
            $username=$row3['name'];
            $prefix2=$prefix."comment";
            $result=sql_lj("SELECT * FROM `$prefix2` WHERE 1 order by id DESC","../admin/data/conn.php");
            $prefix2=$prefix."link";
            $result2=sql_lj("SELECT * FROM `$prefix2`  WHERE `id` = $id","../admin/data/conn.php");
            $row2 = mysqli_fetch_assoc($result2);
            $graded1=$row2['graded1'];
            $graded2=$row2['graded2'];

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $id2=$row['id'];
                $id2++;
            }else{
                $id2=1;
            }
            $time=time_c();
            $prefix2=$prefix."comment";
            $result=sql_lj("INSERT INTO `$prefix2` (`id`, `graded1`, `graded2`, `articleid`, `user_name`, `name`, `mail`, `website`, `content`, `textlogo`, `time`, `state`) VALUES ('$id2', '$graded1', '$graded2', '$id', '$user', '$username', '', '', '$content', '0', '$time', '1');","../admin/data/conn.php");
            echo "<script language='JavaScript' type='text/JavaScript'>;alert('评论成功，审核后才能看见');location.href='../page/link_$id.html';</script>";
    
        }
    }
}

//常用判断是否登录
function iflogin(){
    session_start();
    if(empty($_SESSION["user"])) header("location:../index.php");
}
?>