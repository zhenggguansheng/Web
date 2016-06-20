<?php
	require_once 'template/header.tpl';
	require_once 'global.php';
	require_once 'functions.php';
	
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
				// $_SESSION['uid'] = $uid;
				// $_SESSION['user_name'] = $user_name;
				Header("Location:exit.php");
			}
		}
		else
		{
			echo "<script language='javascript'>\n";
			echo "alert(\" $errors \");";
			echo "</script>";
		}
	}
?>
<section class="page container">
	<div class="signin-row row">
		<div class="span4"></div>
		<div class="span8">
			<div class="container-signin">
				<legend><?php echo $MSG_CHANGEPASSWORD ;?></legend>
				<form action="changepass.php" method="post" >
					<div class="form-inner">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-user"></i>  <?php echo ' ' .$MSG_UserID ;?>  </span>
							<input name="user" id="text" maxlength="36" value="<?php echo $user_name ;?>" style="width:75%;overflow-x:visible;overflow-y:visible;text-align:center" disabled="true" />
						</div>
						<div class="input-prepend">
							<span class="add-on"><i class="icon-key"></i> <?php echo $MSG_PasswordNew ;?></span>
							<input name="password1" type="password" id="password1" maxlength="32" style="width:75%;overflow-x:visible;overflow-y:visible"/>
						</div>
						<div class="input-prepend">
							<span class="add-on"><i class="icon-key"></i> <?php echo $MSG_PasswordConfirm ;?> </span>
							<input name="password2" type="password" id="password2" maxlength="32" style="width:75%;overflow-x:visible;overflow-y:visible"/>
						</div>
					</div>
					<footer class="signin-actions" align="center">
						<input class="btn btn-primary" type="submit" name="Submit2" value="Comfirm Change" style="text-align:center"/>
					</footer>
					<div> <br /><?php echo "密码修改后请重新登陆！";?> </div>
				</form>
			</div>
		</div>
	</div>
</section>				

<?php
	require_once 'template/footer.tpl';
?>
</body>