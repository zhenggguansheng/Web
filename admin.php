<?php
	require_once("global.php");
	require_once ("lang/cn.php");
	require_once 'template/header.tpl';
	$LoginMessage = 0;
	if ($_SERVER['REQUEST_METHOD'] == "POST" )
	{
		if(isset($_SESSION['user_name']))
		{
			echo "<script language='javascript'>\n";
			echo "alert(\"请先注销用户！\");";
			echo 'parent.location.href = "./admin/exit.php";';
			echo "</script>";
			exit;
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
			$strSql = "select * from manageruser where user_name = '".$user_name."' and password = '".$password."';";
			$rsResult = $oDD->Query($strSql);
			
			$count = $oDD->NumOfRows($rsResult);

			if($count == 1)
			{
				$_SESSION['uid'] = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
				$_SESSION['foradminuser'] = $oDD->GetValue($strSql, MYSQLI_NUM, 1);
				$_SESSION['user_name'] = $user_name;
				if(($authority_id= $oDD->GetValue($strSql, MYSQLI_NUM, 3))==0)
				{
					$_SESSION['power'] = "admin";
				}
				else
				{
					$_SESSION['power'] = "teacher";
				}
				
				header("Location: admin/admin.php");
				exit;
			}
			else
			{
				$LoginMessage = 1;
			}
		}
	}
?>

<section class="page container">
              
	<div class="signin-row row">
		<div class="span4"></div>
		<div class="span8">
			<div class="container-signin">
				<legend>Please Login</legend>
				<form action='admin.php' method='POST' id='loginForm' class='form-signin' autocomplete='off'>
					<div class="form-inner">
						<div class="input-prepend">
							<span class="add-on" rel="tooltip" title="Username or E-Mail Address" data-placement="top"><i class="icon-user"></i></span>
							<input class="input pw2" name="username" type="text" tabindex="1" />
						</div>
						<div class="input-prepend">
							<span class="add-on"><i class="icon-key"></i></span>
							<input class="input pwpd2" name="password" type="password" tabindex="2" />
						</div>
					</div>
					<footer class="signin-actions">
						<input class="btn btn-primary" type='submit' id="submit" value='Login'/>
					</footer>
				</form>
			</div>
			<div class="signin-row row">
				<div class="span4"></div>
				<div class="span8">
					<div class="well well-small well-shadow">
						<legend class="lead">Administrator Login</legend>
						<?php if ($LoginMessage == 0)
						          echo 'Hello, Administrator';
						      else
								  echo $MSG_Login_Message;
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php	
	require_once 'template/footer.tpl';
?>

