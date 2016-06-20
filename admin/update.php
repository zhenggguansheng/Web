<?php
	require_once("global.php");
	session_start();
	confirmlogin();
	if(isset($_SESSION['cid']))
	{
		$cid = $oDD->EscapeString($_SESSION['cid']);
	}
	else{$cid="";}
	if(isset($_SESSION['kid']))
	{
		$kid = $oDD->EscapeString($_SESSION['kid']);
	}
	else{$kid="";}

	if(isset($_SESSION['eid']))
	{
		$eid = $oDD->EscapeString($_SESSION['eid']);
	}
	else{$eid="";}
	
    if(isset($_SESSION['pid']))
	{
		$pid = $oDD->EscapeString($_SESSION['pid']);
	}
	else{$pid="";}
     
	if(isset($_GET['logicpid']))
	{
		$logicpid = $oDD->EscapeString($_GET['logicpid']);
	}
	else{$logicpid="";}
		
	if(isset($_GET['color']))
	{
		$color = $oDD->EscapeString($_GET['color']);
	}
    else{$color = "";}
	
	if(isset($_GET['logicpid']))
	{
		$logicpid = $oDD->EscapeString($_GET['logicpid']);
	}
    else{$logicpid = "";}
	
	
	if ($cid != "")
		{
			$rsSql = "select logicpid,color from contest_problem where cid = '".$cid."' and pid = '".$pid."';";
			$dblogicpid = $oDD->GetValue($rsSql, MYSQLI_NUM, 0);		
			$dbcolor = $oDD->GetValue($rsSql, MYSQLI_NUM, 1);
            if( $logicpid != $dblogicpid ) 
			{
				$rsSql = "update contest_problem set logicpid = '".$logicpid."' where cid = '".$cid."' and pid = '".$pid."';";
				$rsResult = $oDD->Query($rsSql);
			}
			if( $color != $dbcolor )
			{
				$rsSql = "update contest_problem set color = '".$color."'  where cid = '".$cid."' and logicpid= '".$logicpid."';";
				$rsResult = $oDD->Query($rsSql);
			}
			Header("Location:editproblem.php");
	}
	if ($kid != "")
	{
			$rsSql = "select logicpid from course_problem where kid = '".$kid."' and pid = '".$pid."';";
			$dblogicpid = $oDD->GetValue($rsSql, MYSQLI_NUM, 0);	
            if( $logicpid != $dblogicpid ) 
			{
				$rsSql = "update course_problem set logicpid = '".$logicpid."' where kid = '".$kid."' and pid = '".$pid."';";
                $rsResult = $oDD->Query($rsSql);
			}
			Header("Location:editproblem.php");
		}
	if ($eid != "")
	{
			$rsSql = "select logicpid from exam_problem where eid = '".$eid."' and pid = '".$pid."';";
			$dblogicpid = $oDD->GetValue($rsSql, MYSQLI_NUM, 0);
            if( $logicpid != $dblogicpid ) 
			{
				$rsSql = "update exam_problem set logicpid = '".$logicpid."' where eid = '".$eid."' and pid = '".$pid."';";
                $rsResult = $oDD->Query($rsSql);
			}
			Header("Location:editproblem.php");
	}
?>