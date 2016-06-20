<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	$type = '1';
	unset($_SESSION['cid']);
	unset($_SESSION['eid']);
	
	if(isset($_GET["action"]) and $_GET["action"]=="submit" )
	{
		$coursename = $oDD->EscapeString($_POST['title']);
		$description = $oDD->EscapeString($_POST['description']);
		$start_time = $oDD->EscapeString($_POST['start_time']);
		$end_time = $oDD->EscapeString($_POST['end_time']);
		if (!empty($coursename))
		{
			$strSql = "insert into course(coursename,creator,description,start_time,end_time) values('".$coursename."','".$_SESSION['uid']."','".$description."','".$start_time."','".$end_time."');";
			$result = $oDD->Query($strSql);
			if($result)
			{
				Header("Location:course.php");
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
           		<li><p><a href="course.php">课程管理</a></p></li>
				</ul>
			</div>
		</div>
		<div class="span14">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>新建课程</h5>
				</div>
				<div class="box-content box-table">
					<form name = course method = "post" action="newcourse.php?action=submit">
					<table class="table table-hover table-bordered">
						<tbody>
							<tr>
								<td>课程名称</td>
								<td><input name="title" value="" style="width:150px;"/></td>
							</tr>
							<tr>
								<td>课程描述：</td>
								<td><script id="editor1" name="description" type="text/plain" style="width:100%;height:200px;"></script>
									<script type="text/javascript">	var ue1 = UE.getEditor('editor1');</script>
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