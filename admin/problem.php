<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	
    if(isset($_GET['pid']))
	{
		$_SESSION['pid'] = $oDD->EscapeString($_GET['pid']);
		$pid = $_SESSION['pid'];
	}
	else {$pid = "";}
	if ( !empty($pid) )
	{
		$strSql = "select * from problem where pid = '".$pid."';";
		$rsResult = $oDD->Query($strSql);
		$rsProblem = $oDD->FetchArray($rsResult,MYSQLI_ASSOC);
	}
	else
	{exit;}
?>

<section class="container">
    <div class="row">
		<div class="span3">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><p><a href="problem.php?pid=<?php echo $pid;?>">题目信息</a></p></li>
					<li><p><a href="editprobleminfo.php">编辑题目</a></p></li>
					<li><p><a href="file.php">上传测试数据</a></p></li>
				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>题目信息 </h5>
				</div>							
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<tbody>
							<tr>
								<td width="15%">题目编号：</td>
								<td><?php echo $rsProblem['pid'];?></td>
							</tr>
							<tr>
								<td width="15%">逻辑编号：</td>
								<td><?php echo $rsProblem['logicpid'];?></td>
							</tr>
							<tr>
								<td width="15%">题目名称：</td>
								<td><?php echo $rsProblem['title'];?><td>
							</tr>
							<tr>
								<td width="15%">题目描述：</td>
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
							</tr>
							<tr>
								<td>是否可见：</td>
								<td><?php echo $rsProblem['defunct'];?></td>
							</tr>
							<tr>
								<td>通过数：</td>
								<td><?php echo $rsProblem['accepted'];?></td>
							</tr>
							<tr>
								<td>提交数：</td>
								<td><?php echo $rsProblem['submit'];?></td>
							</tr>
							<tr>
								<td>通过率：</td>
								<td><?php echo $rsProblem['ratio']*100 ;?>%</td>
							</tr>
						</tbody>
					</table>
					<div class="box-footer">
						<button class="btn btn-primary" type="button" onClick="history.go(-1);">返回</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php	
	require_once 'template/footer.tpl';
?>
