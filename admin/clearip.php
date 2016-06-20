<?php
	require_once("global.php");

    confirmlogin();
	if(isset($_GET["action"]) and $_GET["action"]=="submit")
    {
		$name = $oDD->EscapeString($_POST['name3']);
		$eid  = $oDD->EscapeString($_POST['name4']);
		if ($name != "" && $eid != "")
		{
			$sql = "UPDATE exam_user SET ip = '' WHERE eid = '".$eid."' and uid = (SELECT uid FROM commonuser WHERE user_name = '".$name."')";
			$res = $oDD->Query($sql);
		}
		Header("Location:setstudentpsd.php");
		exit;
	}
?>