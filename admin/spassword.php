<?php
	require_once("global.php");

    confirmlogin();
	
   if(isset($_GET["action"]) and $_GET["action"]=="submit")
    {
		$name = $oDD->EscapeString($_POST['name1']);
		$pwd = $oDD->EscapeString($_POST['pwd1']);
		
		if ($name != "" && $pwd != "")
		{
			$sql = "UPDATE commonuser SET PASSWORD = MD5('".$pwd."') WHERE user_name = '".$name."'";
			$res = $oDD->Query($sql);
		}
		Header("Location:setstudentpsd.php");
		exit;
	}
?>