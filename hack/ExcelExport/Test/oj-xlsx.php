<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2011 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2011 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.6, 2011-02-27
 */

/** Error reporting */
error_reporting(E_ALL);

date_default_timezone_set('Asia/Shanghai');

/** PHPExcel */
require_once '../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("Nuist ThinkSpirit")
							 ->setLastModifiedBy("Nuist ThinkSpirit")
							 ->setTitle("Office 2007 XLSX Document")
							 ->setSubject("Office 2007 XLSX Document")
							 ->setDescription("Office 2007 XLSX, test result.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


// Add column
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '学号')
            ->setCellValue('B1', '姓名')
            ->setCellValue('C1', '成绩');

// Add data base          
$mysqli=new mysqli("localhost","root","wshbnm0326");
$mysqli->select_db("nuistoj");
$query="select sid,logicpid,uid from solution order by sid DESC";
$result=$mysqli->query($query,MYSQLI_STORE_RESULT);

//  Add data
$i=2;
while($row=$result->fetch_array(MYSQLI_NUM)){
    $UID=$row[0];
    $Username=$row[1];
    $Grade=$row[2];
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$UID);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$i,$Username);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,$Grade);
    $i++;
}
            

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('成绩');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="测试成绩.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
