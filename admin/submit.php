<?php
	require_once 'template/header.tpl';
	require_once 'global.php';
	confirmlogin();
	if(!isset($_SESSION['user_name']))
	{
		echo "<script language='javascript'>\n";
		echo "alert(\"请先登录！\");";
		echo 'parent.location.href = "login.php";';
		echo "</script>";
	}
	
	if(isset($_SESSION['uid']))
	{
		$uid =  $_SESSION['uid'];
		$strSql = "select user_name from commonuser where uid = '".$uid."';";
		$user_name = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
	}
	else{$uid = "";$user_name = "";}
	if(isset($_GET['logicpid']))
	{
		$pid_get = $oDD->EscapeString($_GET['logicpid']);
	}
	else{$pid_get = "";}
	if(isset($_POST['lang']))
	{
		$lang = $oDD->EscapeString($_POST['lang']);
	}
	else{$lang = "";}
	if(isset($_SESSION['logicpid']))
	{
		$logicpid = $oDD->EscapeString($_SESSION['logicpid']);
	}
	else{$logicpid = "";}
	if(isset($_POST['code']))
	{
		$source = $oDD->EscapeString($_POST['code']);
	}
	else{$source = "";}
	
	if(!empty($uid) && !empty($logicpid) && !empty($source))
	{
		$in_date = strftime("%Y-%m-%d %H:%M:%S", time());
		$strSql = "insert solution(logicpid,uid,language,in_date) values('".$logicpid."','".$uid."','".$lang."','".$in_date."');";
		$rsResult = $oDD->Query($strSql);
		$sid = $oDD->InsertId($strSql);
		$strSql = "insert source_code values('".$sid."','".$source."');";
		$rsResult = $oDD->Query($strSql);
			
		
        //$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		//$connection = socket_connect($socket,$current_host, 1000);
		//socket_write($socket, $sid."-");
		

		echo "<script language='javascript'>\n";
		echo "location.replace(\"status.php\");\n";
		echo "</script>";
	}
?>
	<div id="bt"> 
		<h2><center>Submit  Your  Code</center></h2>
	</div>
	<div id="submit-content">
	<form action="submit.php" method="post">
	<table>
		<tr>
			<th width="35%">Current User</th>
			<td colspan="5"><input name="usr" type="text" value="<?php if(!empty($user_name)){echo $user_name;}?>" maxlength="32" readonly="true" /></td>

		</tr>
		<tr>
			<th>Language</th>  
			<td><select name="lang">
				<option value="1" selected="selected">GNU C</option>
				<option value="2" >GNU C++</option>
				<option value="3" >JAVA</option>
				</select>
			</td>
			<th width="30%">ProblemID</th>
			<td width="30%"><?php echo $pid_get;?></td>
		</tr>
		<tr>
			<th scope="row">Code</th>
			<td colspan="5"><textarea name="code" cols="60" rows="30"></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="5">
				<input name="submit" type="submit" value="Submit" class="buttons" style="width:150px;" />
				<input name="reset"  type="reset"  value="Reset"  class="buttons" style="width:150px;" />
			</td>
		</tr>
	</table>
	</form>
 
	</div>
	<div style="clear: both;">&nbsp;</div>
	</div>
<?php
	require_once 'template/footer.tpl';
?>