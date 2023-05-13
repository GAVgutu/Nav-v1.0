<?php



function main(){
    echo '
    <!DOCTYPE html>
    <html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="./css/style.css">
		<link rel="shortcut icon" href="./image/logo.png" type="image/x-icon" />
		<meta name="keywords" content="归类阁着手，GLGZS，归类，分类，资源，创意，个人博客，博客，网站展示，独立页面，网站站点，收录"/>
		<meta name="description" content="归类阁着手，是一款致力于互联网的资源整合收录，分类与归类，让大家使用时感受到方便快捷，简洁清晰。同时感谢大家的使用！">
		<title>归类阁着手</title>
	</head>
	<body>
	<iframe title="api" frameborder="no" border="0" marginwidth="0" marginheight="0" width="0" height="0" src="https://tongji.wlwnw.com/api/tj.php?key=6208eb8942e49"></iframe>
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
    link_list();
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
    include "./function/sql.php";
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
            echo "<p><a href=\"#sort1_$graded2\">$graded2</a></p>";
        }
    echo "</div>";
}else{
    echo "暂无分类";
}
    }
    echo "</ul>";
}else{
    echo "暂无分类";
}
}

//获取链接
function link_list(){
    include "./admin/data/conn.php";
    $prefix2=$prefix."sort1";
    $result=sql_lj("SELECT * FROM `$prefix2` WHERE 1 order by id  ","./admin/data/conn.php");
      if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id=$row['id'];
        $graded1=$row['graded1'];
        echo "<h3 id=\"sort1_$id\">$graded1</h3>";
        $prefix2=$prefix."sort2";
        $result2=sql_lj("SELECT * FROM `$prefix2` WHERE `graded1` LIKE '$graded1'  ORDER BY `$prefix2`.`time` ASC ","./admin/data/conn.php");
          if (mysqli_num_rows($result2) > 0) {
        while ($row = mysqli_fetch_assoc($result2)) {
            $graded2=$row['graded2'];
            echo "<h4 id=\"sort1_$graded2\" class=\"contentid\" >$graded2</h4>";
            $prefix2=$prefix."link";
        $result3=sql_lj("SELECT * FROM `$prefix2` WHERE `graded1` LIKE '$graded1' AND `graded2` LIKE '$graded2'","./admin/data/conn.php");
          if (mysqli_num_rows($result3) > 0) {
              echo "<div class=\"right_sort1\">";
        while ($row = mysqli_fetch_assoc($result3)) {
            $id=$row['id'];
            $webname=$row['webname'];
            $link=$row['link'];
            $icolink=$row['icolink'];
            $website_describe=$row['website_describe'];
            echo "<div class=\"a_list\">
            <a href=\"./page/link_$id.html\" class=\"a_style\" target=\"_blank\">
            <img src=\"$icolink\" onerror=\"this.src='./image/null.png';\" alt=\"学吧导航\">
            <h5>$webname</h5>
            <p>$website_describe</p>
        </a>
        <a href=\"$link\" class=\"direct\" target=\"_blank\">></a>
		</div>";
        }
    echo "</div>";
}else{
    echo "<p>暂无链接</p>";
}
            
        }
        }  
    }
    echo "</div><br>";
}

}

?>