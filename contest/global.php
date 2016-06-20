<?php
	require_once("../include/db_mysqli.inc");
	require_once("../include/db_mysqli_error.inc");
	require_once("../data/db.config.php");
	require_once("../data/sys.config.php");
	$oDD = new DbDriver($db_host, $db_port, $db_user, $db_pwd, $db_name, $db_charset);
	
	$strSql = "set character_set_client = utf8;";
	$rsResult = $oDD->Query($strSql);
	$strSql = "set character_set_results = utf8;";
	$rsResult = $oDD->Query($strSql);
?>