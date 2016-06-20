<?php
	require_once 'template/header.tpl';
	require_once 'global.php';
	require_once '../functions.php';

	confirmlogin();
    $type = 0;
	if(isset($_SESSION['cid']))
	{
		$session = $oDD->EscapeString($_SESSION['cid']);
		$cid = $session;
        $type = 1;
	}
	else{$cid = "";}
	if(isset($_SESSION['eid']))
	{
		$session = $oDD->EscapeString($_SESSION['eid']);
		$eid = $session;
        $type = 2;	
    }    
	else{$eid = "";}	


	if(isset($_SESSION['kid']))
	{
		$session = $oDD->EscapeString($_SESSION['kid']);
		$kid = $session;
        $type = 3;
	}
	else{$kid = "";}
	
	
	if($cid!="")
	{
		$strSql = "select title from contest where cid='".$cid."';";
		$contest = $oDD->GetValue($strSql,MYSQLI_NUM,0);
	}
	else if($eid!="")
	{
		$strSql = "select title from exam where eid='".$eid."';";
		$exam = $oDD->GetValue($strSql,MYSQLI_NUM,0);
	}
	else if($kid!="")
	{
		$strSql = "select coursename from course where kid='".$kid."';";
		$course = $oDD->GetValue($strSql,MYSQLI_NUM,0);
	}
	else{$kid="";}
 
	if ($session != "" && $type!=0)
    {
        ranklist($type,$session);
    }

?>
<Script Language="JavaScript" type="text/JavaScript" src="../include/js/showo_page.js"></Script>

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
					<li><a href="editproblem.php">题目列表</a></li>
					<li><a href="addproblem.php">添加题目 </a></li>
					<li><a href="editstudent.php">学生列表</a></li>
					<li><a href="addstudent.php">添加学生 </a></li>
					<li><a href="status.php">状态         </a></li>
					<li><a href="ranklist.php">排名       </a></li>
					<li><a href="statistics.php">统计     </a></li>
					<?php
						if($cid != "")
							echo '<li><p><a href="putColor.php">气球登记</a></li>';
					?>
					
				</ul>
			</div>

		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>排名 >>> <?php if($cid!=""){echo $contest;}else if($eid!=""){echo $exam;}else if($kid!=""){echo $course;}?></h5>
				</div>
				<div class="page-container">
                   <div class="alert alert-block alert-info" style="TEXT-ALIGN:center">
                        <a href="save.php">导出数据</a>
                   </div>
				</div>
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th><?php echo $MSG_RANK ;?>   </th>
								<th><?php echo $MSG_UsersID ;?></th>
								<th><?php echo $MSG_USERNAME ;?></th>
								<th>学院                       </th>
								<th>专业                       </th>
								<th>年级                       </th>
								<th><?php echo $MSG_SOVLED ;?></th>
								<th><?php echo $MSG_SUBMIT ;?></th>
								<th><?php echo $MSG_RATIO ;?> </th>
							</tr>
						</thead>
						<tbody>
							<?php
								if(isset($_GET['Page'])){$page = $_GET['Page'];}
								else{$page = 1;}
								if($page)
								{
									$page_size = 50;//每页的信息行数
						
									$strSql = "select count(*) from ranklist";//应用count 统计总的记录数
									$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
									$page_count = ceil($total/$page_size);//计算页数
									$offset=($page-1)*$page_size;
									$rank = $offset+1;
									if ($total < $page_size)
									{   $strSql   = "select * from ranklist order by ac DESC , submit ASC ;";}
									else
									{   $strSql   = "select * from ranklist order by ac DESC , submit ASC limit $offset,$page_size;";}
								   	
									$rsResult = $oDD->Query($strSql);       
									while($rsRanklist= $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
									{
										echo '<tr><td>'.$rank.'</td>';
										echo '<td>'.$rsRanklist['user_name'].'</td>';
										echo '<td>'.$rsRanklist['name'].'</td>';
										echo '<td>'.$rsRanklist['college'].'</td>';
										echo '<td>'.$rsRanklist['major'].'</td>';
										echo '<td>'.$rsRanklist['grade'].'</td>';
										if (empty($rsRanklist['ac']))
											echo '<td>0</td>';
										else
											echo '<td>'.$rsRanklist['ac'].'</td>';
										if (empty($rsRanklist['submit']))
											echo '<td>0</td>';
										else
											echo '<td>'.$rsRanklist['submit'].'</td>';
										$ratio = number_format($rsRanklist['ratio'],4)*100;
										echo '<td>'.$ratio.'%</td></tr>';
										$rank = $rank+1;
									}
									if($total == 0)
									{
										echo '<tr ><td><font color="red">没有相关信息</font></td></tr>';
									}
								  }
								?>
							</tbody>
					</table>
				</div>
				
				<div class="box-footer">
						<Script Language="JavaScript">
								ShowoPage("","","<div class=\"alert alert-block alert-info\" style = \"TEXT-ALIGN:center\";><div>页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
						</Script>
						</div></div>
				</div>
			</div>
		</div>	
    </div>
</section>

<?php	
	require_once 'template/footer.tpl';
?>
