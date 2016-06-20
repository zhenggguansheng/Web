<?php
	require_once("global.php");

	confirmlogin();
	if(isset($_SESSION['pid']))
	{
		$pid = $oDD->EscapeString($_SESSION['pid']);
	}
	else{$pid="";}
	
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
	
	if(isset($_GET['kid']))
	{
	    $kid = $oDD->EscapeString($_GET['kid']);
	}
	else if(isset($_SESSION['kid']))
	{
		$kid = $oDD->EscapeString($_SESSION['kid']);
	}
	else{$kid = "";}

	if(isset($_GET['logicpid']))
	{
		$logicpid = $oDD->EscapeString($_GET['logicpid']);
	}
	else{$logicpid="";}
	
	if(isset($_GET['userid']))
	{
		$userid = $oDD->EscapeString($_GET['userid']);
	}
	else{$userid="";}
	
	if(isset($_GET['nid']))
	{
		$nid = $oDD->EscapeString($_GET['nid']);
	}
	else{$nid="";}
	
	if($logicpid!=""&&$cid!="")
{
	$rsSql = "delete from contest_problem where cid='".$cid."'and logicpid='".$logicpid."';";
	$rsResult = $oDD->Query($rsSql);
	if($rsResult)
	{
		Header("Location:editproblem.php");
	}
}

     if($userid!=""&&$cid!="")
{
	$rsSql = "delete from contest_user where cid='".$cid."'and uid='".$userid."';";
	$rsResult = $oDD->Query($rsSql);
	if($rsResult)
	{
		Header("Location:editstudent.php");
	}
}

	if($logicpid!=""&&$eid!="")
{
	$rsSql = "delete from exam_problem where eid='".$eid."'and logicpid='".$logicpid."';";
	$rsResult = $oDD->Query($rsSql);
	if($rsResult)
	{
		Header("Location:editproblem.php");
	}
}

     if($userid!=""&&$eid!="")
{
	$rsSql = "delete from exam_user where eid='".$eid."'and uid='".$userid."';";
	$rsResult = $oDD->Query($rsSql);
	if($rsResult)
	{
		Header("Location:editstudent.php");
	}
}

	if($logicpid!=""&&$kid!="")
{
	$rsSql = "delete from course_problem where kid='".$kid."'and logicpid='".$logicpid."';";
	$rsResult = $oDD->Query($rsSql);
	if($rsResult)
	{
		Header("Location:editproblem.php");
	}
}

     if($userid!=""&&$kid!="")
{
	$rsSql = "delete from course_user where kid='".$kid."'and uid='".$userid."';";
	$rsResult = $oDD->Query($rsSql);
	if($rsResult)
	{
		Header("Location:editstudent.php");
	}
}
/* 
    if($kid!=""&&$logicpid==""&&$userid=="")
    {
	    $rsSql = "delete from course where kid = '".$kid."';";
	    $rsResult = $oDD->Query($rsSql);
		if($rsResult)
		{
		  Header("Location:course.php");
		}
	}
    */
    if($pid!=""&&$cid==""&&$eid==""&&$kid=="")
   {
	   $rsSql = "delete from problem where pid = '".$pid."';";
	   $rsResult = $oDD->Query($rsSql);
	if($rsResult)
	{
		Header("Location:problemlist.php");
	}
   }
   
      if($nid!="")
   {
	   $rsSql = "delete from news where nid = '".$nid."';";
	   $rsResult = $oDD->Query($rsSql);
	if($rsResult)
	{
		Header("Location:news.php");
	}
   }
?>