<?php
include "./admin/data/conn.php";
include "./function/sql.php";
include "./function/fun.php";
define("NAME",sess_user());
function main(){
    echo '
    <!DOCTYPE html>
    <html>
  <html lang="zh">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<link rel="shortcut icon" href="../image/logo.png" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="../css/detailed.css"/>
		<title>归类阁着手</title>
	</head>
	<body>
		<div id="top">
			<img src="../image/glgzs.png" alt="logo">
			
			<ul>
				<li><a href="">热门链接</a></li>
				<li><a href="">热门链接</a></li>
				<li><a href="">关于</a></li>
				<a href="../admin/index.php">
					<img src="../image/user.png" >
				</a>
			</ul>
		</div>
		<div id="main">
			<div id="left">';
    sort_list();
    echo '</div>
    <div id="right">';
    link_cebter();
    echo '</div>
    <script type="text/javascript">
		
    changeMargin();
    //监听浏览器宽度的改变
    window.onresize = function(){
        changeMargin();
    };
    function changeMargin(){
        var kun=document.documentElement.clientWidth;
        var gao=document.documentElement.clientHeight;
        var left=document.getElementById("left");
        var right=document.getElementById("right");
        var main=document.getElementById("main");
        
        main.style.width=kun;
        left.style.height=+gao-50+"px";
        right.style.width=+kun-260+"px";
        right.style.height=+gao-50+"px";
    }
    
    var sort1=document.getElementsByClassName("sort1");
    var i;
    for(i = 0;i<sort1.length;i++){
        sort1[i].addEventListener("click",function(){
            this.classList.toggle("bac");
            var sort2 = this.nextElementSibling;
            if (sort2.style.maxHeight) {
              sort2.style.maxHeight = null;
            } else {
              sort2.style.maxHeight = sort2.scrollHeight + "px";
            } ;
        
        });
        }
		</script>
    ';
}


//获取分类列表
function sort_list(){
  include "./admin/data/conn.php";
  // include "./function/sql.php";
  $prefix2=$prefix."sort1";
  $result=sql_lj("SELECT * FROM `$prefix2` WHERE 1 order by id  ","./admin/data/conn.php");
    if (mysqli_num_rows($result) > 0) {
        echo "<ul id=\"graded1\">";
  while ($row = mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $graded1=$row['graded1'];
      echo "<a href=\"#sort1_$id\" class=\"sort1\">$graded1</a>";
      $prefix2=$prefix."sort2";
      $result2=sql_lj("SELECT * FROM `$prefix2` WHERE `graded1` LIKE '$graded1'  ORDER BY `$prefix2`.`time` ASC ","./admin/data/conn.php");
        if (mysqli_num_rows($result2) > 0) {
            echo "<div class=\"sort2\">";
      while ($row = mysqli_fetch_assoc($result2)) {
          $graded2=$row['graded2'];
          echo "<p><a href=\"../#sort1_$graded2\">$graded2</a></p>";
      }
  echo "</div>";
}else{
  echo "暂无信息";
}
  }
  echo "</ul>";
}else{
  echo "暂无信息";
}
}
function link_cebter(){
  include "./admin/data/conn.php";

$id=$_GET['id'];
  $prefix2=$prefix."link";
  $result=sql_lj("SELECT * FROM `$prefix2` WHERE `id` = '$id'","./admin/data/conn.php");
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
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
    // echo $graded1.$graded2.$webname.$link.$icolink.$website_describe;
    echo "<div id=\"right_box\">
    <div id=\"right_center\">
      <img src=\"$icolink\" onerror=\"this.src='../image/null.png';\" >
      <div id=\"right_title\">
        <span>$webname</span>
        <a href=\"$link\" target=\"_blank\">直接打开</a> | <a href=\"#\" class=\"qr_code\">手机查看<img src=\"../image/null.png\" onerror=\"this.src='../image/null.png';\" ></a>
      </div>
    </div>
    <div id=\"right_top\">
      <span>描述：</span>
      <p>$website_describe</p>
    </div>
    <div id=\"right_bot\">
      <span>相关推荐：</span>
      <div class=\"right_sort1\">
        ";
      their_rec($id);
      echo "</div>
    </div>";
  //评论
  Comment();
  
  //评论列表
  Comment_list();
  echo "</div>";
  
  
  }else{
      echo "<p class=\"hint404\">404</p>";
  }
}

//相关推荐
function their_rec($id){
  include "./admin/data/conn.php";
  $prefix2=$prefix."link";
  $result=sql_lj("SELECT * FROM `$prefix2` WHERE `id` = $id  ","./admin/data/conn.php");
  $row = mysqli_fetch_assoc($result);
  $graded1=$row['graded1'];
  $graded2=$row['graded2'];
  $result2=sql_lj("SELECT * FROM `$prefix2` WHERE `graded1` LIKE '$graded1' AND `graded2` LIKE '$graded2' order by id ","./admin/data/conn.php");
    if (mysqli_num_rows($result2) > 0) {
        // echo "<h1>";
    $i=1;
    
  while ($row2 = mysqli_fetch_assoc($result2)) {
            $id2=$row2['id'];
            $webname=$row2['webname'];
            $link=$row2['link'];
            $icolink=$row2['icolink'];
            $website_describe=$row2['website_describe'];
            
    if($i<=14&&$id2!=$id){
      echo "<div class=\"a_list\">
            <a href=\"./link_$id2.html\" class=\"a_style\" target=\"_blank\">
            <img src=\"$icolink\" onerror=\"this.src='../image/null.png';\" alt=\"学吧导航\">
            <h5>$webname</h5>
            <p>$website_describe</p>
        </a>
        <a href=\"$link\" class=\"direct\" target=\"_blank\">></a>
		</div>";
    }
    $i++;

    }
  }else{
    echo "暂无信息";
}
}

function Comment(){
  $user=NAME;
  $id=$_GET['id'];
  echo "<p style=\"margin-left: 30px\">*评论需审核后才能展示</p>";
  if($user=="1"){
    echo "<div class=\"Comment\">
    <form action=\"../function/operate.php?value=1&id=$id&textlogo=0\" method=\"post\">
      <textarea name=\"content\" placeholder=\"内容\" rows=\"6\" cols=\"70\" /></textarea>
      <br />
      <input class=\"submit\" type=\"submit\" value=\"提交\" />
    </form>
  </div>";
  }else{
    echo "<div class=\"Comment\">
    <form action=\"../function/operate.php?value=0&id=$id&textlogo=0\" method=\"post\">
      <input type=\"text\" name=\"name\" placeholder=\"名称：\" />
      <input type=\"email\" name=\"mail\" placeholder=\"邮箱：\" />
      <input type=\"text\" name=\"website\" placeholder=\"网站：\"/>
      <br />
      <textarea name=\"content\" placeholder=\"内容\" rows=\"6\" cols=\"70\" /></textarea>
      <br />
      <input class=\"submit\" type=\"submit\" value=\"提交\" />
    </form>
  </div>";
  }
}

function Comment_list(){
  $id=$_GET['id'];

  include "./admin/data/conn.php";
  //获取分类
  $prefix2=$prefix."link";
  $result=sql_lj("SELECT * FROM `$prefix2` WHERE `id` = $id  ","./admin/data/conn.php");
  $row = mysqli_fetch_assoc($result);
  $graded1=$row['graded1'];
  $graded2=$row['graded2'];

  $prefix2=$prefix."comment";
  $result=sql_lj("SELECT * FROM `$prefix2` WHERE `graded1` LIKE '$graded1' AND `graded2` LIKE '$graded2' AND `articleid` = $id AND `textlogo` = 0 AND `state` = 0 ORDER BY `id` DESC","./admin/data/conn.php");
  if (mysqli_num_rows($result) > 0) {
    echo "<!-- 评论列表 -->";
    
  while ($row = mysqli_fetch_assoc($result)) {
    $name=$row['name'];
    $website=$row['website'];
    $content=$row['content'];
    $time=$row['time'];
    echo "<div class=\"Commentlist\">
    <div class=\"Comm_left\">
      <img src=\"../image/user.png\" >
    </div>
    <div class=\"Comm_right\">";
      echo "<a href=\"$website\" target=\"_blank\"><span>$name</span></a>";
      echo "<p class=\"Comm_right_p\">$content</p>
      <p class=\"Comm_right_time\">$time</p>
    </div>
  </div>
  <p>:</p>";
  }
}else{
  echo "<p style=\"margin-left: 30px\">暂无评论</p>";
}
}
  main();
?>