<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
 
	if(isset($_SESSION['cid']))
	{
			$cid = $oDD->EscapeString($_SESSION['cid']);
	}
	else{$cid="";}
	if(isset($_SESSION['kid']))
	{
			$kid = $oDD->EscapeString($_SESSION['kid']);
	}
	else{$kid="";}

	if(isset($_SESSION['eid']))
	{
			$eid = $oDD->EscapeString($_SESSION['eid']);
	}
	else{$eid="";}

	if(isset($_GET['pid']))
	{
		$_SESSION['pid'] = $oDD->EscapeString($_GET['pid']);
		$pid = $_SESSION['pid'];
	}
	else if(isset($_SESSION['pid']))
	{
		$pid = $_SESSION['pid'];
	}
	else {$pid="";}
	

	if ($pid != "" )
	{
		if($cid!="")
		{
				$strSql = "select b.pid,b.description,b.input,b.output,b.sample_input,b.sample_output,a.color,a.logicpid as logpid ,c.title as title from contest_problem as a,problem as b,contest c where c.cid = a.cid and a.pid = b.pid and a.cid = '".$cid."' and a.pid = '".$pid."';";
		}
		else if($eid!="")
		{
				$strSql = "select b.pid,b.description,b.input,b.output,b.sample_input,b.sample_output,a.logicpid as logpid ,c.title  as title  from exam_problem as a,problem as b,exam c where c.eid = a.eid and a.pid = b.pid and a.eid = '".$eid."' and a.pid = '".$pid."';";
		}
		else if($kid!="")
		{
				$strSql = "select b.pid,b.description,b.input,b.output,b.sample_input,b.sample_output,a.logicpid as logpid ,c.coursename as title  from course_problem as a,problem as b,course c where c.kid = a.kid and a.pid = b.pid and a.kid = '".$kid."' and a.pid = '".$pid."';";
		}
		else
		{
				$strSql = "select *, '题目信息'  as title from problem where pid = '".$pid."';";
		}

		$rsResult = $oDD->Query($strSql);
		$rsProblem = $oDD->FetchArray($rsResult,MYSQLI_ASSOC);
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
				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>题目编辑 >>> <?php $pid; ?></h5>
				</div>							
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
					 <form action="update.php" method="get">
						<tbody>
							<tr>
							  <td width="10%">题目编号：</td>
							  <td><?php $_SESSION['pid'] = $rsProblem['pid']; echo $rsProblem['pid'];?></td>
							</tr>
							<tr>
							  <td width="10%">逻辑题号：</td>
							  <td><input name="logicpid" value="<?php echo $rsProblem['logpid'];?>" style="width:200px;" /></td>
							</tr>
							<tr>
							  <td>题目描述：</td>
							  <td><?php echo $rsProblem['description'];?></td>
							</tr>
							<tr>
							  <td>输入：</td>
							  <td><?php echo $rsProblem['input'];?></td>
							</tr>
							<tr>
							  <td>输出：</td>
							  <td><?php echo $rsProblem['output'];?></td>
							</tr>
							<tr>
							  <td>样例输入：</td>
							  <td><?php echo $rsProblem['sample_input'];?></td>
							</tr>
							<tr>
							  <td>样例输出：</td>
							  <td><?php echo $rsProblem['sample_output'];?></td>
							</tr><?php
											if ($cid != "")
											{
											  
												echo '<tr>';
												echo '<td>颜色：</td>';
												echo '<td><input name="color" value="'.$rsProblem['color'].'" /></td></tr>';
											}
										?>
						</tbody>
						<input name="pid" value="<?php echo $pid;?>" type="hidden" />
						<div class="box-footer">
							<button class="btn btn-primary" onclick="selectItems();">提交</button>
							<button class="btn btn-primary" onClick="location.href='editproblem.php'">取消</button>
						</div>
					</form>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<?php	
	require_once 'template/footer.tpl';
?>
