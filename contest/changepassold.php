<?php
	require_once 'template/header.tpl';
	require_once 'global.php';
	require_once 'functions.php';
	
	$errors = '';
	if(isset($_SESSION['suid']))
	{
		$suid = $oDD->EscapeString($_SESSION['suid']);
	}
	else{$uid = "";}
	
	if(isset($_SESSION['suser_name']))
	{
		$suser_name = $oDD->EscapeString($_SESSION['suser_name']);
	}else{$suser_name="";}

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
			$strSql_S = "update commonuser set password = '".$password1."' where uid = '".$suid."';";
			$rsResult_S = $oDD->Query($strSql_S);

			$_SESSION['uid'] = $suid;
			$_SESSION['user_name'] = $suser_name;
			Header("Location:home.php");
		}
		else
		{
			echo "<script language='javascript'>\n";
			echo "alert(\" $errors \");";
			echo "</script>";
		}
	}
?>


<div id="table">
    <div id="login-menu"><?php echo $MSG_CHANGEPASSWORD ;?></div>
		<div id="login-table">
		<form action="changepass.php" method="post" >
		   <table>
			<tr> 
			    <td align="center"><?php echo $MSG_UserID ;?></td>
			    <td ><?php echo $user_name ;?></td>
			</tr>
			<tr>
				<td align="center"><?php echo $MSG_PasswordNew ;?></td>
			    <td><input name="password1" type="password" id="password1" maxlength="32" /></td>
			</tr>
			<tr>
			    <td align="center"><?php echo $MSG_PasswordConfirm ;?></td>
			    <td><input name="password2" type="password" id="password2" maxlength="32" /></td>
			</tr>
			<tr> 
				<td height="30px">&nbsp;</td> 
				<td> 
					<input type="submit" name="Submit2" value="Comfirm Change"  style="border:1px solid #999;" />
				</td> 
			</tr> 
        </table>
		</form>
	  </div>
</div>

<?php
	require_once 'template/footer.tpl';
?>
</body>