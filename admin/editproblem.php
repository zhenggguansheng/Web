<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
    if(isset($_SESSION['cid']))
	{
		$cid = $_SESSION['cid'];
	}
	else{$cid="";}
	
    if(isset($_SESSION['eid']))
	{
		$eid = $oDD->EscapeString($_SESSION['eid']);
	}
	else{$eid="";}
	
	if(isset($_GET['kid']))
	{
		$_SESSION['kid'] = $oDD->EscapeString($_GET['kid']);
		$kid = $_SESSION['kid'];
	}
	else if(isset($_SESSION['kid']))
	{
		$kid = $_SESSION['kid'];
	}
	else {$kid="";}
	
	if($cid!="")
	{
		$strSql = "select title from contest where cid='".$cid."';";
		$contest = $oDD->GetValue($strSql,MYSQLI_NUM,0);
		$str1 = "select count(*) as total from contest_problem where cid = '".$cid."';";
		$count = $oDD->GetValue($str1,MYSQLI_NUM,0);
		$str2 = "update contest set pnum = '".$count."' where cid = '".$cid."';";
		$oDD->Query($str2); 
	}
	
	if($eid!="")
	{
		$strSql = "select title from exam where eid='".$eid."';";
		$exam = $oDD->GetValue($strSql,MYSQLI_NUM,0);
		$str1 = "select count(*) as total from exam_problem where eid = '".$eid."';";
		$count = $oDD->GetValue($str1,MYSQLI_NUM,0);
		$str2 = "update exam set pnum = '".$count."' where eid = '".$eid."';";
	$oDD->Query($str2); 
	}
	
	if($kid!="")
	{
		$strSql = "select coursename from course where kid='".$kid."';";
		$course = $oDD->GetValue($strSql,MYSQLI_NUM,0);
		$str1 = "select count(*) as total from course_problem where kid = '".$kid."';";
		$count = $oDD->GetValue($str1,MYSQLI_NUM,0);
		$str2 = "update course set pnum = '".$count."' where kid = '".$kid."';";
		$oDD->Query($str2); 
	}
	
	/*
	if(isset($_GET['show_res'])&&isset($_GET['logicpid']))
	{
		if($_GET['show_res']==1)
		{
			$strSQL = "update exam_problem set show_res = 0 where logicpid='".$_GET['logicpid']."' and eid='".$eid."';";
			$rsResult = $oDD->Query($strSQL);
		}
		else 
		{
			$strSQL = "update exam_problem set show_res = 1 where logicpid='".$_GET['logicpid']."' and eid='".$eid."';";
			$rsResult = $oDD->Query($strSQL);
		}
	}
	*/
	
	if(isset($_GET['Page'])){$page = $_GET['Page'];}
	else{$page = 1;}
	if($page)
	{
		$page_size = 50;//每页的信息行数
		if($cid!="")
		{
			$strSql = "select count(*) as total from contest_problem where cid='".$cid."';";
		}
		else if($eid!="")
		{
			$strSql = "select count(*) as total from exam_problem where eid='".$eid."';";
		}
		else if($kid!="")
		{
			$strSql = "select count(*) as total from course_problem where kid='".$kid."';";
		}
		//应用count 统计总的记录数
		$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
		$page_count = ceil($total/$page_size);//计算页数
		$offset=($page-1)*$page_size;
	}

	function filterstring($data)
	{
		$data = trim($data);
		//$data = stripslashes($data);
		//$data = htmlspecialchars($data);
		return $data;
	}
	
	
?>


<script Language="JavaScript" type="text/JavaScript" src="../include/js/showo_page.js"></script>
<section class="container">
    <div class="row">
		<div class="span2">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<?php 
						if($cid!="")
							echo '<li><p><a href="editcontestinfo.php">竞赛编辑</a></li>';
						else if($eid!="")
							echo '<li><p><a href="editexaminfo.php">考试编辑</a></li>';
						else if($kid!="")
							echo '<li><p><a href="editcourseinfo.php">课程编辑</a></li>';
					?>
					<li><p><a href="editproblem.php">题目列表</a></p></li>
					<li><p><a href="addproblem.php">添加题目</a></p></li>
					<li><p><a href="editstudent.php">学生列表</a></p></li>
					<li><p><a href="addstudent.php">添加学生</a></p></li>
					<li><p><a href="status.php">状态</a></p></li>
					<li><p><a href="ranklist.php">排名</a></p></li>
					<li><p><a href="statistics.php">统计</a></p></li>
					<li><p><a href="putColor.php">气球登记</a></p></li>
				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>题目列表 >>> <?php if($cid!=""){
												echo $contest;
											}else if($eid!=""){
												echo $exam;
											}else if($kid!=""){
												echo $course;
											}
											echo '(<font color="red">已添加题目数：' . $total. '</font>)';
									?></h5>
				</div>
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>题目编号</th>
								<th>题目名称</th>
								<th>逻辑编号</th>
								<?php
									if($cid != "")
									{
										echo '<th>对应气球颜色</th>';
									}

								?>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php 
									if($cid!="")
									{
										$_SESSION['cid'] = $cid;
										$strSql = "select b.pid, b.title, a.logicpid,a.color from contest_problem AS a ,problem as b where a.pid = b.pid and a.cid='".$cid."' order by a.pid  limit $offset,$page_size;";
										$rsResult = $oDD->Query($strSql);
										while($rsContest = $oDD->FetchArray($rsResult,MYSQLI_ASSOC))
										{	
											echo '<tr><td class="td1">'.$rsContest['pid'].'</td>';
											echo '<td><a href="updatelogicpid.php?pid='.$rsContest['pid'].'" title="可以更改逻辑题号">'.$rsContest['title'].'</a></td>';
											echo '<td>'.$rsContest['logicpid'].'</td>';
											echo '<td>'.$rsContest['color'].'</td>';
											echo '<td><a href="delete.php?logicpid='.$rsContest['logicpid'].'" onclick="return confirm(\'确认删除这条记录？\')">删除</a></td>';
											echo '<td></td></tr>';	
										}
									}
									else if($eid!="")
									{
										$_SESSION['eid'] = $eid;
										$strSql = "select b.pid,b.title, a.logicpid,show_res from exam_problem AS a ,problem as b where a.pid = b.pid and a.eid='".$eid."' order by a.pid  limit $offset,$page_size;";
										$rsResult = $oDD->Query($strSql);
										while($rsExam = $oDD->FetchArray($rsResult,MYSQLI_ASSOC))
										{	
											echo '<tr><td>'.$rsExam['pid'].'</td>';
											echo '<td><a href="updatelogicpid.php?pid='.$rsExam['pid'].'" title="浏览题目内容，可更改逻辑题号">'.$rsExam['title'].'</a></td>';
											echo '<td>'.$rsExam['logicpid'].'</td>';
											echo '<td><a href="delete.php?logicpid='.$rsExam['logicpid'].'" onclick="return confirm(\'确认删除这条记录？\')">删除</a></td>';
											echo '<td></td></tr>';
										}
									}
									else if($kid!="")
									{
										$_SESSION['kid'] = $kid;
										$strSql = "select b.pid,b.title, a.logicpid from course_problem AS a ,problem as b where a.pid = b.pid and a.kid='".$kid."' order by a.pid  limit $offset,$page_size;";
										$rsResult = $oDD->Query($strSql);
										while($rsCourse = $oDD->FetchArray($rsResult,MYSQLI_ASSOC))
										{	
											
											echo '<tr><td class="td1">'.$rsCourse['pid'].'</td>';
											echo '<td><a href="updatelogicpid.php?pid='.$rsCourse['pid'].'" title="可以更改逻辑题号">'.$rsCourse['title'].'</a></td>';
											echo '<td>'.$rsCourse['logicpid'].'</td>';
											echo '<td><a href="delete.php?logicpid='.$rsCourse['logicpid'].'" onclick="return confirm(\'确认删除这条记录？\')">删除</a></td>';
											echo '<td></td></tr>';
										}
									}
							?>	
						</tbody>
					</table>
				</div>
			</div>
			<div class="page-container"">
				<Script Language="JavaScript">
						ShowoPage("","","<div class=\"alert alert-block alert-info\" style = \"TEXT-ALIGN:center\";><div>页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
				</Script>
				</div></div>
			</div>
		</div>
	</div>
</section>

<?php	
	require_once 'template/footer.tpl';
?>
