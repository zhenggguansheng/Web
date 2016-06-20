<?php
    
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
		} 
		
		return $errors;
	}
	
	function delaysub(){
        global $oDD;
        if(isset($_SESSION['uid']))
	    {
		    $uid =  $_SESSION['uid'];
		    $strSql = "select in_date from solution where uid = '".$uid."' order by in_date desc limit 1;";
		    $sumbittime = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
		
		    $time1 = strtotime($sumbittime);
		    $time2 = strtotime("now");
		    $subtime = $time2 - $time1;
		
		    if ( $subtime<180 )
		    {
			    echo "<script language='javascript'>\n";
			    echo "alert(\"提交速度太快！请稍后提交...\");";
			    echo 'parent.location.href = "problem.php?pid='.$pid.'";';
			
			    echo "</script>";
		    }
	    }
    }

    function getcounts($type,$session)
    {
        global $oDD;
        if ($type == "0") //Exicse
        {
            $strSql = "SELECT count(*) FROM commonuser INNER JOIN solution ON solution.uid = commonuser.uid ".$session.";";//应用count 统计总的记录数
        }
        if ($type == "1") //cid
        {
            $strSql = "SELECT count( distinct solution.sid) FROM  solution,contest_user where contest_user.cid = solution.cid  and solution.cid ='".$session."' ;";//应用count 统计总的记录数
        }
        if ($type == "2") //eid
        {
            $strSql = "Select count( distinct solution.sid) FROM  solution,exam_user where exam_user.eid = solution.eid  and solution.eid ='".$session."' ;";//应用count 统计总的记录数
        }
        if ($type == "3") //kid
        {
            $strSql = "SELECT count( distinct solution.sid) FROM  solution,course_user where course_user.kid = solution.kid  and solution.kid ='".$session."' ;";//应用count 统计总的记录数
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
            echo '<tr class="tr1 vt">';
            echo '<td class="td1">'.$rsSolution['student_num'].'</td>';
            echo '<td class="td1">'.$rsSolution['name'].'</th>';
            if ($type == "0")
            {
                echo '<td class="td1">'.$rsSolution['pid'].'</th>';
			}
            else{echo '<td class="td1">'.$rsSolution['logicpid'].'</th>';}			
            switch($rsSolution['result'])
            {
	            case 1:$result = "Accepted";break;
	            case 2:$result = "Presentation Error";break;
	            case 3:$result = "Wrong Answer";break;
	            case 4:$result = "Runtime Error";break;
	            case 5:$result = "Time Limit Exceed";break;
	            case 6:$result = "Memory Limit Exceed";break;
	            case 7:$result = "Compile Error";break;
	            case 8:$result = "System Error";break;
	            default:$result = "Judging";
            }
            if(!strcmp($result,"Accepted"))
            {
                echo '<td class="td1"><font color="red">'.$result.'</font></th>';
            }
            else {echo '<td class="td1"><font color="green">'.$result.'</font></th>';}
            echo '<td class="td1">'.$rsSolution['use_memory'].' k</th>';
						
						
            switch($rsSolution['language'])
            {
	            case 1:$language = "GNU C";break;
	            case 2:$language = "GNU C++";break;
	            case 3:$language = "Java";break;
	            default:$language = "All";
            }
						
            echo '<td class="td1">'.$rsSolution['use_time'].' ms</th>';
						
            // <无须改动此段
						
            if(isset($_SESSION['power']) && ($_SESSION['power'] == "admin") )
            {
	            if ($type == "0")
				{
					echo '<td><a href="source.php?sid='.$rsSolution['sid'].'">'.$language.'</a></td>';
				}
				else
				{
					echo '<td><a href="../source.php?sid='.$rsSolution['sid'].'">'.$language.'</a></td>';
				}
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

        $query="select * from ranklist order by ac DESC";
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