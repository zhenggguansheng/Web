<?php
	require_once 'template/header.tpl';
	require_once '../global.php';
    require_once '../functions.php';
	
	$min_seconds_between_refreshes = 10;#设置刷新的时间

	if(array_key_exists('last_access', $_SESSION) && time()-$min_seconds_between_refreshes <= $_SESSION['last_access'])
	{
		// The user has been here at least $min_seconds_between_refreshes seconds ago - block them
		exit('页面刷新太快，别太心急哦！稍后继续...');
	}
	// Record now as their last access time
	$_SESSION['last_access'] = time();

	confirmuserlogin(3);
	$postfix = "";
	if(!isset($_SESSION['kkid']))
	{
			echo "<script language='javascript'>\n";
			echo 'parent.location.href = "courselist.php";';
			echo "</script>";
			exit;
	}
	else
	{
		if(isset($_SESSION['kuid']))
		{
			$uid = $oDD->EscapeString($_SESSION['kuid']);
			if(isset($_SESSION['power']) && ($_SESSION['power'] == "admin") )
			{
				$uidSQL="1 ";
			}
			else
			{
				$uidSQL = " solution.uid = '".$uid."' ";
			}
		}else{$uid="";$uidSQL="1 ";}
		
		if(isset($_SESSION['kkid']))
		{
			$kid = $oDD->EscapeString($_SESSION['kkid']);
			$kidSQL = " solution.kid = '".$kid."' ";
		}else{$kid="";$kidSQL = "1 ";}
		

		
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
		$postfix = " where ".$uidSQL." and ".$kidSQL." and ".$logicpidSQL." and ".$langSQL." and ".$rsSQL." ";
	}
	
?>
<div id="bt">
	<h2><center><?php echo gettitlename("3",$kid);?></center></h2>
</div>
<section class="page container">
	<div class="row">
		<div class="span2"></div>
	<div class="span12">
	<div class="box pattern pattern-sandstone">
	<div class="box-content box-table">
			<div class="col-lg-10">				
			<form action="status.php" method="get"><fieldset>
			   题目编号<input class="form-control" name="logicpid" type="text"/>
			   状态
			   <select class="form-control" name="result">
					<option value="99">All</option>
					<option value="0">Submitted</option>
					<option value="1">Accepted</option>
					<option value="2">Presentation Error</option>
					<option value="3">Wrong Answer</option>
					<option value="4">Runtime Error</option>
					<option value="5">Time Limit Exceed</option>
					<option value="6">Memory Limit Exceed</option>
					<option value="7">Compile Error</option>
					<option value="8">System Error</option>
					<option value="9">Waiting</option>
				</select>
				语言<select class="form-control" name="language" >
					 <option value="99">All</option>
					 <option value="1">GUN C</option>
					 <option value="2">GUN C++</option>
					 <option value="3">Java</option>
					</select>
					<button type="submit" class="btn btn-info" name="submit">Search</button>
				</fieldset></form>
			</div>
			<table id="sample-table" class="table table-hover table-bordered">
				<thead>
					<tr>
						<th class="menu" width="10%"  scope="col"><?php echo $MSG_UsersID ;?></th>
						<th class="menu" width="8%"  scope="col"><?php echo $MSG_USERNAME ;?></th>
						<th class="menu" width="7%"  scope="col"><?php echo $MSG_Problem_ID ;?></th>
						<th class="menu" width="20%"   scope="col"><?php echo $MSG_Result ;?></th>
						<th class="menu" width="7%"   scope="col"><?php echo $MSG_Memory ;?></th>					 
						<th class="menu" width="8%"  scope="col"><?php echo $MSG_Time ;?></th>					 
						<th class="menu" width="10%"  scope="col"><?php echo $MSG_Language ;?></th>					
						<th class="menu" width="15%"  scope="col"><?php echo $MSG_Submit_time;?></th>
					</tr>
				</thead>
				<tbody>
				<?php
						if(isset($_GET['Page'])){$page = $_GET['Page'];}
						else{$page = 1;}
						if($page && !empty($postfix) )
						{
							$page_size = 50;//每页的信息行数
							$total = getcounts("3",$kid, $uidSQL);
							$page_count = ceil($total/$page_size);//计算页数
							$offset=($page-1)*$page_size;
							if($total == 0)
							{
								echo '<tr ><td colspan="5"><font color="red">未搜索到相关信息</font></td></tr>';
							}
							else {status("3",$postfix,$offset,$page_size);}
							
						}
				?>
			</tbody>
			<table>
				<Script Language="JavaScript">
					ShowoPage("","","<div id=\"pagechange\">页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
				</Script>
			</table>
		</table>
	</div>
	</div>
	</div>
</section>

<?php
	require_once 'template/footer.tpl';
?>