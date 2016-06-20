<?php
	require_once 'template/header.tpl';
	unset($_SESSION['user_name']);
	unset($_SESSION['uid']);
	unset($_SESSION['lang']);
	unset($_SESSION['page']);
	unset($_SESSION['power']);
	unset($_SESSION['cid']);
	unset($_SESSION['eid']);
	unset($_SESSION['kkid']);
	unset($_SESSION['kuid']);
	unset($_SESSION['eeid']);
	unset($_SESSION['euid']);
	unset($_SESSION['cuid']);
	unset($_SESSION['ccid']);
	unset($_SESSION['user_name']);

	session_destroy();
	echo "<script language='javascript'>\n";
	echo "location.replace(\"index.php\");\n";
	echo "</script>";?>