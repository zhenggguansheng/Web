<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	$type = '1';
	unset($_SESSION['cid']);
	unset($_SESSION['kid']);
	
    if(isset($_GET["action"]) and $_GET["action"]=="submit")
    {
		$title = $oDD->EscapeString($_POST['title']);
		$description = $oDD->EscapeString($_POST['description']);
		$start_time = $oDD->EscapeString($_POST['start_time']);
		$end_time = $oDD->EscapeString($_POST['end_time']);
		$defunct = $oDD->EscapeString($_POST['RadioGroup1']);
		$timeplus = $oDD->EscapeString($_POST['timeplus']);

		if (!empty($title))
		{
			$sql = "insert into exam (title,description,start_time,end_time,defunct,timeplus,creator) values ('".$title."','".$description."','".$start_time."','".$end_time."','".$defunct."','".$timeplus."','".$_SESSION['uid']."');";
			$res = $oDD->Query($sql);
			
			if($res)
			{
				Header("Location:exam.php");
			}
		}
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
			if(!strP.test(form1.timeplus.value))
			{
				alert('罚时必须是数字！');
				return false;
			}
			else {return true;}
		}

</script>


<section class="page container">
    <div class="row">
		<div class="span2">
			<div class="blockoff-left">
				<ul class="nav nav-list">
           		<li><p><a href="exam.php">考试管理</a></p></li>
				</ul>
			</div>
		</div>
		<div class="span14">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>新建考试</h5>
				</div>
				<div class="box-content box-table">
					<form  name= "form1" method="post" action="newexam.php?action=submit" onSubmit="return formcheck()">
					<table class="table table-hover table-bordered">
						<tbody>
							<tr>
								<td>考试名称：</td>
								<td><input name="title" value="" style="width:200px;"/></td>
							</tr>
							<tr>
								<td>考试描述：</td>
								<td>
									<script id="editor1" name="description" type="text/plain" style="width:860px;height:200px;"></script>
									<script type="text/javascript">var ue1 = UE.getEditor('editor1');</script>
								</td>
							</tr>
							<tr>
								<td>开始时间：</td>
								<td><input name="start_time" style="width:250px;"/>&nbsp;日期格式：yyyy-MM-dd hh:mm:ss</td>
							</tr>
							<tr>
								<td>结束时间：</td>
								<td><input name="end_time" value="" style="width:250px;"/>&nbsp;日期格式：yyyy-MM-dd hh:mm:ss</td>
							</tr>
							<tr>
								<td>是否可见：</td>
								<td>
								  <label><input type="radio" name="RadioGroup1" value="Y" id="RadioGroup1_0" />是</label>
								  <label><input type="radio" name="RadioGroup1" value="N" id="RadioGroup1_1" />否</label>
								 </td>
							</tr>
							<tr>
								<td>罚时：</td>
								<td><input name="timeplus" value="" style="width:150px;"/>min</td>
							</tr>
						</tbody>
					</table>
					<div class="box-footer">
						<button class="btn btn-primary" type="submit">提 交</button>
						<button class="btn btn-primary" type="reset">清 空</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<?php	
	require_once 'template/footer.tpl';
?>