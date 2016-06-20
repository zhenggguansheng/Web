<?php
	require_once("global.php");

	confirmlogin();

	$strSql = "call delete_first_judging();";
	$rsSQL = $oDD->Query($strSql);
	Header("Location:manageruser.php");


?>