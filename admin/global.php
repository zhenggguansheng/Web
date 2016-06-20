<?php
	require_once("../global.php");
	require_once("../lang/cn.php");
	
	$filePath = "E:/NuistOJBackground/problem/";
	            // D:\NuistOJBackground\problem
	function confirmlogin()
    {
        if ( !(isset($_SESSION['power'])) )
	    {
		    echo "<script language='javascript'>\n";
		    echo 'parent.location.href = "exit.php";';
		    echo "</script>";
	    }
    }
	
	//confirmlogin();
?>