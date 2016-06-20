<?php
	require_once 'global.php';
	require_once 'template/header.tpl';

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
	if(isset($_POST['seat']) && !empty($_POST['seat']))
	{
		$seat = $oDD->EscapeString($_POST['seat']);
	}
	else{$seat = "";}
	if(isset($_POST['room']) && !empty($_POST['room']))
	{
		$room = $oDD->EscapeString($_POST['room']);
	}
	else{$room = "";}
	
	if(!empty($user_name) && !empty($password) && !empty($room) && !empty($seat) && !isset($_SESSION['power']))
	{
		$strSql = "select uid from contest_user where uid = ( select uid from commonuser where user_name = '".$user_name."' and password = '".$password."') and room='".$room."' and  seat='".$seat."';";
        $rsResult = $oDD->Query($strSql);
		$count = $oDD->NumOfRows($rsResult);
		if($count == 1)
		{
			$_SESSION['cuid'] = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
			$_SESSION['user_name'] = $user_name;
			$_SESSION['room'] = $room;
			$_SESSION['seat'] = $seat;
			echo "<script language='javascript'>\n";
			echo 'parent.location.href = "contestlist.php";';
			echo "</script>";
		}
		else
		{
			session_destroy();
            echo "<script language='javascript'>\n";
			echo "alert(\"用户名或密码错误!\");";
			echo 'parent.location.href = "../home.php";';
			echo "</script>";
		}
	}
?>
<div id="table">
  <div id="login">
     <div id="login-menu"><?php echo $MSG_Member_Login ;?></div>
		<div id="login-table">
		<form action="contestlogin.php" method="post" >
		   <table>
		        <tr> 
				   <td><?php echo $MSG_UserID ;?></td>
				   <td><input name="username" type="text" id="username" /></td>
				</tr>
				<tr>
				   <td><?php echo $MSG_Password ;?></td>
				   <td><input name="password" type="password" id="password"/></td>
				</tr>
				<tr>
				   <td><?php echo $MSG_txtRoom ;?></td>
				    <td><input name="room" type="text" id="room"/></td>
				</tr>
				<tr> 
				   <td><?php echo $MSG_txtSeat ;?></td>
				   <td><input name="seat" type="text" id="seat" /></td>
			    </tr>
				
			</table>
			<input type="submit" name="Submit2" value="Login"  style="border:1px solid #999;" />
		</form>
	  </div>
</div>
</div>
<div style="clear: both;">&nbsp;</div>
</div>
<?php
	require_once 'template/footer.tpl';
?>