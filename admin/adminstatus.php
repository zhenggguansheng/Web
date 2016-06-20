<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	
    if( isset($_GET['pid']) && !empty($_GET['pid']) )
	{
		$pid = $oDD->EscapeString($_GET['pid']);
		$pidSQL = " solution.pid = '".$pid."' ";
	}
	else{$logicpid="";$pidSQL="1 ";}
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

	$postfix = " and ".$pidSQL." and ".$langSQL." and ".$rsSQL." ";
?>	

<Script Language="JavaScript" type="text/JavaScript" src="../include/js/showo_page.js"></Script>


<section class="container">
    <div class="row">
		<div class="span3">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><p><a href="manageruser.php">管理员列表</a></p></li>
					<li><p><a href="newmanager.php">添加管理员</a></p></li>
					<li><p><a href="deletejudging.php">解决Judging</a></p></li>
 				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>提交记录</h5>
				</div>							
				<div class="box-content box-table">
					<form action="adminstatus.php" method="get">
					<table class="table table-hover table-bordered">
					   题目编号<input name="logicpid" type="text" style="width:100px;" maxlength="32" />
					   状态
					   <select name="result">
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
					   语言
						<select name="language" >
							   <option value="99">All</option>
							   <option value="1">GUN C</option>
							   <option value="2">GUN C++</option>
								<option value="3">Java</option>
							</select>
						<input name="submit" value="Go" type="submit" style="width:50px;" />
					</form>
					<thead>
						<th>姓名</th>
						<th>题目编号</th>
						<th>逻辑编号</th>
						<th>结果</th>
						<th>内存</th>					 
						<th>耗时</th>					 
						<th>语言</th>					
						<th>提交时间</th>
					</thead>
					<tbody>
						<?php
						if(isset($_GET['Page'])){$page = $_GET['Page'];}
						else{$page = 1;}
						if($page)
						{
							$page_size = 20;//每页的信息行数
							$strSql = "SELECT count(sid) FROM  manageruser  INNER JOIN solution ON solution.uid = manageruser.uid ".$postfix." ; ";//应用count 统计总的记录数
							$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
							$page_count = ceil($total/$page_size);//计算页数
							$offset=($page-1)*$page_size;
							
							$strSql   = "SELECT manageruser.name, solution.sid, solution.logicpid, solution.pid,solution.use_time, solution.use_memory, 
												solution.in_date, solution.result,  solution.language,  solution.uid,solution.mark
										 FROM  manageruser  INNER JOIN solution ON solution.uid = manageruser.uid ".$postfix." order by solution.in_date DESC  limit $offset,$page_size";
							$rsResult = $oDD->Query($strSql);
							
							while($rsSolution = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
							{
								echo '<tr>';
								
								echo '<td>'.$rsSolution['name'].'</td>';
								echo '<td>'.$rsSolution['pid'].'</td>';
								echo '<td>'.$rsSolution['logicpid'].'</td>';
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
								if(!strcmp($result,"Accepted")){
								echo '<td><font color="red">'.$result.'</font></td>';}
								else {echo '<td><font color="green">'.$result.'</font></td>';}
								echo '<td>'.$rsSolution['use_memory'].' k</td>';
								echo '<td>'.$rsSolution['use_time'].' ms</td>';
								switch($rsSolution['language'])
								{
									case 1:$language = "GNU C";break;
									case 2:$language = "GNU C++";break;
									case 3:$language = "Java";break;
									default:$language = "All";
								}
								echo '<td><a href="source.php?sid='.$rsSolution['sid'].'">'.$language.'</a></td>';
								echo '<td>'.$rsSolution['in_date'].'</td></tr>';
								
							}
							if($total == 0)
							{
								echo '<tr ><td colspan="5"><font color="red">未搜索到相关信息</font></td></tr>';
							}
						}
						?>	
					</tbody>
					</table>
					<div class="page-container"">
						<Script Language="JavaScript">
								ShowoPage("","","<div class=\"alert alert-block alert-info\" style = \"TEXT-ALIGN:center\";><div>页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
						</Script>
						</div></div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<?php	
	require_once 'template/footer.tpl';
?>
