<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
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
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */


/** Include PHPExcel */
require_once 'global.php';
require_once '../functions.php';
require_once 'Classes/PHPExcel.php';
require_once 'Classes/PHPExcel/Writer/Excel2007.php';
require_once 'Classes/PHPExcel/Writer/Excel5.php';
require_once 'Classes/PHPExcel/IOFactory.php';


/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Shanghai');

if (PHP_SAPI == 'cli')
	die('This Function should only be run from a Web Browser');

$fileName = "ranklist_excel";
$headArr = array("排名","学号","姓名","学院","专业","年级","提交数","解决数","ID");

getExcel($fileName,$headArr);




?>