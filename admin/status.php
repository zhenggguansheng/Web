<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

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
	
	if(isset($_GET['logicpid']))
	{
		$logicpid = $oDD->EscapeString($_GET['logicpid']);
		if($logicpid == 99){$pidSQL="1 ";}
		else{$pidSQL = " solution.logicpid = '".$logicpid."' ";}
	}
	else{$logicpid = "";$pidSQL = "1 ";}
	
	if(isset($_GET['student_num'])&& !empty($_GET['student_num']))
	{
		$student_num = $oDD->EscapeString($_GET['student_num']);
		$str = "select uid from commonuser where student_num = '".$student_num."';";
		$uid = $oDD->GetValue($str,MYSQLI_NUM,0);
		$uidSQL = " solution.uid = '".$uid."' ";
	}
	else{$uid = "";$uidSQL = "1 ";}
	
	if(isset($_GET['language']))
	{
		$language = $oDD->EscapeString($_GET['language']);
		if($language == 99){$langSQL="1 ";}
		else{$langSQL = " solution.language = '".$language."' ";}
	}
	else{$language = "";$langSQL = "1 ";}
	
	if(isset($_GET['result']))
	{
		$result = $oDD->EscapeString($_GET['result']);
		if($result == 99){$rsSQL="1 ";}
		else{$rsSQL = " solution.result = '".$result."' ";}		
	}
	else{$result="";$rsSQL = "1 ";}
	
	if($eid!="")
	{
	    $postfix = "where  ".$uidSQL." and ".$pidSQL." and ".$langSQL." and ".$rsSQL." and solution.eid='".$eid."'";
	}
	else if($cid!="")
	{
		$postfix = "and  ".$uidSQL." and ".$pidSQL." and ".$langSQL." and ".$rsSQL." and solution.cid='".$cid."'";
	}
	else if($kid!="")
	{
		$postfix = "where  ".$uidSQL." and ".$pidSQL." and ".$langSQL." and ".$rsSQL." and solution.kid='".$kid."'";
	}
		
	if($cid!="")
	{
		$str_P = "select distinct logicpid from contest_problem where cid='".$cid."' order by logicpid;";
		$rsResult_P = $oDD->Query($str_P);
	}
	else if($eid!="")
	{
		$str_P = "select distinct logicpid  from exam_problem where eid='".$eid."' order by logicpid;";
		$rsResult_P = $oDD->Query($str_P);
	}
	else if($kid!="")
	{
		$str_P = "select distinct logicpid  from course_problem where kid='".$kid."' order by logicpid;";
		$rsResult_P = $oDD->Query($str_P);
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
					<h5>状态 >>> <?php if($cid!=""){echo $contest;}else if($eid!=""){echo $exam;}else if($kid!=""){echo $course;}?></h5>
				</div>
				<form action="status.php" method="get">
				   题目
				   <select name = "logicpid" style="width:80px;">
					   <option value="99">All</option>
					   <?php 
					   while($Pid = $oDD->FetchArray($rsResult_P,MYSQLI_ASSOC))
					   {
						   echo '<option value = "'.$Pid['logicpid'].'">'.$Pid['logicpid'].'</option>';
					   }
					   ?>
				   </select>
				   &nbsp;&nbsp;
				   学号
				   <input name = "student_num" type="text" style="width:100px;" maxlength="32"/>
				   &nbsp;&nbsp;
				   状态
				   <select name="result" style="width:200px;">
						<option value="99">All</option>
						<option value="0">Submitted</option>
						<option value="1">Accepted</option>
						<option value="2">Presentation Error</option>
						<option value="3">Wrong Answer</option>
						<option value="4">Runtime Error</option>
						<option value="5">Time Limit Exceed</option>
						<option value="6">Memory Limit Exceed</option>
						<option value="7">Compile Error</option>
						<option value="8">System Error</option>
						<option value="9">Waiting</option>
					</select>
				   &nbsp;&nbsp;
				   语言
					<select name="language" style="width:100px;">
						   <option value="99">All</option>
						   <option value="1">GUN C</option>
						   <option value="2">GUN C++</option>
							<option value="3">Java</option>
						</select>
				   &nbsp;&nbsp;
					<input name="submit" value="Go" type="submit" style="width:50px;" />
				 </form>
				 <div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<?php
									if($cid != "")
									{
										echo '<th></th>';
									}
								?>
									<th>学号</th>
									<th>姓名</th>
									<th>物理题号</th>
									<th>逻辑题号</th>
									<th>结果</th>
									<th>内存</th>					 
									<th>耗时</th>					 
									<th>语言</th>					
									<th>提交时间</th>
								<?php
									if($cid != "")
									{
										echo '<th>教室</th>';
										echo '<th>座位</th>';
									}
								?>
							</tr>
						</thead>
						<tbody>
							<?php
							if(isset($_GET['Page'])){$page = $_GET['Page'];}
							else{$page = 1;}
							if($page)
							{
								$page_size = 50;//每页的信息行数
								$strSql = "SELECT count(*) FROM commonuser INNER JOIN solution ON solution.uid = commonuser.uid ".$postfix.";";//应用count 统计总的记录数
								
								$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
								$page_count = ceil($total/$page_size);//计算页数
								$offset=($page-1)*$page_size;
								if($total == 0)
								{
									echo '<tr><td><font color="red">未搜索到相关信息</font></td></tr>';
								}
								else
								{
									if ($cid == "")
									{
										$strSql   = "SELECT  commonuser.student_num, commonuser.name, solution.sid, solution.pid,solution.logicpid,solution.use_time, solution.use_memory, solution.mark,solution.in_date, solution.result, solution.language, solution.uid 
													   FROM commonuser INNER JOIN solution ON solution.uid = commonuser.uid ".$postfix." order by solution.in_date DESC limit $offset,$page_size;";
									}
									else
									{
										$strSql   = "SELECT  commonuser.student_num, commonuser.name, solution.sid, solution.mark,contest_problem.logicpid,contest_problem.pid,contest_problem.color,solution.use_time, solution.use_memory, solution.in_date, solution.result, solution.language, solution.uid 
													   FROM contest_user,solution,commonuser,contest_problem  where contest_problem.pid = solution.pid and contest_problem.cid =  '".$cid."' and solution.cid = contest_user.cid ".$postfix." and commonuser.uid = solution.uid AND contest_user.uid = commonuser.uid and contest_user.cid= '".$cid."'  
													   order by solution.in_date DESC limit $offset,$page_size;";
															
									}
									
									$rsResult = $oDD->Query($strSql);
									
									while($rsSolution = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
									{
										echo '<tr>';
										if($cid != "")
										{
											if($rsSolution['mark'] == 1 && $rsSolution['result'] == 1)
											{
												echo '<td>ok</td>';
											}
											else
											{
												echo '<td></td>';
											}
										}
										
										echo '<td>'.$rsSolution['student_num'].'</td>';
										echo '<td>'.$rsSolution['name'].'</td>';
										echo '<td>'.$rsSolution['pid'].'</td>';
										if($cid != "")
										{
											echo '<td>'.$rsSolution['logicpid']." ".$rsSolution['color'].'</td>';
										}
										else
										{
											echo '<td>'.$rsSolution['logicpid'].'</td>';
										}
										switch($rsSolution['result'])
										{
											case 0:$result = "Submitted";break;
											case 1:$result = "Accepted";break;
											case 2:$result = "Presentation Error";break;
											case 3:$result = "Time Limit Exceed";break;
											case 4:$result = "Memory Limit Exceed";break;
											case 5:$result = "Wrong Answer";break;
											case 6:$result = "Runtime Error";break;
											case 7:$result = "Compile Error";break;
											case 8:$result = "System Error";break;
											case 9:$result = "Waiting";break;
										}
										if(!strcmp($result,"Accepted")){
										echo '<td><font color="red">'.$result.'</font></td>';}
										else {echo '<td><font color="green">'.$result.'</font></td>';}
										echo '<td>'.$rsSolution['use_memory'].' k</td>';
										echo '<td>'.$rsSolution['use_time'].' ms</td>';
										switch($rsSolution['language'])
										{
											case 1:$language = "GNU C";break;
											case 2:$language = "GNU C++";break;
											case 3:$language = "Java";break;
											default:$language = "All";
										}
										echo '<td><a href="source.php?sid='.$rsSolution['sid'].'">'.$language.'</a></td>';
										echo '<td>'.$rsSolution['in_date'].'</td>';
										if($cid != "")
										{
											$strSql ="select room,seat from contest_user where uid = '".$rsSolution['uid']."' and cid = '".$cid."';";
											$rsResult_r = $oDD->Query($strSql);
											$rsRoomSeat = $oDD->FetchArray($rsResult_r, MYSQLI_ASSOC);
											echo '<td>'.$rsRoomSeat['room'].'</td>';
											echo '<td>'.$rsRoomSeat['seat'].'</td></tr>';
										}
									}
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
