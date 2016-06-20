<?php

	require_once 'template/header.tpl';
	require_once '../global.php';
	require_once '../functions.php';	
	
	if(isset($_POST['username']) && !empty($_POST['username']))
	{
		$user_name = $oDD->EscapeString($_POST['username']);
	}
	else{$user_name = "";}
	if(isset($_POST['password']) && !empty($_POST['password']))
	{
		$password  = md5($_POST['password']);
	}
	else{$password = "";}
	
	if(!empty($_POST['username']) && !empty($_POST['password']))
	{
		$strSql = "select * from commonuser where user_name = '".$user_name."' and password = '".$password."';";
		$rsResult = $oDD->Query($strSql);
		$count = $oDD->NumOfRows($rsResult);
		if($count == 1)
		{
			if ( $password != md5('111111') )
			{
				$_SESSION['uid'] = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
				$_SESSION['user_name'] = $user_name;
				
				echo "<script language='javascript'>\n";
				echo 'parent.location.href = "problemlist.php";';
				echo "</script>";
			}
			else
			{
				$_SESSION['suid'] = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
				$_SESSION['suser_name'] = $user_name;
				echo "<script language='javascript'>\n";
				echo "alert(\"初始密码，必须修改！\");";
				echo 'parent.location.href = "changepass.php";';
				echo "</script>";
				exit;
			}
		
		}
		else
		{
			echo "<script language='javascript'>\n";
			echo "alert(\"用户名或密码错误!\");";
			echo "</script>";
		}
	}
?>
 <section class="page container">
	<div class="signin-row row">
		<div class="span4"></div>
		<div class="span8">
			<div class="container-signin">
				<legend><?php echo $MSG_Member_Login ;?></legend>
				<form action="login.php" method="post" >
					<div class="form-inner">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-user"></i></span>
							<input name="username" class="span4" type="text"/>
						</div>
						<div class="input-prepend">
							<span class="add-on"><i class="icon-key"></i></span>
							<input name="password"  class="span4"  type="password"/>
						</div>
					</div>
					<footer class="signin-actions">
						<input class="btn btn-primary" type="submit" name="Submit2" value="Login"/>
					</footer>
				</form>
			</div>
		</div>
	</div>
</section>
<?php
	require_once 'template/footer.tpl';
?>