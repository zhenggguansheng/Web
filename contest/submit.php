<?php
	require_once 'template/header.tpl';
	require_once 'global.php';
    require_once '../functions.php';

	if(isset($_SESSION['ccid']))
	{
		$cid = $oDD->EscapeString($_SESSION['ccid']);
	}else{$cid="";}
	
	confirmuserlogin(1);
	
	if(isset($_SESSION['ccid']) && isset($_SESSION['cuid'])||isset($_SESSION['power']))
	{
		delaysub();
		if(isset($_SESSION['cuid']))
		{
			$uid =  $_SESSION['cuid'];
			$strSql = "select user_name from commonuser where uid = '".$uid."';";
			$user_name = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
		}
		else{$uid = "";$user_name = "";}

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
	}
	else
	{
			echo "<script language='javascript'>\n";
			echo 'parent.location.href = "contestlist.php";';
			echo "</script>";
	}


	if((!empty($uid) && !empty($user_name) || !empty($_SESSION['power']) ) && !empty($logicpid) && !empty($source) && !empty($eid) )
	{
		$strSql = "select pid from exam_problem where cid= '".$cid."' and logicpid = '".$logicpid."';";
		$pid = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
		
		$in_date = strftime("%Y-%m-%d %H:%M:%S", time());
		$strSql = "insert solution(pid,logicpid,uid,language,in_date,cid) values('".$pid."','".$logicpid."','".$uid."','".$lang."','".$in_date."','".$cid."');";
		$rsResult = $oDD->Query($strSql);

		$sid = $oDD->InsertId($strSql);
		$strSql = "insert source_code values('".$sid."','".$source."');";
		$rsResult = $oDD->Query($strSql);

		echo "<script language='javascript'>\n";
		echo "location.replace(\"status.php\");\n";
		echo "</script>";
		exit;
	}

?>
<div id="bt"> <h2><center>Submit  Your  Code</center></h2></div>
<div id="submit-content">
	<form action="submit.php" method="post">
	<table>
		<tr>
			<th width="35%">Current User</th>
			<td colspan="5"><?php echo $user_name;?></td>

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
			<td width="30%"><?php echo $logicpid;?></td>
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
<?php
	require_once 'template/footer.tpl';
?>
