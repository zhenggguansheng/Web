<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	
   if(isset($_GET["action"]) and $_GET["action"]=="submit")
    {
                $user_name= $oDD->EscapeString($_POST['user_name']);
                $password1 = $oDD->EscapeString($_POST['password']);
                $password = MD5($password1);
                $name = $oDD->EscapeString($_POST['name']);
                $gender = $oDD->EscapeString($_POST['RadioGroup1']);
                $mobilephone = $oDD->EscapeString($_POST['mobilephone']);
                $email = $oDD->EscapeString($_POST['email']);
                $authority = 1;
                $sql = "insert into manageruser (`user_name`,`password`,`name`,`gender`,`mobilephone`,`e-mail`,`authority_id`) values ('".$user_name."','".$password."','".$name."','".$gender."','".$mobilephone."','".$email."','".$authority."');";
                $res = $oDD->Query($sql);
                if($res)
                {
                        Header("Location:manageruser.php");
                }
        }
?>

<section class="container">
    <div class="row">
		<div class="span3">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><p><a href="manageruser.php">管理员列表</a></p></li>
					<li><p><a href="adminstatus.php">测试记录</a></p></li>
 				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>添加教师</h5>
				</div>							
				<div class="box-content box-table">
					<form method="post" action="newmanager.php?action=submit">
					<table class="table table-hover table-bordered">
						<tbody>
							<tr>
							  <td width="10%">*用户名：</td>
							  <td><input name="user_name" style="width:150px;" /></td>
							</tr>
							<tr>
							  <td>*密码：</td>
							  <td><input name="password" type="password" style="width:150px;" /></td>
							</tr>
							<tr>
							  <td>*昵称：</td>
							  <td><input name="name" style="width:150px;" /></td>
							</tr>
							<tr>
							  <td>性别：</td>
							  <td><label><input type="radio" name="RadioGroup1" value="1" id="RadioGroup1_1" />男</label> 
											  <label><input type="radio" name="RadioGroup1" value="0" id="RadioGroup1_0" />女</label></td>
							</tr>
							<tr>
							  <td>联系号码：</td>
							  <td><input name="mobilephone" style="width:200px;" /></td>
							</tr>
							<tr>
							  <td>邮箱地址：</td>
							  <td><input name="email" style="width:200px;" /></td>
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