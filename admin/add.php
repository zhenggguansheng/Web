<?php
	require_once("global.php");

	confirmlogin();
	if(isset($_SESSION['cid']))
	{
		$cid = $oDD->EscapeString($_SESSION['cid']);
	}
	else{$cid="";}
	
	if(isset($_SESSION['eid']))
	{
		$eid = $oDD->EscapeString($_SESSION['eid']);
	}	
	else{$eid="";}
	
	if(isset($_SESSION['kid']))
	{
		$kid = $oDD->EscapeString($_SESSION['kid']);
	}	
	else{$kid = "";}
	
	if(isset($_GET['pids'])&&$cid!="")
	{
		$pidlist = explode(",",$_GET['pids']);
		foreach((array)$pidlist as $pid)
		{
			$rsSql = "select logicpid from problem where pid= '".$pid."';";
			$logicpid =  $oDD->GetValue($rsSql, MYSQLI_NUM, 0);
			$rsSql = "insert into contest_problem(cid,pid,logicpid) values('".$cid."','".$pid."','".$logicpid."');";
			$oDD->Query($rsSql);
		}
		Header("Location:http:editproblem.php");
	}


	if(isset($_GET['users'])&&$cid!="")
	{
			$userid = explode(",",$_GET['users']);

			$strSQL = "select * from contest where cid = ".$cid.";";
			$res = $oDD->Query($strSQL);
			if($resd = $oDD->FetchArray($res,MYSQLI_ASSOC))
			{
				foreach((array)$userid as $uid)
				{
					$rsSql = "insert into contest_user(cid,uid,usetime) values('".$cid."','".$uid."','".$resd['end_time']."');";
					$oDD->Query($rsSql);
				}
				Header("Location:addstudent.php");
			}
	}

	if(isset($_GET['pids'])&&$eid!="")
	{
		$pids = explode(",",$_GET['pids']);
		foreach((array)$pids as $pid)
		{
			$rsSql = "select logicpid from problem where pid= '".$pid."';";
			$logicpid =  $oDD->GetValue($rsSql, MYSQLI_NUM, 0);
			$rsSql = "insert into exam_problem(eid,pid,logicpid) values('".$eid."','".$pid."','".$logicpid."');";
			$oDD->Query($rsSql);
		}
			Header("Location:editproblem.php");
	}

	if(isset($_GET['users'])&&$eid!="")
	{
			$userid = explode(",",$_GET['users']);
			$strSQL = "select * from exam where eid = ".$eid.";";
			$res = $oDD->Query($strSQL);
			if($resd = $oDD->FetchArray($res,MYSQLI_ASSOC))
			{
				foreach((array)$userid as $uid)
				{
					$rsSql = "insert into exam_user(eid,uid,usetime) values('".$eid."','".$uid."','".$resd['end_time']."');";
					$oDD->Query($rsSql);
				}
			}
		   Header("Location:addstudent.php");
	}

	if(isset($_GET['pids'])&&$kid!="")
	{
		$pids = explode(",",$_GET['pids']);
		foreach((array)$pids as $pid)
		{
			$rsSql = "select logicpid from problem where pid= '".$pid."';";
			$logicpid =  $oDD->GetValue($rsSql, MYSQLI_NUM, 0);
			$rsSql = "insert into course_problem(kid,pid,logicpid) values('".$kid."','".$pid."','".$logicpid."');";
			$oDD->Query($rsSql);
		}
			Header("Location:editproblem.php");
	}

	if(isset($_GET['users'])&&$kid!="")
{
		$userid = explode(",",$_GET['users']);
		foreach((array)$userid as $uid)
	{
	    $rsSql = "insert into course_user(kid,uid) values('".$kid."','".$uid."');";
		$oDD->Query($rsSql);
	}
	   Header("Location:addstudent.php");
}

?>