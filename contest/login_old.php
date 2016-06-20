<?php

	require_once 'template/header.tpl';
	require_once 'global.php';
	if(isset($_SESSION['user_name']))
	{
		echo "<script language='javascript'>\n";
		echo "alert(\"请先注销用户！\");";
		echo 'parent.location.href = "exit.php";';
		echo "</script>";
	}
	
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
			$_SESSION['uid'] = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
			$_SESSION['user_name'] = $user_name;
			echo "<script language='javascript'>\n";
			echo 'parent.location.href = "home.php";';
			echo "</script>";
		}
		else
		{
			echo "<script language='javascript'>\n";
			echo "alert(\"用户名或密码错误!\");";
			echo "</script>";
		}
	}
?>
<div id="table">
  <div id="login">
     <div id="login-menu"><?php echo $MSG_Member_Login ;?></div>
		<div id="login-table">
		<form action="login.php" method="post" >
		   <table>
			<tr> 
			    <td ><?php echo $MSG_UserID ;?></td>
			    <td><input name="username" type="text" id="username" /></td>
			</tr>
			<tr>
			    <td><?php echo $MSG_Password ;?></td>
			    <td><input name="password" type="password" id="password" maxlength="32" /></td>
			</tr>
			<tr> 
				<td height="30px">&nbsp;</td> 
				<td> 
					<input type="submit" name="Submit2" value="Login"  style="border:1px solid #999;" />
				</td> 
			</tr> 
        </table>
		</form>
	  </div>
</div>
</div>
<div style="clear: both;">&nbsp;</div>
</div>
<?php
	require_once 'template/footer.tpl';
?>
</body>