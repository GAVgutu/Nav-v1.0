<?php
include "./fun.php";
include "./data/conn.php";
include "../function/sql.php";
ifloginadmin();
isorno($_POST['user_name']);
isorno($_POST['user_pass']);
$user_name=$_POST['user_name'];
$user_pass=$_POST['user_pass'];
$prefix=$prefix."user";
$result=sql("select * from $prefix where user_name='$user_name'");
login($result,$user_name,$user_pass);
?>