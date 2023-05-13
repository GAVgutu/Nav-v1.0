<?php

function sql($sql){
    include "../admin/data/conn.php";
    $result=mysqli_query($conn,$sql) or die("执行失败".mysqli_error($conn));
    return $result;
}

function sql_lj($sql,$lj){
    include "$lj";
    $result=mysqli_query($conn,$sql) or die("执行失败".mysqli_error($conn));
    return $result;
}


?>