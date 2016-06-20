<?php
	require_once 'template/header.tpl';
	require_once '../global.php';
    require_once '../functions.php';
	
	confirmuserlogin(0);
	
    if(isset($_SESSION['uid']))
	{
		$uid = $oDD->EscapeString($_SESSION['uid']);
		if(isset($_SESSION['power']) && ($_SESSION['power'] == "admin") )
        {
            $uidSQL="1 ";
        }
        else
        {
            $uidSQL = " solution.uid = '".$uid."' ";
        }
	}else{$uid="";$uidSQL="1 ";}

    
	if( isset($_GET['student_num']) && !empty($_GET['student_num']) )
	{
		$user_name = $oDD->EscapeString($_GET['student_num']);
		$strSQL = "select uid from commonuser where user_name='".$user_name."';";
		$uid = $oDD->GetValue($strSQL,MYSQLI_NUM,0);
		$uidSQL = " solution.uid = '".$uid."' ";
	}
	else{$uid="";$uidSQL="1 ";}
	
	if( isset($_GET['logicpid']) && !empty($_GET['logicpid']) )
	{
		$logicpid = $oDD->EscapeString($_GET['logicpid']);
		$logicpidSQL = " solution.pid = '".$logicpid."' ";
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
	$postfix = " where ".$uidSQL." and ".$logicpidSQL." and ".$langSQL." and ".$rsSQL." and (solution.cid+solution.eid+solution.kid = 0) ";

?>

<div id="bt">
	<h2><center>Excercise Status</center></h2>
</div>

<section class="page container">
	<div class="row">
		<div class="span2"></div>
	<div class="span12">
	<div class="box pattern pattern-sandstone">
	<div class="box-content box-table">
			<div class="col-lg-10">				
			<form action="status.php" method="get"><fieldset>
			   用户<input class="form-control" name="student_num" type="text" style="width:100px"/>
			   题目编号<input class="form-control" name="logicpid" type="text" style="width:100px"/>
			   状态
			   <select class="form-control" name="result" maxlength="22" width = 5%>
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
				语言<select class="form-control" name="language" style="width:100px">
					 <option value="99">All</option>
					 <option value="1">GUN C</option>
					 <option value="2">GUN C++</option>
					 <option value="3">Java</option>
					</select>
					<button type="submit" class="btn btn-info" name="submit" style="width:100px">Search</button>
				</fieldset></form>
			</div>
			<table id="sample-table" class="table table-hover table-bordered">
				<thead>
					<tr>
						<th class="menu" width="10%"  scope="col"><?php echo $MSG_UsersID ;?></th>
						<th class="menu" width="8%"  scope="col"><?php echo $MSG_USERNAME ;?></th>
						<th class="menu" width="7%"  scope="col"><?php echo $MSG_Problem_ID ;?></th>
						<th class="menu" width="15%"   scope="col"><?php echo $MSG_Result ;?></th>
						<th class="menu" width="7%"   scope="col"><?php echo $MSG_Memory ;?></th>					 
						<th class="menu" width="8%"  scope="col"><?php echo $MSG_Time ;?></th>					 
						<th class="menu" width="10%"  scope="col"><?php echo $MSG_Language ;?></th>					
						<th class="menu" width="20%"  scope="col"><?php echo $MSG_Submit_time;?></th>
					</tr>
				</thead>
				<tbody>
				<?php
						if(isset($_GET['Page'])){$page = $_GET['Page'];}
						else{$page = 1;}
						if($page)
						{
							$page_size = 50;//每页的信息行数
							$total = getcounts("0",$postfix,"");
							$page_count = ceil($total/$page_size);//计算页数
							$offset=($page-1)*$page_size;
							if($total == 0)
							{
								echo '<tr ><td colspan="5"><font color="red">未搜索到相关信息</font></td></tr>';
							}
							else {status("0",$postfix,$offset,$page_size);}
							
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