<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	
	if(isset($_GET['id']))
   {
	   $_SESSION['id'] = $oDD->EscapeString($_GET['id']);
	   $id = $_SESSION['id'];
   }
   else if(isset($_SESSION['id']))
   {
	   $id = $_SESSION['id'];
   }
   else { $id = "";}
	
	$strSql = "select * from manageruser where uid = '".$id."';";
	$rsResult = $oDD->Query($strSql);
	$manager = $oDD->FetchArray($rsResult,MYSQLI_ASSOC);
	
    if(isset($_GET["action"]) and $_GET["action"]=="submit")
    {
		if(isset($_POST['name']))
		{
		   $name = $oDD->EscapeString($_POST['name']);
		}
		else 
		{
			$name = $manager['name'];
		}
		if(isset($_POST['RadioGroup1']))
		{
			$gender = $oDD->EscapeString($_POST['RadioGroup1']);
		}
		else 
		{
			$gender = $manager['gender'];
		}
		if(isset($_POST['password']))
		{
			$password = md5($oDD->EscapeString($_POST['password']));
		}
		else 
		{
			$password = md5($manager['password']);;
		}		
		if(isset($_POST['mobilephone']))
		{
			$mobilephone = $oDD->EscapeString($_POST['mobilephone']);
		}
		else 
		{
			$mobilephone = $manager['mobilephone'];
		}
		if(isset($_POST['email']))
		{
			$email =  $oDD->EscapeString($_POST['email']);
		}
		else 
		{
			$email = $manager['email'];;
		}
		
		$sql = "update manageruser set name='".$name."',gender='".$gender."',password='".$password."',mobilephone='".$mobilephone."',`e-mail`='".$email."' where uid = '".$id."';";
		echo $sql;
		$res = $oDD->Query($sql);

		if($res)
		{
			Header("Location:manageruser.php");
		}
	}
	
?>

<Script Language="JavaScript" type="text/JavaScript" src="include/js/showo_page.js"></Script>


<section class="container">
    <div class="row">
		<div class="span3">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><p><a href="newmanager.php">添加管理员</a></p></li>
					<li><p><a href="adminstatus.php">测试记录</a></p></li>
					<li><p><a href="deletejudging.php">解决Judging</a></p></li>
 				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>教师个人账号设置</h5>
				</div>							
				<div class="box-content box-table">
					<form method="post" action="edituserinfo.php?action=submit" >
					<table class="table table-hover table-bordered">
						<tbody>
							<tr>
								<td width="10%">用户名称：</td>
								<td width="50%"><input name="username" value="<?php echo $manager['user_name'];?>"/></td>
								<td width="2%"></td>
							</tr>
							<tr>
								<td width="10%">用户类别：</td>
								<td width="50%"><input name="name" value="<?php echo $manager['name'];?>"/></td>
								<td width="2%"></td>
							</tr>
							<tr>
								<td>性别：</td>
								<td> 
								<label><input type="radio" name="RadioGroup1" value="1" id="RadioGroup1_1" <?php if($manager['gender'] == 1){echo 'checked="checked"';}?>/>男</label>
								<label><input type="radio" name="RadioGroup1" value="0" id="RadioGroup1_0" <?php if($manager['gender'] == 0){echo 'checked="checked"';}?>/>女</label></td>
								<td></td>
							</tr>
							<tr>
								<td>新密码：</td>
								<td><input name="password" type="password" style="width:150px;"/></td>
								<td></td>
							</tr>
							<tr>
								<td>联系号码：</td>
								<td><input name="mobilephone" value="<?php echo $manager['mobilephone'];?>" style="width:200px;"/></td>
								<td></td>
							</tr>
							<tr>
								<td>邮箱地址：</td>
								<td><input name="email" value="<?php echo $manager['e-mail'];?>" style="width:200px;"/></td>
								<td></td>
							</tr>
						</tbody>
					</table>
					<div class="page-container"">
						<Script Language="JavaScript">
								ShowoPage("","","<div class=\"alert alert-block alert-info\" style = \"TEXT-ALIGN:center\";><div>页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
						</Script>
						</div></div>
					</div>
					<div class="box-footer">
							<button  onclick="selectItems();">添加</button>
							<button  onClick="location.href='editproblem.php'">取消</button>
					</div>
				</div>
			</div>
		</div>	
    </div>

</section>

<?php	
	require_once 'template/footer.tpl';
?>
