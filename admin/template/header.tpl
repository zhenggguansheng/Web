<?php
	require_once '../global.php';

	if(!isset($_SESSION['foradminuser']))
	{
		echo "<script language='javascript'>\n";
		echo "alert(\"请先登录！\");";
		echo 'parent.location.href = "../admin.php";';
		echo "</script>";
		exit;
	}
	$id = $_SESSION['foradminuser'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Nuist OnLine Judge System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/favicon.ico"/>
    <meta name="layout" content="main"/>
    <!--
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
	-->
    <script src="../include/js/jquery-2.0.3.min.js" type="text/javascript" ></script>
    <link href="../include/css/customize-template.css" type="text/css" media="screen, projection" rel="stylesheet" />
    <style>
        #body-content { padding-top: 40px;}
    </style>
</head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <div id="app-nav-top-bar" class="nav-collapse">
                         <ul class="nav">
							<li><a href="#">
								<?php $my_t=getdate(date("U")); print("$my_t[weekday], $my_t[month] $my_t[mday], $my_t[year]");?></a>
							</li>
 	                     </ul>
						 <ul class="nav pull-right">
							<li>
								<a href="#">Hello, 	<?php echo $id;?></a>
							</li>
							<li>
                                <a href="exit.php">Logout</a>
                            </li>
                         </ul>
                    </div>
                </div>
            </div>
        </div>

        <div id="body-container">
            <div id="body-content">
			   <div class="body-nav body-nav-horizontal body-nav">
					<div class="container">
						<ul>
							<li><a href="contest.php?id=1"    ><i class="icon-star  icon-large"></i>竞赛</a></li>
							<li><a href="exam.php?id=2"       ><i class="icon-road  icon-large"></i>考试</a></li>
							<li><a href="problemlist.php?id=3"><i class="icon-book  icon-large"></i>题库</a></li>
							<li><a href="course.php?id=4">     <i class="icon-tasks icon-large"></i>课程</a></li>
							<li><a href="manageruser.php">     <i class="icon-user  icon-large"></i>教师</a></li>
							<li><a href="news.php">            <i class="icon-comment icon-large"></i>公告</a></li>
							<!---<li><a href="putcolor.php?id=9">气球放置</a></li>
							//<li><a href="edituserinfo.php">个人账号</a></li>--->
							<li><a href="setstudentpsd.php">       <i class="icon-key icon-large"></i>学生信息</a></li>
						</ul>
					</div>
				</div>
				<section class="nav nav-page">
					<div class="container">
						<div class="row">
							<div class="span7">
								<header class="page-header">
									<h3>Nuist<br/>
										<small>OnLine Judge System</small>
									</h3>
								</header>
							</div>
							<div class="page-nav-options">
								<div class="span9">
									<ul class="nav nav-pills">
										<li>
											<a href="../index.php" target="_blank" title="前台首页"><i class="icon-search icon-large"></i>前端</a>
										</li>
									</ul>
									
									<ul class="nav nav-tabs">
										<li>
											<a href="admin.php"  title="后台首页"><i class="icon-home"></i>首页</a>
										</li>
										<!--
										<li class="active">
											<a href="#"><i class="icon-home"></i>Home</a>
										</li>
										<li><a href="#">Maps</a></li>
										<li><a href="#">Admin</a></li>
										-->
									</ul>
									
								</div>
							</div>
						</div>
					</div>
				</section>			
