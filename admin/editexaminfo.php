<?php
	require_once 'template/header.tpl';
	require_once 'global.php';
	
	confirmlogin();
	unset($_SESSION['cid']);
	unset($_SESSION['kid']);
	
   if(isset($_GET['eid']))
   {
	   $_SESSION['eid'] = $oDD->EscapeString($_GET['eid']);
	   $eid = $_SESSION['eid'];
   }
   else if(isset($_SESSION['eid']))
   {
	   $eid = $_SESSION['eid'];
   }
   else { $eid = "";}
   
   if(isset($_GET["action"]) and $_GET["action"]=="submit")
    {
		$title = $oDD->EscapeString($_POST['title']);
		$description = $oDD->EscapeString($_POST['description']);
		$start_time = $oDD->EscapeString($_POST['start_time']);
		$end_time = $oDD->EscapeString($_POST['end_time']);
		$defunct = $oDD->EscapeString($_POST['RadioGroup1']);
		$timeplus = $oDD->EscapeString($_POST['timeplus']);
		//$kid = $oDD->EscapeString($_POST['course']);
		$sql = "update exam set title='".$title."',description='".$description."',start_time='".$start_time."',end_time='".$end_time."',defunct='".$defunct."',timeplus='".$timeplus."',creator='".$_SESSION['uid']."' where eid='".$eid."';" ;
		$res = $oDD->Query($sql);
		if($res)
		{
			Header("Location:exam.php");
		}
	}
	
	$strSql = "select * from exam where eid='".$eid."';";
	$rsResult = $oDD->Query($strSql);
	$rsExam = $oDD->FetchArray($rsResult,MYSQLI_ASSOC);
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
                <li><p><a href="editexaminfo.php">考试编辑</a></p></li>
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
		<div class="span14">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>编辑考试信息 >>>> <?php echo '         ' .$rsExam['title'];?></h5>
				</div>
				<div class="box-content box-table">
					<form name= form1 method="post" action="editexaminfo.php?action=submit" onSubmit="return formcheck()">
						<table class="table table-hover table-bordered">
							<tbody>
								<tr>
									<td width="10%">考试名称：</td>
									<td>
										<input name="title" style="width:200px;" value="<?php echo $rsExam['title'];?>"/></td>
								</tr>
								<tr>
									<td>考试描述：</td>
									<td>
										<script id="editor1" name="description" type="text/plain" style="width:860px;height:200px;"><?php echo $rsExam['description'];?></script>
										<script type="text/javascript">var ue1 = UE.getEditor('editor1');</script>
									</td>
								</tr>
								<tr>
									<td>开始时间：</td>
									<td><input name="start_time" style="width:250px;" value="<?php echo $rsExam['start_time'];?>"/>&nbsp;日期格式：yyyy-MM-dd hh:mm:ss</td>
								</tr>
								<tr>
									<td>结束时间：</td>
									<td><input name="end_time"  style="width:250px;" value="<?php echo $rsExam['end_time'];?>"/>&nbsp;日期格式：yyyy-MM-dd hh:mm:ss</td>
								</tr>
								<tr>
									<td>是否可见：</td>
									<td>
									  <label><input <?php if (!(strcmp($rsExam['defunct'],"Y"))) {echo "checked=\"checked\"";} ?> type="radio" name="RadioGroup1" value="Y" id="RadioGroup1_0" />是</label>
									  <label><input <?php if (!(strcmp($rsExam['defunct'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="RadioGroup1" value="N" id="RadioGroup1_1" />否</label>
									 </td>
								</tr>
								<tr>
									<td>罚时：</td>
									<td><input name="timeplus" value="<?php echo $rsExam['timeplus'];?>" style="width:150px;"/>min</td>
								</tr>
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
