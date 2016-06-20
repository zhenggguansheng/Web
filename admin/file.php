<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	
	if(isset($_SESSION['pid']))
	{
		$pid = $oDD->EscapeString($_SESSION['pid']);
	}
	else {$pid = "";}
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
					<h5>文件上传 </h5>
				</div>							
				<form action="upload_file.php" method="post" enctype="multipart/form-data">
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<tbody>
							<tr>
								<td>ProblemID:</td>
								<td><?php echo $pid;?></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Filename:</td>
								<td><input name="file" type="file" id="file" size="32"/></td>
								<td><input class="btn btn-primary" type="submit" name="submit" value="上传" /></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
				</form>
				<div class="box-footer">
					<button class="btn btn-primary"  type="buttom" onClick="location.href='problemlist.php'">上传完成</button>
				</div>
			</div>
		</div>
	</div>
</section>
<?php	
	require_once 'template/footer.tpl';
?>
