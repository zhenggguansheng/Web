<?php
    header("Content-Type:text/html;charset=utf-8");
     
	require_once 'template/header.tpl';
	require_once 'global.php';	
	require_once '../functions.php';

	$msg = "准备导入数据";
    confirmlogin();

    if(isset($_POST['loadExcel']) && !empty($_POST['loadExcel']))
	{
		$filename = $_FILES['inputExcel']['name'];
		$tmp_name = $_FILES['inputExcel']['tmp_name'];
		
        $str = "";   
		//下面的路径按照你PHPExcel的路径来修改
		
		require_once 'Classes/PHPExcel.php';
		require_once 'Classes/PHPExcel/Reader/Excel5.php';
		require_once 'Classes/PHPExcel/IOFactory.php';
		
		//注意设置时区
		$time=date("y-m-d-H-i-s");//去当前上传的时间 
		//获取上传文件的扩展名
		$extend=strrchr ($filename,'.');
		//上传后的文件名
		$name=$time.$extend;
		$uploadfile='../upload/files/'.$name;//上传后的文件名地址 
		//move_uploaded_file() 函数将上传的文件移动到新位置。若成功，则返回 true，否则返回 false。
		$result=move_uploaded_file($tmp_name,$uploadfile);//假如上传到当前目录下
        $psd = md5('111111');
		
		if($result) //如果上传文件成功，就执行导入excel操作
		{
			$objReader = PHPExcel_IOFactory::createReader('Excel5');//use Excel2007 format 
            $objPHPExcel = $objReader->load($uploadfile); 
			
            $sheet = $objPHPExcel->getSheet(0); 
			$highestRow = $sheet->getHighestRow();           //取得总行数 
			$highestColumn = $sheet->getHighestColumn(); //取得总列数
	 
			$objWorksheet = $objPHPExcel->getActiveSheet();
			$highestRow = $objWorksheet->getHighestRow(); 

			$highestColumn = $objWorksheet->getHighestColumn();
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数
			$headtitle=array(); 
			
			for ($row = 2;$row <= $highestRow;$row++) 
			{
				$strs=array();
				//注意highestColumnIndex的列数索引从0开始
				for ($col = 0;$col < $highestColumnIndex;$col++)
				{
					$strs[$col] =$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                    //$encode = mb_detect_encoding($strs[$col], array("ASCII","UTF-8","GB2312","GBK","BIG5")); 
                    //echo $col .'----\r\n' . $encode;
 				}
                
                $a1 = trim($strs[0]);
                $a2 = trim($strs[1]);
                $a3 = trim($strs[2]);
                $a4 = trim($strs[3]);
                $a5 = trim($strs[4]);
                /*
                $a1 = iconv('ASCII', 'ASCII', $strs[0]);
                $a2 = iconv('UTF-8', 'UTF-8', $strs[1]);
                $a3 = iconv('UTF-8', 'UTF-8', $strs[2]);
                $a4 = iconv('UTF-8', 'UTF-8', $strs[3]);
                $a5 = iconv('ASCII', 'ASCII', $strs[4]);
                */
                /*
				$a1 = mb_convert_encoding($strs[0], "UTF-8", "auto");
                $a2 = mb_convert_encoding($strs[1], "UTF-8", "auto");
                $a3 = mb_convert_encoding($strs[2], "UTF-8", "auto");
                $a4 = mb_convert_encoding($strs[3], "UTF-8", "auto");
                $a5 = mb_convert_encoding($strs[4], "UTF-8", "auto");*/
 
                $strSql = "insert into commonuser (`user_name`,`password`,`name`,`college`,`major`,`grade`,`student_num`) VALUES
                                     ('".$a1."','".$psd."','".$a2."','".$a3."','".$a4."','".$a5."','".$a1."');";
				
				$rsResult =  $oDD->Query($strSql);
				try{
                    $rsResult =  $oDD->Query($strSql);
                }catch(mysqli_sql_exception $e)
                {
                    $msg = "数据重复，请核对" . $a1 .  mysql_error() ;
                }
				if (!$rsResult)
                {
                   $msg = "数据导入失败！";
                   break;
			    }
		    }
            $msg = "导入成功!";
        }
		else
		{
		   $msg = "文件上传失败！";
		} 
	}


?>



<section class="container">
    <div class="row">
		<div class="span3">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><p><a href="addnewuser.php" target="contentframe">添加学生</a></p></li>
					<li><p><a href="addbatchnewuser.php" target="contentframe">批量增加学生用户信息</a></p></li>
					<li><p><a href="addbatchexamuser.php" target="contentframe">批量增加考试学生</a></p></li>
				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>批量增加</h5>
				</div>							
				<form action="addbatchnewuser.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="loadExcel" value="true">
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<tbody>
							<tr>
								<td width="10%">下载模板</td>
								<td width="50%"><a href="../app/students.xls">名单模板</a></td>
								<td width="40%"></td>
							</tr>
							<tr>
								<td width="10%">名单文件</td>
								<td width="50%"><input type="file" name="inputExcel" accept=".xls"></td>
								<td width="40%"></td>
							</tr>
							<tr>
								<td width="10%">上传名单</td>
								<td width="50%"><input type="submit" value="导入数据"></td>
								<td width="40%"></td>
							</tr>
							<tr>
								<td width="10%">导入状态</td>
								<td width="50%"><?php echo $msg; ?></td>
								<td width="40%"></td>
							</tr>
							<tr>
								<td width="10%">注意事项</td>
								<td width="50%" >名单导入不可出现重复项，否则系统会报数据库错误！</td>
								<td width="40%"></td>
							</tr>
						</tbody>
					</table>
					<div class="box-footer">
						<button class="btn btn-primary" type="submit">提 交</button>
						<button class="btn btn-primary" type="button" onClick="history.go(-1);">返回</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</section>
<?php	
	require_once 'template/footer.tpl';
?>
