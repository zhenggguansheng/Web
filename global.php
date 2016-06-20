<?php
	
    // $basesite = dirname(__FILE__);
    // chdir(dirname(__FILE__));

    require_once("include/db_mysqli.inc");
	require_once("include/db_mysqli_error.inc");
	require_once("data/sys.config.php");
	require_once("data/db.config.php");
     
    $delaytime = 30;   //提交代码的暂停时间，防止恶意提交代码
    $oDD = new DbDriver($db_host, $db_port, $db_user, $db_pwd, $db_name, $db_charset);
	
	$strSql = "set character_set_client = utf8;";
	$rsResult = $oDD->Query($strSql);
	$strSql = "set character_set_results = utf8;";
	$rsResult = $oDD->Query($strSql);
	$Introduction = "Online Judge System是一个检测平台，旨在利用公共的数据集测试程序的“正确性”，希望同学们在本地的编译器上调试出有运行结果的程序后，再提交至服务器评测。";
	
	session_start();

   	class GetMacAddr{ 

        var $return_array = array(); // 返回带有MAC地址的字串数组 
        var $mac_addr; 

        function GetMacAddr($os_type){ 
             switch ( strtolower($os_type) ){ 
                      case "linux": 
                                $this->forLinux(); 
                                break; 
                      case "solaris": 
                                break; 
                      case "unix": 
                                 break; 
                       case "aix": 
                                 break; 
                       default: 
                                 $this->forWindows(); 
                                 break; 

              } 
			  $temp_array = array(); 
			  foreach ( $this->return_array as $value ){ 
				if ( preg_match("/[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f]/i",$value, $temp_array ) ){ 
					$this->mac_addr = $temp_array[0]; 
					break; 
				} 
				} 
			  unset($temp_array); 
			  return $this->mac_addr; 
		 } 

		 function forWindows(){ 
			  @exec("ipconfig /all", $this->return_array); 
			  if ( $this->return_array ) 
					   return $this->return_array; 
			  else{ 
					   $ipconfig = $_SERVER["WINDIR"]."\system32\ipconfig.exe"; 
					   if ( is_file($ipconfig) ) 
						  @exec($ipconfig." /all", $this->return_array); 
					   else 
						  @exec($_SERVER["WINDIR"]."\system\ipconfig.exe /all", $this->return_array); 
					   return $this->return_array; 
			  } 
		 }
	}
?>