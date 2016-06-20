<?php

	require_once 'template/header.tpl';
	require_once '../global.php';
	require_once("../functions.php");	
	
	if(isset($_SESSION['eeid']))
	{
		$eid = $oDD->EscapeString($_SESSION['eeid']);
	}
	else{$eid = "";}

	/* 
	if(isset($_SESSION['ipaddr']))
	{	
		$ipaddr = $_SESSION['ipaddr'];
	}	
	else {$ipaddr ="";} 
	*/

	if(isset($_POST['username']) && !empty($_POST['username']))
	{
		$user_name = $oDD->EscapeString($_POST['username']);
	}
	else{$user_name = "";}
	
	if(isset($_POST['password']) && !empty($_POST['password']))
	{
		$psd = $_POST['password'];
		$password  = md5($_POST['password']);
	}
	else{$password = "";}

	
	if(!empty($user_name) && !empty($password) && $eid != "")
	{
		$pass = '111111'; //count(b.uid) as counts, 
		$strSql = "SELECT b.uid as uid, b.ip as ip FROM  exam_user AS b WHERE b.eid = '".$eid."'
                      AND b.uid = (SELECT a.uid FROM commonuser AS a 		
		            WHERE  a.user_name = '".$user_name."' AND a.password = '".$password."' );";
		$rsResult = $oDD->Query($strSql);
		$rsRecord = $oDD->FetchArray($rsResult, MYSQLI_ASSOC);
		//$counts = $rsRecord['counts']; //总记录数的值
		$uid = $rsRecord['uid'];
		$ip = $rsRecord['ip'];
		$exam_ip = get_real_ip();
		
		//if ($psd == $pass && empty($rsRecord['ip']))
		if ($psd == $pass)//if (empty($rsRecord['ip']))//首次登录
		{
			$_SESSION['suid'] = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
			$_SESSION['suser_name'] = $user_name;
			
			$_SESSION['eeid'] = $eid;
			
			if(!isset($_SESSION['eeid']))
			{	
				$_SESSION['eeid'] = $eid;
			}
			echo "<script language='javascript'>\n";
			echo "alert(\"初始密码，必须修改！\");";
			echo 'parent.location.href = "changepass.php";';
			echo "</script>";
			exit;
		}
		else if (!(isset($_SESSION['euid'])))
		{
			if ( empty($ip) )
			{
				$strSql_R = "update exam_user set ip = '".$exam_ip."' where eid = '".$eid."' and uid = '".$uid."';";
				$rsResult_R = $oDD->Query($strSql_R);
			}
			else
			{
				if ($ip != $exam_ip)
				{
					echo "<script language='javascript'>\n";
					echo "alert(\" 登录位置不一致! 请在初次登录位置登入系统！\");";
					echo 'parent.location.href = "login.php";';
					echo "</script>";
					exit;	
				}
			}
			$_SESSION['euid'] = $uid;
			$_SESSION['user_name'] = $user_name;
		
			echo "<script language='javascript'>\n";
			echo 'parent.location.href = "exam.php";';
			echo "</script>";
			exit;
		}
		else
		{
			echo "<script language='javascript'>\n";
			echo "alert(\" 用户名或密码错误! \");";
			echo 'parent.location.href = "login.php";';
			echo "</script>";
			exit;
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