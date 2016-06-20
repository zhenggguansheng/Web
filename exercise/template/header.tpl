<?php
	require_once '../global.php';
	if(isset($_SESSION['lang']))
	{
		$lang = $_SESSION['lang'];
	}
	else{$lang="cn";}
	require_once '../lang/'.$lang.'.php';
	$_SESSION['page'] = $_SERVER['REQUEST_URI'];
    $id = "";
    $mode = "";
	if(isset($_SESSION['user_name'])&&isset($_SESSION['uid']))
	{
		if (isset($_SESSION['power']))
		{
			$id = "Admin";
			$mode ='当前状态:检查模式';
		}else
		{
			$id = $_SESSION['user_name'];
			$mode ='当前状态:练习模式';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
    <title>NUISTOJ-南京信息工程大学在线评测系统</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="layout" content="main"/>
	<link rel="shortcut icon" href="../images/favicon.ico"/>
	<script src="include/js/showo_page.js"></script>
    <script src="include/js/jquery/jquery-1.8.2.min.js" type="text/javascript" ></script>
    <link href="include/css/customize-template.css" type="text/css" media="screen, projection" rel="stylesheet" />
<!--    <link href="include/css/min.css" rel="stylesheet">  -->

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
                           <li><!--<a href="#">Hello,<?php echo $id;?></a>  -->
								<?php if (!empty($id) && !isset($_SESSION['power'])) 
									  {
											if (!isset($_SESSION['suser_name']))
											     $_SESSION['suser_name'] = $id;
											$_SESSION['suser_name'] = $id;
											echo '<a href="../changepass.php?m_user='.$id.'">Hello,'.$id.'</a>';
									  }
									  else
										  echo '<a href="#">Hello,'.$id.'</a>';
								?>
							</li>
                            <li><a href="#">
								<?php echo $mode;?></a>
							</li>

                        </ul>
 						<ul class="nav pull-right">
                            <li>
                                <a href="login.php">Login</a>
                            </li>
							<li>
                                <a href="../exit.php">Logout</a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
       <div id="body-container">
            <div id="body-content">
                <div class="body-nav body-nav-horizontal body-nav-fixed">
                     <div class="container">
                         <ul>
 							<li><a href="../index.php"><i class="icon-home icon-large"></i> <?php echo $MSG_Home;?></a></li>
							<li><a href="../F.A.Qs.php"><i class="icon-question-sign icon-large"></i> <?php echo $MSG_FAQS;?></a></li>
							<li><a href="problemlist.php"><i class="icon-list icon-large"></i> <?php echo $MSG_Problems;?></a></li>
							<li><a href="status.php"><i class="icon-pencil icon-large"></i> <?php echo $MSG_Status;?></a></li>
							<li><a href="ranklist.php"><i class="icon-info-sign icon-large"></i> <?php echo $MSG_Ranklist;?></a></li>
							<li><a href="#"><i class="icon-list-alt icon-large"></i><?php echo $MSG_Forum;?></a></li>
							<li><a href="#"><i class="icon-bar-chart icon-large"></i> <?php echo $MSG_About?></a></li>
						 </ul>
                     </div>
                </div>
                
				<section class="nav nav-page">
					<div class="container">
						<div class="row">
							<div class="span7">
								<header class="page-header">
									<h3>Nuist  
										<small>OnLine Judge System</small>
									</h3>
								</header>
							</div>
						</div>
					</div>
				</section>