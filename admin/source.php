<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	
	if(isset($_GET['sid']))
	{
		$sid = $oDD->EscapeString($_GET['sid']);
	}
	else{$sid = "";}
	
	if(!empty($sid))
	{
		$strSql = "select result from solution where sid = '".$sid."';";
		$rsResult = $oDD->Query($strSql);
		$rsSolution = $oDD->FetchArray($rsResult, MYSQLI_ASSOC);
		switch($rsSolution['result'])
		{
			case 0:$result = "Submitted";break;
			case 1:$result = "Accepted";break;
			case 2:$result = "Presentation Error";break;
			case 3:$result = "Wrong Answer";break;
			case 4:$result = "Runtime Error";break;
			case 5:$result = "Time Limit Exceed";break;
			case 6:$result = "Memory Limit Exceed";break;
			case 7:$result = "Compile Error";break;
			case 8:$result = "System Error";break;
			case 9:$result = "Waiting";break;
		}
	}
			
	$strSql = "select source from source_code where sid = '".$sid."';";
	$rsResult = $oDD->Query($strSql);
	$rsSource = $oDD->FetchArray($rsResult, MYSQLI_ASSOC);
?>
<link href="../include/css/prism.css" rel="stylesheet" />

<section class="container">
    <div class="row">
		<div class="span3">
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>Source Code</h5>
				</div>							
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<tbody>
							<tr>
								<td width="20%">状态：</td>
								<td><?php echo $result;?></td>
							</tr>
							<tr>
								<td>编译错误信息：</td>
								<td>
								<?php 	
								if($rsSolution['result'] == 7)
								{
									$strSql = "select error from compileinfo where sid = '".$sid."';";
									$rsResult = $oDD->Query($strSql);
									$rsInfo = $oDD->FetchArray($rsResult, MYSQLI_ASSOC);
									echo $rsInfo['error'];
								}
								?></td>
							</tr>
						</tbody>
					</table>
					<div class="box-footer">
						<button class="btn btn-primary" type="button" onClick="history.go(-1);">返回</button>
					</div>
				</div>
			</div>
			
			<div class="box-content">
					<legend class="lead">
						Source Code
					</legend>
						<pre class="language-clike line-numbers" ><code><?php echo htmlspecialchars($rsSource['source']); ?></code></pre>
			</div>
			<div class="box-footer">
				<button class="btn btn-primary" type="button" onClick="history.go(-1);">返回</button>
			</div>
		</div>
	</div>
</section>
<script src="../include/js/prism.js"></script>	
<?php	
	require_once 'template/footer.tpl';
?>
