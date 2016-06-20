<?php
	require_once 'template/header.tpl';
	require_once 'global.php';
	
	confirmlogin();
	unset($_SESSION['cid']);
	unset($_SESSION['eid']);
 
	 //    confirmlogin();	
	if(isset($_GET['kid']))
	{
	   $_SESSION['kid'] = $oDD->EscapeString($_GET['kid']);
	   $kid = $_SESSION['kid'];
	}
	else if(isset($_SESSION['kid']))
	{
	   $kid = $_SESSION['kid'];
	}
	else { $kid = "";}
   
    if ($_SERVER['REQUEST_METHOD'] == "POST" )
    {
	   if(isset($_GET["action"]) and $_GET["action"]=="submit")
		{
			$title = $oDD->EscapeString($_POST['title']);
			$description = $oDD->EscapeString($_POST['description']);
			$start_time = $oDD->EscapeString($_POST['start_time']);
			$end_time = $oDD->EscapeString($_POST['end_time']);
			
			$sql = "Update course set coursename='".$title."', description = '".$description."', start_time='".$start_time."',end_time='".$end_time."' where kid='".$kid."';" ;
			$res = $oDD->Query($sql);
			if($res)
			{
				Header("Location:course.php");
			}
		}	
    }
	$strSql = "select * from course where kid='".$kid."';";
	$rsResult = $oDD->Query($strSql);
	$rsCourse = $oDD->FetchArray($rsResult,MYSQLI_ASSOC);
?>
	 

<meta charset="utf-8">
<script src="../ubuilder/ueditor.config.js"></script>
<script src="../ubuilder/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../ubuilder/zh-cn/zh-cn.js"></script>

<section class="page container">
    <div class="row">
		<div class="span2">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><p><a href="course.php">课程管理</a></p></li>
					<li><p><a href="editcourseinfo.php">信息编辑</a></p></li>
					<li><p><a href="editproblem.php">题目列表</a></p></li>
					<li><p><a href="addproblem.php">添加题目</a></p></li>
					<li><p><a href="editstudent.php">学生列表</a></p></li>
					<li><p><a href="addstudent.php">添加学生</a></p></li>
					<li><p><a href="status.php">状态</a></p></li>
					<li><p><a href="ranklist.php">排名</a></p></li>
					<li><p><a href="statistics.php">统计</a></p></li>
 				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>编辑课程信息 >>>> <?php echo '         ' . $rsCourse['coursename'];?></h5>
				</div>
				<div class="box-content box-table">
					<form name= form1 method="post" action="editcourseinfo.php?action=submit" >
						<table class="table table-hover table-bordered">
							<tbody>
								<tr><td style="width:10%;">课程名称：</td>
									<td><input name="title" style="width:80%;" value="<?php echo $rsCourse['coursename'];?>"/></td>
								</tr>
								<tr>
								<td>课程描述：</td>
									<td><script id="editor1" name="description" type="text/plain" style="width:100%;height:200px;"><?php echo $rsCourse['description'];?></script>
										<script type="text/javascript">	var ue1 = UE.getEditor('editor1');</script>
									</td>
								</tr>
								<tr><td>开始时间：</td>
									<td><input name="start_time" style="width:40%;" value="<?php echo $rsCourse['start_time'];?>"/>&nbsp;日期格式：yyyy-MM-dd hh:mm:ss(例如:2016-01-31 12:30:00)</td>
								</tr>
								<tr><td>结束时间：</td>
									<td><input name="end_time"  style="width:40%;" value="<?php echo $rsCourse['end_time'];?>"/>&nbsp;日期格式：yyyy-MM-dd hh:mm:ss</td>
								</tr>
								<tr>
							</tbody>
						</table>
						<div class="box-footer">
							<button class="btn btn-primary" onclick="selectItems();">提交</button>
							<button class="btn btn-primary" onClick="location.href='editproblem.php'">取消</button>
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
