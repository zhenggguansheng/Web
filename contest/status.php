<?php
	require_once 'global.php';
	require_once 'template/header.tpl';
	require_once '../functions.php';		

	if(isset($_SESSION['ccid']))
	{
		$cid = $oDD->EscapeString($_SESSION['ccid']);
		$cidSQL = " solution.cid = '".$cid."' ";
	}else
	{
		$cid="";$cidSQL = "1 ";
	}
	
	confirmuserlogin(1);
	
	if(!isset($_SESSION['ccid']) && !isset($_SESSION['cuid']))
	{
			echo "<script language='javascript'>\n";
			echo 'parent.location.href = "examlist.php";';
			echo "</script>";
			exit;
	}

	if( isset($_SESSION['cuid']) )
	{
		$uid = $oDD->EscapeString($_SESSION['cuid']);
		$uidSQL = " solution.uid = '".$uid."' ";
	}
	else{$uidSQL="1 ";$uid="";}
		
	if( isset($_GET['logicpid']) && !empty($_GET['logicpid']) )
	{
		$logicpid = $oDD->EscapeString($_GET['logicpid']);
		$logicpidSQL = " solution.logicpid = '".$logicpid."' ";
	}
	else{$logicpid="";$logicpidSQL="1 ";}
	
	if( isset($_GET['language']) && !empty($_GET['language']) )
	{
		$language = $oDD->EscapeString($_GET['language']);
		if($language == 99){$langSQL="1 ";}
		else{$langSQL = " solution.language = '".$language."' ";}
	}
	else{$language="";$langSQL="1 ";}
	
	if( isset($_GET['result']) && !empty($_GET['result']) )
	{
		$result = $oDD->EscapeString($_GET['result']);
		if($result == 99){$rsSQL="1 ";}
		else{$rsSQL = " solution.result = '".$result."' ";}
		
	}
	else{$result="";$rsSQL = "1 ";}
	if (isset($_SESSIOn['power']))
		$postfix = " where 1 ";
	else
	    $postfix = " where ".$uidSQL." and ".$cidSQL." and ".$logicpidSQL." and ".$langSQL." and ".$rsSQL." ";

?>

<div id="bt">
	<h2><center><?php echo gettitlename("1",$cid);;?></center></h2>
</div>

<Script Language="JavaScript" type="text/JavaScript" src="include/js/showo_page.js"></Script>

<div id="table">
	<table>
			<form action="status.php" method="get">
			   搜索：&nbsp;&nbsp;
			   题目编号<input name="logicpid" type="text" style="width:100px;" maxlength="32" />&nbsp;&nbsp;
			   学号	   <input name = "student_num" type="text" style="width:100px;" maxlength="32"/>&nbsp;&nbsp;
			   状态<select name="result">
					 <option value="99">All</option>
					 <option value="0">Submitted</option>
					 <option value="1">Accepted</option>
					 <option value="2">Presentation Error</option>
					 <option value="3">Time Limit Exceed</option>
					 <option value="4">Memory Limit Exceed</option>
					 <option value="5">Wrong Answer</option>
					 <option value="6">Runtime Error</option>
					 <option value="7">Compile Error</option>
					 <option value="8">System Error</option>
					 <option value="9">Waiting</option>
				</select>
				语言<select name="language" >
					 <option value="99">All</option>
					 <option value="1">GUN C</option>
					 <option value="2">GUN C++</option>
					 <option value="3">Java</option>
					</select>
				<input name="submit" value="Go" type="submit" style="width:50px;" />
			</form>
			<br />
		</table>
</div>	
	
<div id="table">
	<table>
			<tr>
				<th class="menu" width="10%" scope="col"><?php echo $MSG_UsersID ;?></th>
				<th class="menu" width="8%"  scope="col"><?php echo $MSG_USERNAME ;?></th>
				<th class="menu" width="7%"  scope="col"><?php echo $MSG_Problem_ID ;?></th>
				<th class="menu" width="15%" scope="col"><?php echo $MSG_Result ;?></th>
				<th class="menu" width="7%"  scope="col"><?php echo $MSG_Memory ;?></th>					 
				<th class="menu" width="8%"  scope="col"><?php echo $MSG_Time ;?></th>					 
				<th class="menu" width="10%" scope="col"><?php echo $MSG_Language ;?></th>					
				<th class="menu" width="20%" scope="col"><?php echo $MSG_Submit_time;?></th>
			</tr>
			<?php
					if(isset($_GET['Page'])){$page = $_GET['Page'];}
					else{$page = 1;}
					if($page)
					{
						$page_size = 100;//每页的信息行数
						$strSql = "SELECT count( distinct solution.sid) FROM  solution,contest_user where contest_user.cid = solution.cid  and solution.cid ='".$cid."' ;";//应用count 统计总的记录数
                        						
						$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
						$page_count = ceil($total/$page_size);//计算页数
						$offset=($page-1)*$page_size;
						
                        status("1",$postfix,$offset,$page_size);

						if($total == 0)
						{
							echo '<tr ><td colspan="5"><font color="red">未搜索到相关信息</font></td></tr>';
						}
					}
				?>
		<Script Language="JavaScript">
			ShowoPage("","","<div id=\"pagechange\">页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
		</Script>				
		</table>
</div>
	
<div>			
	<Script Language="JavaScript">
		ShowoPage("","","<div id=\"pagechange\">页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
	</Script>
</div>

<div style="clear: both;">&nbsp;</div>
</div>
<?php
	require_once 'template/footer.tpl';
?>
