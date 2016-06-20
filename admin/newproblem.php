<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	if(isset($_SESSION['uid']))
	{
		$uid = $oDD->EscapeString($_SESSION['uid']);
	}
	else {$uid = "";}
	
	if(isset($_POST["title"]))
    {
		$title = $oDD->EscapeString($_POST["title"]);
    }
    else {$title = "";}

	if(isset($_POST["pid"]))
    {
	    $pid = $oDD->EscapeString($_POST["pid"]);
     }
    else{$pid = "";}
	if(isset($_POST["logicpid"]))
    {
	    $logicpid = $oDD->EscapeString($_POST["logicpid"]);
     }
    else{$logicpid = "";}
	
    if(isset($_POST["description"]))
    {
        $description = $oDD->EscapeString($_POST["description"]);
    }
    else{$description = "";}

    if(isset($_POST["input"]))
    {
        $input = $oDD->EscapeString($_POST["input"]);
    }
    else{$input = "";}

    if(isset($_POST["output"]))
    {
        $output = $oDD->EscapeString($_POST["output"]);
    }
    else{$output = "";}

    if(isset($_POST["sample_input"]))
    {
        $sample_input = $oDD->EscapeString($_POST["sample_input"]);
     }
    else{$sample_input = "";}

    if(isset($_POST["sample_output"]))
    {
         $sample_output = $oDD->EscapeString($_POST["sample_output"]);
    }
    else{$sample_output = "";}

    if(isset($_POST["source"]))
    {
        $source =  $oDD->EscapeString($_POST["source"]);
    }
    else{$source = "";}

	if(isset($_POST["RadioGroup1"]))
    {
        $defunct =  $oDD->EscapeString($_POST["RadioGroup1"]);
      }
    else{$defunct = "";}

    if(isset($_POST["time_limit"]))
    {
        $time_limit =  $oDD->EscapeString($_POST["time_limit"]);
     }
    else{$time_limit = "";}

    if(isset($_POST["memory_limit"]))
    {
	    $memory_limit =  $oDD->EscapeString($_POST["memory_limit"]);
    }
    else{$memory_limit = "";}
	
    if ( !empty($title) || !empty($description) ||  !empty($input) ||   !empty($output) || !empty($sample_input) ||
		 !empty($sample_output) || !empty($source) ||  !empty($defunct) || !empty($time_limit) || !empty($memory_limit ) )
	{
		$problemdate = date("Y-m-d H:i:s");

		$sql = "insert into problem (`pid`,`logicpid`,`title`,`description`,`input`,`output`,`sample_input`,`sample_output`,`source`,`in_date`,`time_limit`,`memory_limit`,`defunct`,`creator`) values ('".$pid."','".$logicpid."','".$title."','".$description."','".$input."','".$output."','".$sample_input."','".$sample_output."','".$source."','".$problemdate."','".$time_limit."','".$memory_limit."','".$defunct."','".$uid."');";

		
		$res = $oDD->Query($sql);
		if($res)
		{
			Header("Location:problemlist.php");
		}
	}
	if(!empty($uid))
	{
		$strSql = "select pid from problem order by pid DESC limit 1;";
		$rsResult = $oDD->Query($strSql);
		$rsProblem = $oDD->FetchArray($rsResult);
	}
?>




<meta charset="utf-8">
<script src="../ubuilder/ueditor.config.js"></script>
<script src="../ubuilder/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../ubuilder/zh-cn/zh-cn.js"></script>

<script>

    	function formcheck()
		{
			var strP = /^\d+$/;
			if(!strP.test(theProblem.time_limit.value))
			{
				alert('时间限制必须是数字！');
				return false;
			}
			if(!strP.test(theProblem.memory_limit.value))
			{
				alert('空间限制必须是数字！');
				return false;
			}
			return true;
		}
</script>



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
					<h5>新建题目 </h5>
				</div>							
				<form method = post >
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<tbody>
							<tr>  
								<td>题目编号：</td>
								<td><input name="pid" value="<?php echo $rsProblem['pid'] + 1;?>" style="width:200px;"/></td>
							</tr>
							<tr>
								<td>逻辑题号：</td>
								<td><input name="logicpid" value="<?php echo $rsProblem['pid'] + 1;?>" style="width:200px;"/></td>
							</tr>
							<tr>
								<td>标题：</td>
								<td><input name="title" value="" style="width:200px;"/></td>
							</tr>
							<tr>
								<td>描述：</td>
								<td>
									<script id="editor1" name="description" type="text/plain" style="width:660px;height:200px;"></script>
									<script type="text/javascript">var ue1 = UE.getEditor('editor1');</script>
								</td>
							</tr>
							<tr>	
								<td>输入：</td>
								<td>
									<script id="editor2" name="input" type="text/plain" style="width:660px;height:200px;"></script>
									<script type="text/javascript">var ue2 = UE.getEditor('editor2');</script>
								</td>
							</tr>
							<tr>
								<td>输出：</td>
								<td>
									<script id="editor3" name="output" type="text/plain" style="width:660px;height:200px;"></script>
									<script type="text/javascript">var ue3 = UE.getEditor('editor3');</script>
								</td>
							</tr>
							<tr>
								<td>样例输入：</td>
								<td>
									<script id="editor4" name="sample_input" type="text/plain" style="width:660px;height:200px;"></script>
									<script type="text/javascript">var ue4 = UE.getEditor('editor4');</script>
								</td>
							</tr>
							<tr>
								<td>样例输出：</td>
								<td>
									<script id="editor5" name="sample_output" type="text/plain" style="width:660px;height:200px;"></script>
									<script type="text/javascript">var ue5 = UE.getEditor('editor5');</script>
								</td>
							</tr>
							<tr>
								<td>题目来源：</td>
								<td><input name="source" value="" /></td>
							</tr>
							<tr>
								<td>是否可见：</td>
								<td>
								  <label><input type="radio" name="RadioGroup1" value="Y" id="RadioGroup1_0" />是</label>
								  <label><input type="radio" name="RadioGroup1" value="N" id="RadioGroup1_1" />否</label>
								 </td>
							</tr>
							<tr>
								<td>time_limit：</td>
								<td><input name="time_limit" value="" /></td>
							</tr>
							<tr>
								<td>memory_limit：</td>
								<td><input name="memory_limit" value="" /></td>
							</tr>
						</tbody>
					</table>
					<div class="box-footer">
						<button class="btn btn-primary" type="submit">提 交</button>
						<button class="btn btn-primary" type="button" onClick="history.go(-1);">返回</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</section>
<?php	
	require_once 'template/footer.tpl';
?>
