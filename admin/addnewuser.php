<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	
	if(isset($_POST['user']))
	{
		$user_name = $oDD->EscapeString($_POST['user']);
	}
	else{$user_name = "";}
	$num     = $user_name;
	if(isset($_POST['Password']))
	{
		$password  = md5($_POST['Password']);
	}
	else{$password = "";}
	if(isset($_POST['name']))
	{
		$name      = $oDD->EscapeString($_POST['name']);
	}
	else{$name = "";}
	if(isset($_POST['gender']))
	{
		$gender     = $oDD->EscapeString($_POST['gender']);
	}
	else{$gender = "";}
	if(isset($_POST['tel']))
	{
		$tel     = $oDD->EscapeString($_POST['tel']);
	}
	else{$tel = "";}
	if(isset($_POST['college']))
	{
		$college     = $oDD->EscapeString($_POST['college']);
	}
	else{$colege = "";}
	if(isset($_POST['major']))
	{
		$major     = $oDD->EscapeString($_POST['major']);
	}
	else{$major = "";}
	if(isset($_POST['grade']))
	{
		$grade     = $oDD->EscapeString($_POST['grade']);
	}
	else{$grade = "";}
	if(isset($_POST['class']))
	{
		$class     = $oDD->EscapeString($_POST['class']);
	}
	else{$class = "";}
	if(isset($_POST['Email']))
	{
		$email     = $oDD->EscapeString($_POST['Email']);
	}
	else{$email = "";}

	if(!empty($user_name) && !empty($password) && !empty($name) && !empty($email))
	{
		$strSql = "select * from commonuser where user_name = '".$user_name."';";
		$rsResult = $oDD->Query($strSql);
		$count1 = $oDD->NumOfRows($rsResult);
		if($count1==0)
		{
			$strSql = "select max(uid) as uid from commonuser;";
			$rsResult = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
			$uid  = $rsResult + 1;
			$strSql = "insert into commonuser(`user_name`,`password`,`name`,`student_num`,`gender`,`mobilephone`,`college`,`major`,`grade`) values('".$user_name."','".$password."','".$name."','".$user_name."','".$gender."','".$tel."','".$college."','".$major."','".$grade."' );";
			$rsResult = $oDD->Query($strSql);
			if($rsResult)
			{
				Header("Location:setstudentpsd.php");
			}
		}
 		else
		{
			echo "<script language='javascript'>\n";
			echo "alert(\"用户已存在！无须添加...\");";
			echo 'parent.location.href = "admin.php";';
			echo "</script>";
			exit;			
		} 
	}
?>


<section class="container">
    <div class="row">
		<div class="span3">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><p><a href="addnewuser.php" target="contentframe">添加学生</a></p></li>
					<li><p><a href="addbatchnewuser.php" target="contentframe">批量增加学生</a></p></li>
				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>添加学生</h5>
				</div>							
				<form method="post" action="addnewuser.php?action=submit">
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<tbody>
							<tr>
								<td><?php echo $MSG_USER_ID .'(学号):' ;?></td>
								<td><input id="user" name="user" type="text"/></td>
							</tr>
							<tr>
								<td><?php echo $MSG_PASSWORD .':' ;?></td>
								<td><input id="Password" name="Password" type="password" value="" /></td>
							</tr>
							<tr>
								<td><?php echo $MSG_REPEAT_PASSWORD .'密码' .':' ;?></td>
								<td><input id="Password1" name="Password1" type="password" value="" /></td>
							</tr>
							<tr>
								<td><?php echo $MSG_NAME  .':' ;?></td>
								<td><input id="name" name="name" type="text" value="" /></td>
							</tr>
							<tr>
								<td><?php echo $MSG_GENDER  .':' ;?></td>
								<td>
									<input id="gender" name="gender" type="radio" value="1" checked="checked"><?php echo $MSG_MAIL ;?></input>
									<input id="gender" name="gender" type="radio" value="0" ><?php echo $MSG_FEMAIl ;?></input>
							</tr>
							<tr>
								<td><?php echo $MSG_MOBILEPHONE_NUMBER  .':' ;?></td>
								<td><input id="tel" name="tel" type="text" value="" /></td>
							</tr>
							<tr>
								<td><?php echo $MSG_COLLEGE  .':' ;?></td>
								<td><input id="college" name="college" type="text" value="" /></td>
							</tr>
							<tr>
								<td><?php echo $MSG_MAJOR  .':' ;?></td>
								<td><input id="major" name="major" type="text"/></td>
							</tr>
							<tr>
								<td><?php echo $MSG_GRADE  .':' ;?></td>
								<td><input id="grade" name="grade" type="text"/></td>
							</tr>
							<tr>
								<td><?php echo $MSG_CLASS  .':' ;?></td>
								<td><input id="class" name="class" type="text"/></td>
							</tr>
							<tr>
								<td><?php echo $MSG_EMAIL  .':' ;?></td>
								<td><input id="Email" name="Email" type="text" value="abc@msn.com" /></td>
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
