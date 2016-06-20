<?php
	require_once("global.php");

    confirmlogin();
	if(isset($_GET["action"]) and $_GET["action"]=="submit")
    {
		$name = $oDD->EscapeString($_POST['name2']);
		$room = $oDD->EscapeString($_POST['room']);
		$seat = $oDD->EscapeString($_POST['seat']);
		if ($name != "" && $room != "" && $seat != "")
		{
			$sql = "UPDATE contest_user SET ROOM = '".$room."' , SEAT = '".$seat."'WHERE uid = (SELECT uid FROM commonuser WHERE user_name = '".$name."')";
			$res = $oDD->Query($sql);
		}
		Header("Location:setstudentpsd.php");
		exit;
	}
?>