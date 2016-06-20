<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	
	if(isset($_SESSION['cid']))
	{
		$cid = $oDD->EscapeString($_SESSION['cid']);
	}	
	else { $cid = ""; }
	
	if(isset($_SESSION['eid']))
	{   
	    $eid = $oDD->EscapeString($_SESSION['eid']);
	}
	else{$eid="";}
	
	if(isset($_SESSION['kid']))
	{
		$kid = $_SESSION['kid'];
	}
	else{$kid="";}
	
	if($cid!="")
	{
	$strSql = "select title from contest where cid='".$cid."';";
	$contest = $oDD->GetValue($strSql,MYSQLI_NUM,0);
	}
	
	if($eid!="")
	{
	$strSql = "select title from exam where eid='".$eid."';";
	$exam = $oDD->GetValue($strSql,MYSQLI_NUM,0);
	}
	
	if($kid!="")
	{
	$strSql = "select coursename from course where kid='".$kid."';";
	$course = $oDD->GetValue($strSql,MYSQLI_NUM,0);
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
					<h5>学生列表 >>> <?php if($cid!=""){echo $contest;}else if($eid!=""){echo $exam;}else if($kid!=""){echo $course;}?></h5>
				</div>
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<thead>
							<?php
								if(isset($_GET['Page'])){$page = $_GET['Page'];}
								else{$page = 1;}
								if($page)
								{
									$page_size = 50;//每页的信息行数
									if($cid!="")
									{
										$strSql = "select count(*) as total from contest_user where uid >= 120 and  cid='".$cid."';";
									}
									else if($eid!="")
									{
										$strSql = "select count(*) as total from exam_user where uid >= 120 and eid='".$eid."';";
									}
									else if($kid!="")
									{
										$strSql = "select count(*) as total from course_user where uid >= 120 and kid='".$kid."';";
									}
									//应用count 统计总的记录数

									$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
									$page_count = ceil($total/$page_size);//计算页数
									$offset=($page-1)*$page_size;
								}
							?>
							<tr>
								 <th>学号</th>
								 <th>姓名</th>
								 <th>学院</th>
								 <th>专业</th>
								 <th>年级</th>
								 <?php
									if($cid != "")
									{
										echo '<th>教室</th>';
										echo '<th>座位</th>';
									}
								?>
								 <th><font color="red">已添加学生数：<?php echo $total;?></font></th>
							</tr>
							<?php		
								if($cid!="")
								{
									$strSql   = "select distinct b.uid, b.student_num, b.name, b.college, b.major, b.grade, a.room, a.seat from contest_user as a, commonuser as b 
												  where b.uid >= 120 and b.uid  = a.uid and a.cid='".$cid."' order by b.uid  limit $offset,$page_size;";
									$rsResult = $oDD->Query($strSql);
									while($rsData = $oDD->FetchArray($rsResult,MYSQLI_ASSOC))
									{	
										echo '<tr><td><a href="editstudentinfo.php?userid='.$rsData['uid'].'">'.$rsData['student_num'].'</a></td>';
										echo '<td>'.$rsData['name'].'</td>';
										echo '<td>'.$rsData['college'].'</td>';
										echo '<td>'.$rsData['major'].'</td>';
										echo '<td>'.$rsData['grade'].'</td>';
										echo '<td>'.$rsData['room'].'</td>';
										echo '<td>'.$rsData['seat'].'</td>';
										echo '<td><a href="delete.php?userid='.$rsData['uid'].'" onclick="return confirm(\'确认删除这条记录？\')">删除</a></td></tr>';	
									}
								}
								if($eid!="")
								{
									$strSql   = "SELECT distinct b.uid, b.student_num, b.name, b.college, b.major, b.grade 
												 FROM  exam_user AS a, commonuser AS b WHERE b.uid >= 120 AND b.uid = a.uid AND a.eid = '".$eid."' ORDER BY b.uid  limit $offset,$page_size;";
									$rsResult = $oDD->Query($strSql);
									while($rsData = $oDD->FetchArray($rsResult,MYSQLI_ASSOC))
									{	
										echo '<tr><td><a href="editstudentinfo.php?userid='.$rsData['uid'].'">'.$rsData['student_num'].'</a></td>';
										echo '<td>'.$rsData['name'].'</td>';
										echo '<td>'.$rsData['college'].'</td>';
										echo '<td>'.$rsData['major'].'</td>';
										echo '<td>'.$rsData['grade'].'</td>';
										echo '<td><a href="delete.php?userid='.$rsData['uid'].'" onclick="return confirm(\'确认删除这条记录？\')">删除</a></td></tr>';				
									}
								 }
								if($kid!="")
								{
									$strSql   = "SELECT distinct b.uid, b.student_num, b.name, b.college, b.major, b.grade 
												 FROM  course_user AS a, commonuser AS b WHERE b.uid >= 120 AND b.uid = a.uid AND a.kid='".$kid."' ORDER BY b.uid  limit $offset,$page_size;";
									$rsResult = $oDD->Query($strSql);
									while($rsData = $oDD->FetchArray($rsResult,MYSQLI_ASSOC))
									{	
										echo '<tr><td><a href="editstudentinfo.php?userid='.$rsData['uid'].'">'.$rsData['student_num'].'</a></td>';
										echo '<td>'.$rsData['name'].'</td>';
										echo '<td>'.$rsData['college'].'</td>';
										echo '<td>'.$rsData['major'].'</td>';
										echo '<td>'.$rsData['grade'].'</td>';
										echo '<td><a href="delete.php?userid='.$rsData['uid'].'" onclick="return confirm(\'确认删除这条记录？\')">删除</a></td></tr>';	
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
