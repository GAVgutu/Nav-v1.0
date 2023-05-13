<?php

//判断文件是否存在状态，返回1则存在，返回0则不存在。
function if_file_state($file){
    if(file_exists($file)){
        return 1;
    }else{
        return 0;
    }
}

//引导页
function index(){

    $install_state=if_file_state("./admin/data/conn.php");
    if($install_state==1){
        //存在则已安装
        Installed();
    }else if($install_state==0){
        //不存在则未安装
        Not_Installed();
    }
    
}

//未安装
function Not_Installed(){
    fhref("./install/index.php");
}

//已安装
function Installed(){
    include "./function/main.php";
    main();
}


//网页跳转
function fhref($url){
    header("location:$url");
}

//output输出内容
function output($ct){
    echo "$ct";
}




?>