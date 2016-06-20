<?php
	require_once 'template/header.tpl';
	require_once 'global.php';
	require_once '../functions.php';
	
	confirmlogin();
	
	if(isset($_SESSION['cid']))
	{
		$cid = $oDD->EscapeString($_SESSION['cid']);
	}	
	else {$cid = ""; }
	
	if(isset($_SESSION['eid']))
	{   
	    $eid = $oDD->EscapeString($_SESSION['eid']);
	}
	else{$eid="";}
	
	if(isset($_SESSION['kid']))
	{
		$kid = $oDD->EscapeString($_SESSION['kid']);
	}	
	else{$kid="";}
	
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
					<h5>排名 >>> <?php if($cid!=""){echo $contest;}else if($eid!=""){echo $exam;}else if($kid!=""){echo $course;}?></div>
				</div>
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>题目</th>
								<th>AC  </th>
								<th>PE  </th>
								<th>WA </th>
								<th>RE </th>					 
								<th>TLE</th>					 
								<th>MLE</th>					
								<th>CE </th>
								<th>SE </th>
								<th>合计</th>
								<th>GCC</th>
								<th>G++</th>
							</tr>
						</thead>
						<tbody>
							<?php				
									$count_all = 0;// 总合计 
									if($cid!="")
									{
										$strSQL = "select logicpid from contest_problem where cid = '".$cid."' order by logicpid;";
									}
									else if($eid!="")
									{
										$strSQL = "select logicpid from exam_problem where eid = '".$eid."' order by logicpid;";
									}
									else if($kid!="")
									{
										$strSQL = "select logicpid from course_problem where kid = '".$kid."' order by logicpid;";
									}
									$rsResult_P = $oDD->Query($strSQL);
									
								while($rsProblem = $oDD->FetchArray($rsResult_P,MYSQLI_ASSOC))
								{
									$num = 0;				
									$total = array(); //每题的所有结果合计（行结果合计)
									
									$result_pid_count = array(); //每题的每个判题结果统计 
									for($i = 0; $i<8 ;$i++)
									{
										$result_pid_count[$i] = 0 ;
									}
									
									$language_pid_count = array(); //每题的两种语言统计
									for($i = 0; $i<2 ;$i++)
									{
										$language_pid_count[$i] = 0 ;
									}
									
									if($cid!="")
									{
										$strSQL = "select result,language from solution where cid = '".$cid."' and logicpid = '".$rsProblem['logicpid']."';";
									}
									else if($eid!="")
									{
										$strSQL = "select result,language from solution where eid = '".$eid."' and logicpid = '".$rsProblem['logicpid']."';";
									}
									else if($kid!="")
									{
										$strSQL = "select result,language from solution where kid = '".$kid."' and logicpid = '".$rsProblem['logicpid']."';";
									}
									
									$rsResult_C = $oDD->Query($strSQL);
								
									while($rsCount = $oDD->FetchArray($rsResult_C, MYSQLI_ASSOC))
								   {				
									   switch($rsCount['result'])
									  {
										case 1:$result_pid_count[0]++;break;
										case 2:$result_pid_count[1]++;break;
										case 3:$result_pid_count[2]++;break;
										case 4:$result_pid_count[3]++;break;
										case 5:$result_pid_count[4]++;break;
										case 6:$result_pid_count[5]++;break;
										case 7:$result_pid_count[6]++;break;
										case 8:$result_pid_count[7]++;break;
									  }
									   switch($rsCount['language'])
									  {
										case 1:$language_pid_count[0]++;break;
										case 2:$language_pid_count[1]++;break;
									  }
								  }
											   
								   $total['$num'] = $result_pid_count[0]+$result_pid_count[1]+$result_pid_count[2]+$result_pid_count[3]+$result_pid_count[4]+$result_pid_count[5]+           $result_pid_count[6]+$result_pid_count[7];			   
								   $count_all =  $count_all + $total['$num'];
								   $num++;
								   
								   echo '<tr><td><a href="problem.php?logicpid='.$rsProblem['logicpid'].'">'.$rsProblem['logicpid'].'</td>';
								   echo '<td>'.$result_pid_count[0].'</td>';
								   echo '<td>'.$result_pid_count[1].'</td>';
								   echo '<td>'.$result_pid_count[2].'</td>';
								   echo '<td>'.$result_pid_count[3].'</td>';
								   echo '<td>'.$result_pid_count[4].'</td>';
								   echo '<td>'.$result_pid_count[5].'</td>';
								   echo '<td>'.$result_pid_count[6].'</td>';
								   echo '<td>'.$result_pid_count[7].'</td>';
								   echo '<td>'.$total['$num'].'</td>';
								   echo '<td>'.$language_pid_count[0].'</td>';
								   echo '<td>'.$language_pid_count[1].'</td></tr>';
								}// 以上进行行统计（每题）
								
									$result_count = array();//每个结果统计（列合计）
									for($i = 0; $i<8 ;$i++)
									{
										$result_count[$i] = 0 ;
									}
									
									$language_count = array();//每个语言统计（列合计）
									for($i = 0; $i<2 ;$i++)
									{
										$language_count[$i] = 0 ;
									}
									
									if($cid!="")
									{
										$strSQL_S= "select result,language from solution a,contest_problem b where b.cid = '".$cid."' and a.cid = b.cid and a.logicpid = b.logicpid;";
									}
									else if($eid!="")
									{
										$strSQL_S= "select result,language from solution a,exam_problem b where b.eid = '".$eid."' and a.eid = b.eid and a.logicpid = b.logicpid;";
									}
									else if($kid!="")
									{
										$strSQL_S= "select result,language from solution a,course_problem b where b.kid = '".$kid."' and a.kid = b.kid and a.logicpid = b.logicpid;";
									}
									
									$rsResult = $oDD->Query($strSQL_S);
								
								while($rsCount = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
								{				
									switch($rsCount['result'])
									{
										case 1:$result_count[0]++;break;
										case 2:$result_count[1]++;break;
										case 3:$result_count[2]++;break;
										case 4:$result_count[3]++;break;
										case 5:$result_count[4]++;break;
										case 6:$result_count[5]++;break;
										case 7:$result_count[6]++;break;
										case 8:$result_count[7]++;break;
									}
									switch($rsCount['language'])
									{
										case 1:$language_count[0]++;break;
										case 2:$language_count[1]++;break;
									}
								}
								   echo '<tr><td>合计</td>';
								   echo '<td>'.$result_count[0].'</td>';
								   echo '<td>'.$result_count[1].'</td>';
								   echo '<td>'.$result_count[2].'</td>';
								   echo '<td>'.$result_count[3].'</td>';
								   echo '<td>'.$result_count[4].'</td>';
								   echo '<td>'.$result_count[5].'</td>';
								   echo '<td>'.$result_count[6].'</td>';
								   echo '<td>'.$result_count[7].'</td>';
								   echo '<td>'.$count_all.'</td>';
								   echo '<td>'.$language_count[0].'</td>';
								   echo '<td>'.$language_count[1].'</td></tr>';
							 //以上进行列统计 
							?>
						</tbody>
					</table>
				<div id="notes">
				  注：AC : Accepted ; PE : Presentation Error ; WA : Wrong Answer ; RE : Runtime Error ; TLE : Time Limit Exceed ; MLE : Memory Limit Exceed ; CE : Compile Error ; SE : System Error
				</div>
			</div>	
		</div>
	</div>
</section>

<?php	
	require_once 'template/footer.tpl';
?>