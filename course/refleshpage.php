<?php
	$min_seconds_between_refreshes = 10;#设置刷新的时间

	if(array_key_exists('last_access', $_SESSION) && time()-$min_seconds_between_refreshes <= $_SESSION['last_access'])
	{
		// The user has been here at least $min_seconds_between_refreshes seconds ago - block them
		exit('You are refreshing too quickly, please wait a few seconds and try again.');
	}
	// Record now as their last access time
	$_SESSION['last_access'] = time();
?>