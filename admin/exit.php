<?php
	session_start();
	unset($_SESSION['user_name']);
	unset($_SESSION['uid']);
	unset($_SESSION['lang']);
	unset($_SESSION['page']);
	unset($_SESSION['power']);
	unset($_SESSION['cid']);
	unset($_SESSION['eid']);
	session_destroy();
	echo "<script language='javascript'>\n";
	echo "location.replace(\"../admin.php\");\n";
	echo "</script>";
?>