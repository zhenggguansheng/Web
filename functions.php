<?php
    
// 获取IP地址（摘自discuz）
	function get_real_ip(){
		$ip=false;
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
			if ($ip) {
				array_unshift($ips, $ip); $ip = FALSE; 
			}
			for ($i = 0; $i < count($ips); $i++) {
				if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])) {
					$ip = $ips[$i];
					break;
				}
			}
		}
		return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
	}
	
	function getIp(){
		$ip='未知IP';
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			return is_ip($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_CLIENT_IP']:$ip;
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			return is_ip($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$ip;
		}else{
			return is_ip($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:$ip;
		}
	}
	function is_ip($str){
		$ip=explode('.',$str);
		for($i=0;$i<count($ip);$i++){  
			if($ip[$i]>255){  
				return false;  
			}  
		}  
		return preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/',$str);  
	}
	
	function confirmuserlogin($type)
    {
        $result = -1;
		if ( empty($_SESSION['power']) )
		{
			if ( $type == 0 )//Exerices
			{
				if ( !(isset($_SESSION['uid'])) )
				{
					echo "<script language='javascript'>\n";
					echo 'parent.location.href = "login.php";';
					echo "</script>";
				}else $result = 0;
			}else if ( $type == 1 ) //Contest  cid
			{
				if ( !(isset($_SESSION['cuid'])) )
				{
					echo "<script language='javascript'>\n";
					echo 'parent.location.href = "../contest/contestlogin.php";';
					echo "</script>";
				}else $result = 1;
			}else if ( $type == 2 ) //Exam  eid
			{
				if ( !(isset($_SESSION['euid'])) )
				{
					echo "<script language='javascript'>\n";
					echo 'parent.location.href = "../exam/login.php";';
					echo "</script>";
				}else $result = 2;
			}else if ( $type == 3 ) //Course  kid
			{
				if ( !(isset($_SESSION['kuid']) ))
				{
					echo "<script language='javascript'>\n";
					echo 'parent.location.href = "../course/login.php";';
					echo "</script>";
				}else $result = 3;
			}
		}
    }
	
	function validate($password, $repeat_password) {
		$errors = '';
		$password = trim($password);
		if ($password == '111111') {
			$errors = '输入密码不能是初始密码！';
		} elseif (!$password) {
			$errors = '密码不能为空!';
		} elseif (strlen($password)<6) {
			$errors = '密码长度不能小于6个字符!';
		} elseif (strlen($password)>30) {
			$errors = '密码长度不能超过30个字符！';
		} elseif (!preg_match('/^[A-Za-z0-9!@#\\$%\\^&\\*_]+$/', $password)) {
			$errors = '密码只能是数字、字母或!@#$%^&*_等字符的组合！';
		} elseif ($password != trim($repeat_password)) {
			$errors = '两次输入密码不一致！';
		}else $erroe = ''; 
		
		
		return $errors;
	}
	
	function delaysub($uid){
        global $oDD;
		global $delaytime;
		if (!empty($uid))
		{
			$strSql = "select in_date from solution where uid = '".$uid."' order by in_date desc limit 1;";
			$sumbittime = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
			$time1 = strtotime($sumbittime);
			$time2 = strtotime("now");
			$subtime = $time2 - $time1;

			if ( $subtime<$delaytime )
			{
				echo "<script language='javascript'>\n";
				echo "alert(\"提交速度太快！请稍后提交...\");";
				echo "history.back();";
				echo "</script>";
				exit;
			}	
		}
		else
		{
				echo "<script language='javascript'>\n";
				echo "alert(\"未合法登录！请登录后提交...\");";
				echo 'parent.location.href = "../home.php";';
				echo "</script>";
				exit;
		}

    }

	function strtrimall($str)
	{
		$sourcecodestr = $str;
		$qian=array(" ","　","\t","\n","\r");
		$hou=array("","","","","");
		str_replace($qian,$hou,$sourcecodestr);  
		$qian=array(" ","　","\t","\N","\R");
		$hou=array("","","","","");
		return str_replace($qian,$hou,$sourcecodestr); 
	}

	function  duplicate_checking($type,$source,$pid,$serial_number,$uid)
	{
		global $oDD;
		switch( $type )
		{
			case 0:  //Exercise
					$strSql = "SELECT source FROM ( source_code INNER JOIN solution ON solution.result = 1 and solution.sid = source_code.sid and solution.pid ='".$pid."' and solution.uid <> '".$uid."' )  LIMIT 0, 500 ;";
			case 1:  //Content
			
			case 2:  //Exam                                                                                                                                                 //and solution.eid = '".$serial_number."'                 
					$strSql = "SELECT source FROM ( source_code INNER JOIN solution ON solution.result = 1 and solution.sid = source_code.sid and solution.pid = '".$pid."'  and solution.uid <> '".$uid."' )  LIMIT 0, 100 ;";
			case 3:  //                                                                                                                                                     // and solution.kid = '".$serial_number."'                   
					$strSql = "SELECT source FROM ( source_code INNER JOIN solution ON solution.result = 1 and solution.sid = source_code.sid and solution.pid = '".$pid."'  and solution.uid <> '".$uid."' )  LIMIT 0, 100 ;";
		}
		
		$rsCode = $oDD->Query($strSql);
		$max = -1;
		$sourcecode = strtrimall($source);
		while($rsSoureCode = $oDD->FetchArray($rsCode, MYSQLI_ASSOC))
		{
			similar_text($sourcecode, strtrimall($rsSoureCode['source']), $similarity_pst);
			$value = number_format($similarity_pst, 2, '.', '');
			if ($value > $max)
			{
				$max = $value;
			}
		}

		return $max;
	}
	
    function getcounts($type,$session,$uidsqlpara)
    {
        global $oDD;
        if ($type == "0") //Exerices ".$uidSQL."
        {
            $strSql = "SELECT count(*) FROM commonuser INNER JOIN solution ON solution.uid = commonuser.uid ".$session.";";//应用count 统计总的记录数
        }
        if ($type == "1") //cid
        { 
            $strSql = "SELECT count( distinct solution.sid) FROM  solution,contest_user where contest_user.cid = solution.cid and ".$uidsqlpara." and solution.cid ='".$session."' ;";//应用count 统计总的记录数
        }
        if ($type == "2") //eid
        {
            $strSql = "Select count( distinct solution.sid) FROM  solution,exam_user where exam_user.eid = solution.eid  and ".$uidsqlpara." and solution.eid ='".$session."' ;";//应用count 统计总的记录数
        }
        if ($type == "3") //kid
        {
            $strSql = "SELECT count( distinct solution.sid) FROM  solution,course_user where course_user.kid = solution.kid  and ".$uidsqlpara." and solution.kid ='".$session."' ;";//应用count 统计总的记录数
        }
        return $total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
    }
    function gettitlename($type,$session)
    {
        global $oDD;
        if ($type == "1") //cid
        {
            $strSql = "select title from contest where cid = '".$session."';";
        }
        if ($type == "2") //eid
        {
            $strSql = "select title from exam where eid = '".$session."';";
        }
        if ($type == "3") //kid
        {
            $strSql = "select coursename from course where kid = '".$session."';";
        }
        $rsResult = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
        return $rsResult;
    }
    
    function ranklist($type,$session)
    {
        global $oDD;
        $strSql = "call proranklist($type,$session)";
		$rsSQL = $oDD->Query($strSql);
    }
    function status($type,$session,$offset,$page_size)
    {
        global $oDD;
          
		$strSql   = "SELECT  commonuser.student_num, commonuser.name, solution.sid, solution.pid,solution.logicpid,solution.use_time, solution.use_memory, solution.in_date, solution.result, solution.language, solution.uid 
			        FROM commonuser INNER JOIN solution ON solution.uid = commonuser.uid ".$session." order by solution.in_date DESC limit $offset,$page_size;";
        		
		$rsResult = $oDD->Query($strSql);
        $count = count($rsResult);
			
         while($rsSolution = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
         {
            echo '<tr><td>'.$rsSolution['student_num'].'</td>';
            echo '<td>'.$rsSolution['name'].'</td>';
            if ($type == "0")
            {
                echo '<td>'.$rsSolution['pid'].'</td>';
			}
            else{echo '<td>'.$rsSolution['logicpid'].'</td>';}			
            switch($rsSolution['result'])
            {
	            case 0:$result = "Submitted";break;
				case 1:$result = "Accepted";break;
	            case 2:$result = "Presentation Error";break;
				case 3:$result = "Wrong Answer";break;
	            case 4:$result = "Runtime Error";break;
				case 5:$result = "Time Limit Exceed";break;
	            case 6:$result = "Memory Limit Exceed";break;
	            case 7:$result = "Compile Error";break;
	            case 8:$result = "System Error";break;
	            case 9:$result = "Waiting";break;
            }
            if(!strcmp($result,"Accepted"))
            {
                echo '<td><font color="red">'.$result.'</font></td>';
            }
            else if($rsSolution['result'] == 7) 
			{
				echo '<td><a href="compilererr.php?sid='.$rsSolution['sid'].'">'.$result.'</a></td>';
			}
			else
			{	
				echo '<td><font color="green">'.$result.'</font></td>';
			}
            echo '<td>'.$rsSolution['use_memory'].' k</td>';
						
						
            switch($rsSolution['language'])
            {
	            case 1:$language = "GNU C";break;
	            case 2:$language = "GNU C++";break;
	            case 3:$language = "Java";break;
	            default:$language = "All";
            }
						
            echo '<td>'.$rsSolution['use_time'].' ms</td>';
						
            // <无须改动此段
						
            if(isset($_SESSION['power']) && ($_SESSION['power'] == "admin") )
            {
				echo '<td><a href="source.php?sid='.$rsSolution['sid'].'">'.$language.'</a></td>';
			}
			elseif ($type == "0")//禁止浏览源码
			{
				echo '<td>'.$language.'</td>';
			}
            else{echo '<td>'.$language.'</td>';}
            echo '<td>'.$rsSolution['in_date'].'</td></tr>';
            //无须改动
        }
    }

	
    function getExcel($fileName,$headArr)
    {
        global $oDD;	    
        if(empty($fileName)){
		    exit;
	    }
	    $date = date("Y_m_d",time());
	    $fileName .= "_{$date}.xlsx";

	    //创建新的PHPExcel对象
	    $objPHPExcel = new PHPExcel();
	    $objProps = $objPHPExcel->getProperties();

	    //设置表头,从第二列开始
	    $key = ord("A");
	    foreach($headArr as $v){
		    $colum = chr($key);
		    $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
		    $key += 1;
	    }

	    $objActSheet = $objPHPExcel->getActiveSheet();

        //获取数据

        $query="select * from ranklist order by ac DESC , submit ASC";
        $rsResult = $oDD->Query($query);


	    $row = 2;
        $No = 1;
        //遍历数据
        while($rsRanklist= $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
        {
	        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$No);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row," ".$rsRanklist['user_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$rsRanklist['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$rsRanklist['college']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$rsRanklist['major']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$rsRanklist['grade']);
	        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$rsRanklist['submit']);
	        $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$rsRanklist['ac']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$rsRanklist['uid']);
            $row++;
	        $No++;
        }
    

	    $fileName = iconv("utf-8", "gb2312", $fileName);
	    //重命名表
	    $objPHPExcel->getActiveSheet()->setTitle('Ranklist');
	    //设置活动单指数到第一个表,所以Excel打开这是第一个表
	    $objPHPExcel->setActiveSheetIndex(0);
	
	
	    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	    //脚本方式运行，保存在当前目录

	    ob_end_clean();//清除缓冲区,避免乱码
	    // 输出文档到页面  
	    header('Content-Type: application/vnd.ms-excel');  
	    header('Content-Disposition: attachment;filename="Ranklist.xls"');  
	    header('Cache-Control: max-age=0');  
	    $objWriter->save("php://output");  
	    exit;

    }
	

?>