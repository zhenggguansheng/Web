<?php
	require_once 'template/header.tpl';
	require_once '../global.php';
	require_once '../functions.php';
	
	$errors = '';
	if(isset($_SESSION['suid']))
	{
		$uid = $oDD->EscapeString($_SESSION['suid']);
	}
	else{$uid = "";}
	
	if(isset($_SESSION['suser_name']))
	{
		$user_name = $oDD->EscapeString($_SESSION['suser_name']);
	}else{$user_name="";}

	if( isset($_POST['password1']) )
	{
		$password1 = $oDD->EscapeString($_POST['password1']);
	}else
		$password1 = "";
	if( isset($_POST['password2']) )
	{
		$password2 = $oDD->EscapeString($_POST['password2']);
	}else
		$password2 = "";

    $errors = validate($password1, $password2);
	
	if(!empty($_POST['password1']) && !empty($_POST['password2']))
	{
		if (empty($errors)) {
			$password1 = md5($password1);
			$strSql_S = "update commonuser set password = '".$password1."' where uid = '".$uid."';";
			$rsResult_S = $oDD->Query($strSql_S);
			if($rsResult_S)
			{
				echo "<script language='javascript'>\n";
				echo "alert(\" 密码修改成功！请重新登录！ \");";
				echo "</script>";
				Header("Location:../exit.php");
				exit;
			}
		}
		else
		{
			echo "<script language='javascript'>\n";
			echo "alert(\" $errors \");";
			echo "</script>";
			exit;
		}
	}
?>

<section class="page container">
	<div id="body-content">
		<div class='container'>
			<div class="row">
				<div class="span4"></div>
				<div class="span8">
				<div class="container-signin">
					<legend>Change Password</legend>
					<form action="changepass.php" method="post" >
						<div class="form-inner">
							<div>
								<span class="add-on"><i class="icon-user"><?php echo $user_name ;?></i></span>
							</div>
							<div class="input-prepend">
								<span class="add-on"><i class="icon-key"><?php echo $MSG_PasswordNew ;?></i></span>
								<input name="password1" type="password" id="password1" class="span4"/>
							</div>
							<div class="input-prepend">
								<span class="add-on"><i class="icon-key"><?php echo $MSG_PasswordConfirm ;?></i></span>
								<input name="password2" type="password" id="password2"  class="span4"/>
							</div>
						</div>
						<footer class="signin-actions">
							<input class="btn btn-primary" type="submit" name="Submit2" value="Login"/>
						</footer>
					</form>
				</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
	require_once 'template/footer.tpl';
?>
</body>