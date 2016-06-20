<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	
    if(isset($_SESSION['eid']))
    {    
        $eid = $_SESSION['eid'];
        $strSql = "select title from exam where eid='".$eid."' ;";
        $exam = $oDD->GetValue($strSql,MYSQLI_NUM,0);
    }
    else
        $eid = "";

    if(isset($_SESSION['cid']))
    {
        $cid = $_SESSION['cid'];
        $strSql = "select title from contest where cid='".$cid."' ;";
        $contest = $oDD->GetValue($strSql,MYSQLI_NUM,0);
    }
    else
        $cid = "";

    if(isset($_SESSION['kid']))
    {
        $kid = $_SESSION['kid'];
        $strSql = "select coursename from course where kid='".$kid."' ;";
        $course = $oDD->GetValue($strSql,MYSQLI_NUM,0);
    }    
    else
        $kid = "";

	if( isset($_GET['userid']) && !empty($_GET['userid']) )
	{
		$userid = $oDD->EscapeString($_GET['userid']);
	}
	else{$userid="";}
	
	
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
	
	if(isset($_GET["action"]) and $_GET["action"]=="submit")
    {
		if(!empty($user_name) && !empty($password) && !empty($name))
		{
			$strSql = "UPDATE commonuser SET user_name='".$num."',
								  password ='".$password."',
								  name     ='".$name."',
								  student_num='".$num."',
								  gender='".$gender."',
								  mobilephone='".$tel."',
								  college='".$college."',
								  major='".$major."',
								  grade='".$grade."',
								  class='".$class."',
								  `e-mail`='".$email."' 
						WHERE uid = '".$_SESSION['userid']."';";
						
			
			$rsResult = $oDD->Query($strSql);
			if($rsResult)
			{
				Header("Location:editstudent.php");
			}
		}
	}
	
	if ($userid != '')
	{
		$strSql   = "select * from commonuser where uid='".$userid."';";
		$rsResult = $oDD->Query($strSql);
		$rsUser   = $oDD->FetchArray($rsResult,MYSQLI_ASSOC);
	}
?>



<section class="container">
    <div class="row">
		<div class="span3">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><p><a href="editstudent.php">学生列表</a></p></li>
				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>学生信息编辑 </h5>
				</div>							
				<form name= form1 method="post" action="editstudentinfo.php?action=submit" onSubmit="return formcheck()">
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<tbody>
							<tr>
								<td><?php echo 'ID:' ;?></td>
								<td><?php $_SESSION['userid'] = $rsUser['uid'];echo $_SESSION['userid'];?></td>
								<td></td>
							</tr>  
							<tr>   
								<td><?php echo $MSG_USER_ID .'(学号):' ;?></td>
								<td><input id="user" name="user" type="text" value="<?php echo $rsUser['user_name'];?>"/></td>
								<td></td>
							</tr>
							<tr>
								<td><?php echo $MSG_PASSWORD .':' ;?></td>
								<td><input id="Password" name="Password" type="password" value="" /></td>
								<td></td>
							</tr>
							<tr>
								<td><?php echo $MSG_REPEAT_PASSWORD .'密码' .':' ;?></td>
								<td><input id="Password1" name="Password1" type="password" value="" /></td>
								<td></td>
							</tr>
							<tr>
								<td><?php echo $MSG_NAME  .':' ;?></td>
								<td><input id="name" name="name" type="text" value="<?php echo $rsUser['name'];?>" /></td>
								<td></td>
							</tr>
							<tr>
								<td><?php echo $MSG_GENDER  .':' ;?></td>
								<td>
									<input id="gender" name="gender" type="radio" value="1" checked="checked"><?php echo $MSG_MAIL ;?></input>
									<input id="gender" name="gender" type="radio" value="0" ><?php echo $MSG_FEMAIl ;?></input>
								<td></td>
							</tr>
							<tr>
								<td><?php echo $MSG_MOBILEPHONE_NUMBER  .':' ;?></td>
								<td><input id="tel" name="tel" type="text" value="<?php echo $rsUser['mobilephone'];?>" /></td>
								<td></td>
							</tr>
							<tr>
								<td><?php echo $MSG_COLLEGE  .':' ;?></td>
								<td><input id="college" name="college" type="text" value="<?php echo $rsUser['college'];?>" /></td>
								<td></td>
							</tr>
							<tr>
								<td><?php echo $MSG_MAJOR  .':' ;?></td>
								<td><input id="major" name="major" type="text" value="<?php echo $rsUser['major'];?>"/></td>
								<td></td>
							</tr>
							<tr>
								<td><?php echo $MSG_GRADE  .':' ;?></td>
								<td><input id="grade" name="grade" type="text" value="<?php echo $rsUser['grade'];?>"/></td>
								<td></td>
							</tr>
							<tr>
								<td><?php echo $MSG_CLASS  .':' ;?></td>
								<td><input id="class" name="class" type="text" value="<?php echo $rsUser['class'];?>"/></td>
								<td></td>
							</tr>
							<tr>
								<td><?php echo $MSG_EMAIL  .':' ;?></td>
								<td><input id="Email" name="Email" type="text" value="<?php echo $rsUser['e-mail'];?>" /></td>
								<td></td>
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
