<?php
	require_once("global.php");
	session_start();
	confirmlogin();
	if(isset($_SESSION['cid']))
	{
		$cid = $oDD->EscapeString($_SESSION['cid']);
	}
	else{$cid="";}
	
	
	if(isset($_POST['logicpid']))
	{
		$logicpid = $oDD->EscapeString($_POST['logicpid']);
	}
	else{$logicpid="";}
		
	if(isset($_POST['pid']))
	{
		$pid = $oDD->EscapeString($_POST['pid']);
	}
	else
	{
		$pid = "";
	}
	
	
	
	$rsSql = "update contest_problem set logicpid = '".$logicpid."' where cid='".$cid."'and pid='".$pid."';";
	echo $rsSql ;
	$rsResult = $oDD->Query($rsSql);
	echo 1;

?>