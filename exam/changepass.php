<?php
	require_once 'template/header.tpl';
	require_once '../global.php';
	require_once '../functions.php';
	
	$errors = 'OK';
	
	$ip =  $oDD->EscapeString(getIp());	

	if(isset($_SESSION['suid']))
	{
		$uid = $oDD->EscapeString($_SESSION['suid']);
	}
	else{$uid = "";}

	if(isset($_SESSION['eeid']))
	{
		$eid = $oDD->EscapeString($_SESSION['eeid']);
	}
	else{$eid = "";}
	
	if(isset($_SESSION['suser_name']))
	{
		$user_name = $oDD->EscapeString($_SESSION['suser_name']);
	}else{$user_name="";}
	if (empty($user_name))
	{
		echo "<script language='javascript'>\n";
		echo "alert(\" 错误原因： \\n  用户名为空无法修改密码！ \");";
		echo 'parent.location.href = "../home.php";';
		echo "</script>";
		exit;
	}
	if( isset($_POST['password0']) )
	{
		$password0 = $oDD->EscapeString($_POST['password0']);
	}else {$password0 = "";}
	
	if (!empty($password0) && !empty($user_name))
	{
		
		if ($password0 != '111111')
		{
			echo "<script language='javascript'>\n";
			echo "alert(\" 错误原因： \\n  1. 原始密码出错!  \\ 2. 无法修改密码 \");";
			echo 'parent.location.href = "login.php";';
			echo "</script>";
			exit;
		}			
		$strSql = "SELECT  b.uid,b.ip FROM  exam_user AS b WHERE b.eid = '".$eid."'
                      AND b.uid = (SELECT a.uid FROM commonuser AS a 		
		            WHERE  a.user_name = '".$user_name."' AND a.password = md5('".$password0."') );";
		
		$rsResult = $oDD->Query($strSql);
		$rsRecord = $oDD->FetchArray($rsResult, MYSQLI_ASSOC);
		$uid = $rsRecord['uid'];
		$initialip = $rsRecord['ip'];

/* 		$strSqlt = "SELECT count(b.uid) as counts,b.uid as uid FROM  exam_user AS b WHERE b.ip = '".$ip."';";
		$rsResultt = $oDD->Query($strSqlt);
		$rsRecordt = $oDD->FetchArray($rsResultt, MYSQLI_ASSOC);
		if ( $rsRecordt['totle'] >= 1 && $uid != $rsRecordt['uid'] )
		{
			echo "<script language='javascript'>\n";
			echo "alert(\" 以下错误导致无法修改密码： \\n  机器已占用,不能修改密码!  \");";
			echo 'parent.location.href = "login.php";';
			echo "</script>";
			exit;
			
		} */
		
		if ( empty($uid) )
		{
			echo "<script language='javascript'>\n";
			echo "alert(\" 以下错误导致无法修改密码： \\n  1. 原始密码出错!  \\n  2. 不能在非考试环境中修改密码!  \");";
			echo 'parent.location.href = "login.php";';
			echo "</script>";
			exit;
		}
	}
	
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
	
	if (!empty($errors)) 
	{
		echo "<script language='javascript'>\n";
		echo "alert(\" $errors \");";
		echo "</script>";
	//	exit;
	}
	$ip = get_real_ip();
	if (!empty($uid))
	{
		if(!empty($password1) && !empty($password2) && !empty($ip) && !empty($eid) )
		{
			$password1 = md5($password1);
			$strSql_S = "update commonuser set password = '".$password1."' where uid = '".$uid."';";
			$rsResult_S = $oDD->Query($strSql_S);
		
			$strSql_R = "update exam_user set ip = '".$ip."' where eid = '".$eid."' and uid = '".$uid."';";
			$rsResult_R = $oDD->Query($strSql_R);
			
			$_SESSION['ipaddr'] = $ip;
		
			if(!isset($_SESSION['ipaddr']))
			{	
				$_SESSION['ipaddr'] = $ip;
			}
		
			if($rsResult_S && $rsResult_R)
			{
				echo "<script language='javascript'>\n";
				echo "alert(\" 修改成功，请重新登录！ \");";
				echo 'parent.location.href = "login.php";';
				echo "</script>";
				//Header("Location:../exit.php");
				exit;
			}
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
							<input class="btn btn-primary" type="submit" name="Submit2" value="Change Password"/>
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