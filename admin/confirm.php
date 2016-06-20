<?php
	require_once("global.php");
	session_start();
	confirmlogin();
	if(isset($_SESSION['cid']))
	{
		$cid = $oDD->EscapeString($_SESSION['cid']);
	}
	else{$cid="";}
	
	if(isset($_GET['logicpid']))
	{
		$logicpid = $oDD->EscapeString($_GET['logicpid']);
	}
	else{$logicpid="";}
	
	$rsSql = "update solution set mark = '1' where logicpid='".$logicpid."' and cid = ".$cid.";";
	$rsResult = $oDD->Query($rsSql);
	if($rsResult)
	{
		Header("Location:putColor.php");
	}

?>