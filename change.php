<?php
	require_once 'data/sys.config.php';

	session_start();
	if(isset($_GET['lang']))
	{
		$_SESSION['lang'] = $_GET['lang'];
	}
	if(isset($_GET['uid']))
	   {
		   $_SESSION['uid'] = $oDD->EscapeString($_GET['uid']);
		   $kid = $_SESSION['uid'];
	   }
	   else if(isset($_SESSION['uid']))
	   {
		   $uid = $_SESSION['uid'];
	   }
	   else { $uid = "";}

	Header("Location: index.php");
?>
