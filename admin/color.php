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
		
	if(isset($_POST['color']))
	{
		$color = $oDD->EscapeString($_POST['color']);
	}
	else
	{
		$color = "";
	}
	
	
	
	$rsSql = "update contest_problem set color = '".$color."' where cid='".$cid."'and logicpid='".$logicpid."';";
	
	$rsResult = $oDD->Query($rsSql);
	echo 1;

?>