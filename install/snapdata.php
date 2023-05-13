<?php
function snapdata($database_name_prefix,$database_name,$website_name,$website_keywords,$website_description,$username,$password,$mail){

$article=$database_name_prefix."article";
$comment=$database_name_prefix."comment";
$user=$database_name_prefix."user";
$set_up=$database_name_prefix."set_up";
$sort1=$database_name_prefix."sort1";
$sort2=$database_name_prefix."sort2";
$link=$database_name_prefix."link";
ini_set('date.timezone', 'Asia/Shanghai');
$time=date('Y-m-d H:i:s', time());
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    include "../function/sql.php";
     
    sql(<<<data
    CREATE TABLE `$link` (
        `id` int(11) NOT NULL COMMENT 'id',
        `graded1` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '一级分类',
        `graded2` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '二级分类',
        `webname` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT '网站名称',
        `link` text COLLATE utf8_unicode_ci NOT NULL COMMENT '链接',
        `icolink` text COLLATE utf8_unicode_ci NOT NULL COMMENT '图标链接',
        `website_describe` text COLLATE utf8_unicode_ci NOT NULL COMMENT '网站描述',
        `time` datetime NOT NULL COMMENT '添加时间',
        `calltime` datetime NOT NULL COMMENT '最近访问时间',
        `views` int(11) NOT NULL DEFAULT '0' COMMENT '访问量'
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    data);
    
    
    sql("INSERT INTO `$link` (`id`, `graded1`, `graded2`, `webname`, `link`, `icolink`, `website_describe`, `time`, `calltime`, `views`) VALUES
    (1, '默认分类', '默认', '归类阁着手', 'https://www.glgzs.com/', 'https://www.glgzs.com/favicon.ico', '导航网站', '$time', '$time', 1);");
    
     
    sql(<<<data
    CREATE TABLE `$set_up` (
    `keys` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '键',
    `value` text COLLATE utf8_unicode_ci NOT NULL COMMENT '值',
    `remark` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '注释'
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  data);

    sql(<<<data
    INSERT INTO `$set_up` (`keys`, `value`, `remark`) VALUES
    ('website_description', '$website_description', '网站描述'),
    ('website_name', '$website_name', '网站名称'),
    ('website_keywords', '$website_keywords', '网站关键词'),
    ('website_subtitle', '$website_name', '网站副标题');
    data);

    sql(<<<data
    CREATE TABLE `$sort1` (
    `id` int(11) NOT NULL COMMENT 'id',
    `graded1` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '一级分类',
    `time` datetime NOT NULL COMMENT '添加时间'
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  data);

    
    sql("INSERT INTO `$sort1` (`id`, `graded1`, `time`) VALUES
    (1, '默认分类', '$time');");
    
    sql(<<<data
    CREATE TABLE `$sort2` (
    `graded1` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '一级分类',
    `graded2` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '二级分类',
    `time` datetime NOT NULL COMMENT '添加时间'
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  data);

    sql("INSERT INTO `$sort2` (`graded1`, `graded2`, `time`) VALUES
    ('默认分类', '默认', '$time');");


    sql(<<<data
    CREATE TABLE `$user` (
      `id` int(11) NOT NULL COMMENT 'id',
      `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT '名称',
      `user_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
      `user_pass` varchar(500) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
      `mail` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT '邮箱',
      `grading` int(11) NOT NULL DEFAULT '0' COMMENT '分级0为普通用户1为管理2为超级管理员',
      `regist_time` datetime NOT NULL COMMENT '注册时间',
      `regist_ip` varchar(35) COLLATE utf8_unicode_ci NOT NULL COMMENT '注册IP',
      `login_time` datetime NOT NULL COMMENT '登录时间',
      `login_ip` varchar(35) COLLATE utf8_unicode_ci NOT NULL COMMENT '登录IP',
      `state` int(11) NOT NULL COMMENT '0为正常1为封禁'
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    data);

    sql("INSERT INTO `$user` (`id`, `user`, `user_name`, `user_pass`, `mail`, `grading`, `regist_time`, `regist_ip`, `login_time`, `login_ip`, `state`) VALUES
    ('1', '管理员', '$username', '$password', '$mail', '2', '$time', '$ip', '$time', '$ip', '0');");
    
    sql(<<<data
    CREATE TABLE `$article` (
      `id` int(11) NOT NULL COMMENT 'id',
      `user_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
      `title` int(30) NOT NULL COMMENT '文章标题',
      `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '文章内容',
      `time` datetime NOT NULL COMMENT '时间',
      `state` int(11) NOT NULL COMMENT '状态0为正常1为隐藏'
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    data);

    sql(<<<data
    CREATE TABLE `$comment` (
      `id` int(11) NOT NULL COMMENT 'id',
      `graded1` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '一级分类',
      `graded2` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '二级分类',
      `articleid` int(11) NOT NULL COMMENT '文章id',
      `user_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
      `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT '名称',
      `mail` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT '邮箱',
      `website` text COLLATE utf8_unicode_ci NOT NULL COMMENT '网站',
      `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
      `textlogo` int(11) NOT NULL COMMENT '0为link评论1为文章评论',
      `time` datetime NOT NULL COMMENT '时间',
      `state` int(11) NOT NULL COMMENT '状态0为正常1为隐藏'
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    data);
    
    sql("ALTER TABLE `$link` ADD PRIMARY KEY( `id`);");
    
    sql("ALTER TABLE `$set_up` ADD PRIMARY KEY( `keys`);");
    
    sql("ALTER TABLE `$sort1` ADD PRIMARY KEY( `id`);");
    
    sql("ALTER TABLE `$sort2` ADD PRIMARY KEY (`graded1`,`graded2`);");
    
    sql("ALTER TABLE `$user` ADD PRIMARY KEY( `id`);");
    
    sql("ALTER TABLE `$article` ADD PRIMARY KEY (`id`);");

    sql("ALTER TABLE `$comment` ADD PRIMARY KEY (`id`);");
}
?>