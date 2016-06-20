<?php
	require_once 'template/header.tpl';
	require_once 'global.php';
	confirmlogin();
 /*    if(isset($_GET['cid']))
	{
	    $cid= $oDD->EscapeString($_GET['cid']);
		$_SESSION['cid'] = $cid;
		if(!isset($_SESSION['cid']))
			$_SESSION['cid'] = $cid;
	}
	else { $cid = "";} */
	
	if(isset($_GET['cid']))
    {
	   $_SESSION['cid'] = $oDD->EscapeString($_GET['cid']);
	   $cid = $_SESSION['cid'];
    }
    else if(isset($_SESSION['cid']))
    {
	   $cid = $_SESSION['cid'];
    }
    else { $cid = "";}
	
	if(isset($_GET["action"]) and $_GET["action"]=="submit")
	{
		$title = $oDD->EscapeString($_POST['title']);
		$description = $oDD->EscapeString($_POST['description']);
		$start_time = $oDD->EscapeString($_POST['start_time']);
		$end_time = $oDD->EscapeString($_POST['end_time']);
		$defunct = $oDD->EscapeString($_POST['RadioGroup1']);
		$timeplus = $oDD->EscapeString($_POST['timeplus']);
		$strSql = "update contest set `title`='".$title."',`description`='".$description."',`start_time`='".$start_time."',
									`end_time`='".$end_time."',`defunct`='".$defunct."',`timeplus`='".$timeplus."',
									`creator`='".$_SESSION['uid']."'
						where cid='".$cid."';" ;
		
		echo $strSql;
		$res = $oDD->Query($strSql);
		if($res)
		{
			Header("Location:contest.php");
		}
	}
	
	$strSql = "select * from contest where cid='".$cid."';";
	$rsResult = $oDD->Query($strSql);
	$rsContest = $oDD->FetchArray($rsResult,MYSQLI_ASSOC);
?>
<script src="../ubuilder/ueditor.config.js"></script>
<script src="../ubuilder/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../ubuilder/zh-cn/zh-cn.js"></script>
<script Language="JavaScript" type="text/JavaScript" src="../include/js/showo_page.js"></script>

<script>
    	function formcheck(){
			var strP = /^\d+$/;
			if(!strP.test(theProblem.time_limit.value)){
				alert('时间限制必须是数字！');
				return false;
			}
			if(!strP.test(theProblem.memory_limit.value)){
				alert('空间限制必须是数字！');
				return false;
			}
			return true;
		}
</script>


<section class="container">
    <div class="row">
		<div class="span2">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><p><a href="editcontestinfo.php">信息编辑</a></p></li>
					<li><p><a href="editproblem.php">题目列表</a></p></li>
					<li><p><a href="addproblem.php">添加题目</a></p></li>
					<li><p><a href="editstudent.php">学生列表</a></p></li>
					<li><p><a href="addstudent.php">添加学生</a></p></li>
					<li><p><a href="status.php">状态</a></p></li>
					<li><p><a href="ranklist.php">排名</a></p></li>
					<li><p><a href="statistics.php">统计</a></p></li>
					<li><p><a href="putColor.php">气球登记</a></p></li>
				</ul>
			</div>
		</div>
		<div class="span14">
			<div class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i><h5><?php echo $rsContest['title'];?></h5>
				</div>
				<div class="box-content box-table">
					<form name= form1 method="post" action="editcontestinfo.php?action=submit" onSubmit="return formcheck()">
						<table class="table table-hover table-bordered">
							<tr>
								<td>竞赛名称：</td>
								<td><input name="title" value="<?php echo $rsContest['title'];?>" style="width:92.5%;"/></td>
							</tr>
							<tr>
								<td>竞赛描述：</td>
								<td>
									<script id="editor1" name="description" type="text/plain" style="width:900px;height:200px;"><?php echo $rsContest['description'];?></script>
									<script type="text/javascript">	var ue1 = UE.getEditor('editor1');</script>
								</td>
							</tr>
							<tr>
								<td>开始时间：</td>
								<td><input name="start_time"  style="width:250px;" value="<?php echo $rsContest['start_time'];?>"/>&nbsp;日期格式：yyyy-MM-dd hh:mm:ss</td>
							</tr>
							<tr>
								<td>结束时间：</td>
								<td><input name="end_time"  style="width:250px;" value="<?php echo $rsContest['end_time'];?>"/>&nbsp;日期格式：yyyy-MM-dd hh:mm:ss</td>
							</tr>
							<tr>
								<td>是否可见：</td>
								<td>
								  <label>
									<input <?php if (!(strcmp($rsContest['defunct'],"Y"))) {echo "checked=\"checked\"";} ?> type="radio" name="RadioGroup1" value="Y" id="RadioGroup1_0" />
									是</label>
								  <label>
									<input <?php if (!(strcmp($rsContest['defunct'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="RadioGroup1" value="N" id="RadioGroup1_1" />
									否</label>
								 </td></tr>
							<tr>
								<td>罚时：</td>
								<td><input name="timeplus" value="<?php echo $rsContest['timeplus'];?>" style="width:150px;"/>min</td>
							</tr>
						</table>
						<div class="box-footer">
							<button class="btn btn-primary" type="submit">提 交</button>
							<button class="btn btn-primary" type="reset">恢复初始设置</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</section>


</script>            
<?php	
	require_once 'template/footer.tpl';
?>
