<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	$type = '1';
	unset($_SESSION['eid']);
	unset($_SESSION['kid']);

   if(isset($_GET["action"]) and $_GET["action"]=="submit" )
    {
		$title = $oDD->EscapeString($_POST['title']);
		if (!empty($title)){
			$description = $oDD->EscapeString($_POST['description']);
			$start_time = $oDD->EscapeString($_POST['start_time']);
			$end_time = $oDD->EscapeString($_POST['end_time']);
			$defunct = $oDD->EscapeString($_POST['RadioGroup1']);
			$timeplus = $oDD->EscapeString($_POST['timeplus']);
			$sql = "insert into contest (title,description,start_time,end_time,defunct,timeplus,creator) values ('".$title."','".$description."','".$start_time."','".$end_time."','".$defunct."','".$timeplus."','".$_SESSION['uid']."');";
			
			$res = $oDD->Query($sql);
			if($res)
			{
				Header("Location:contest.php");
			}
		}
	}
?>


<script src="../ubuilder/ueditor.config.js"></script>
<script src="../ubuilder/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../ubuilder/zh-cn/zh-cn.js"></script>


<section class="page container">
    <div class="row">
		<div class="span2">
			<div class="blockoff-left">
				<ul class="nav nav-list">
           		<li><p><a href="contest.php">竞赛管理</a></p></li>
				</ul>
			</div>
		</div>
		<div class="span14">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>新建竞赛</h5>
				</div>
				<div class="box-content box-table">
					<form  name= form1 method="post" action="newcontest.php?action=submit" onSubmit="return formcheck()">
					<table class="table table-hover table-bordered">
						<tbody>
							<tr>
								<td>竞赛名称：</td>
								<td><input name="title" value=""  style="width:92.5%;"/></td>
							</tr>
							<tr>
								<td>竞赛描述：</td>
								<td>
									<script id="editor1" name="description" type="text/plain" style="width:900px;height:200px;"></script>
									<script type="text/javascript">var ue1 = UE.getEditor('editor1');</script>
								</td>
							</tr>
							<tr>
								<td>开始时间：</td>
								<td><input name="start_time" value="" style="width:150px;"/>日期格式：yyyy-MM-dd hh:mm:ss</td>
							</tr>
							<tr>
								<td>结束时间：</td>
								<td><input name="end_time"   value="" style="width:150px;"/>日期格式：yyyy-MM-dd hh:mm:ss</td>
							</tr>
							<tr>
								<td>是否可见：</td>
								<td>
								  <label>
									<input type="radio" name="RadioGroup1" value="Y" id="RadioGroup1_0" />
									是</label>
								  <label>
									<input type="radio" name="RadioGroup1" value="N" id="RadioGroup1_1" />
									否</label>
								 </td></tr>
							<tr>
								<td>罚时：</td>
								<td><input name="timeplus" value="" style="width:90px;"/>min</td>
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