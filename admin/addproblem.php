<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();

	if(isset($_SESSION['cid']))
	{
		$cid = $oDD->EscapeString($_SESSION['cid']);
	}
	else { $cid = "";}
	
	if(isset($_SESSION['eid']))
    {
		$eid = $oDD->EscapeString($_SESSION['eid']);
	}
	else { $eid = "";}
	
	if(isset($_SESSION['kid']))
    {
		$kid = $oDD->EscapeString($_SESSION['kid']);
	}
	else { $kid = "";}
	
	if($cid!="")
	{
		$strSql = "select title from contest where cid='".$cid."';";
		$contest = $oDD->GetValue($strSql,MYSQLI_NUM,0); 
	}
	else if($eid!="")
	{
		$strSql = "select title from exam where eid='".$eid."';";
		$exam = $oDD->GetValue($strSql,MYSQLI_NUM,0); 
	}
	else if($kid!="")
	{
		$strSql = "select coursename from course where kid='".$kid."';";
		$course = $oDD->GetValue($strSql,MYSQLI_NUM,0); 
	}
		
?>
<script Language="JavaScript" type="text/JavaScript" src="../include/js/showo_page.js"></script>

<script type="text/javascript">
function selectItems(){
 var items = document.getElementsByName('checkbox');
 var values = new Array();
 var key = 0;
 for(var i=0; i<items.length; i++){
  if(items[i].checked){
   values[key] = items[i].value
   key++;
  }
 }
 if(values.length > 0){
  window.location.href='add.php?pids='+values.join(',');
 }else{
  alert('未选择题目编号！');
 }
}
function selectAll(){
 var items = document.getElementsByName('checkbox');
 for(var i=0; i<items.length; i++){
  items[i].checked = true;
 }
 checkbox2.checked = false;
}

function unalls(){
 var items = document.getElementsByName('checkbox');
 for(var i=0; i<items.length; i++){
  items[i].checked = false;
 }
  checkbox1.checked = false;
}
function check(){
	var items = document.getElementsByName('checkbox');
	for(var i=0; i<items.length; ){
        if(items[i].checked){ i++;}
		else {i=items.length+1;}
	}
	if(i==items.length){checkbox1.checked = true;}
	else {checkbox1.checked = false;}
	
	for(var j=0; j<items.length; ){
        if(!items[j].checked){ 
		  j++;
		}
		else {j=items.length+1;}
	}
	if(j==items.length){checkbox2.checked = true;}
	else {checkbox2.checked = false;}
 }
</script>

<section class="container">
    <div class="row">
		<div class="span2">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<?php 
						if($cid!="")
							echo '<li><p><a href="editcontestinfo.php">竞赛编辑</a></li>';
						else if($eid!="")
							echo '<li><p><a href="editexaminfo.php">考试编辑</a></li>';
						else if($kid!="")
							echo '<li><p><a href="editcourseinfo.php">课程编辑</a></li>';
					?>
					<li><a href="editproblem.php">题目列表</a></li>
					<li><a href="addproblem.php">添加题目 </a></li>
					<li><a href="editstudent.php">学生列表</a></li>
					<li><a href="addstudent.php">添加学生 </a></li>
					<li><a href="status.php">状态         </a></li>
					<li><a href="ranklist.php">排名       </a></li>
					<li><a href="statistics.php">统计     </a></li>
					<?php
						if($cid != "")
							echo '<li><p><a href="putColor.php">气球登记</a></li>';
					?>
				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>题目列表 >>> <?php if($cid!=""){echo $contest;}else if($eid!=""){echo $exam;}else if($kid!=""){echo $course;}?></h5>
				</div>
				<div class="box-content box-table">
					<div class="box-footer">
							<button class="btn btn-primary" onclick="selectItems();">添加</button>
							<button class="btn btn-primary" onClick="location.href='editproblem.php'">取消</button>
					</div>

					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								 <th>选择</th>
								 <th>题目编号</th>
								 <th>逻辑编号</th>
								 <th>题目名称</th>
								 <th>可见性</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if(isset($_GET['Page'])){$page = $_GET['Page'];}
								else{$page = 1;}
								if($page)
								{
									$page_size = 50;//每页的信息行数
									if($eid!=""){
										$strSql   = "select count(*) as total from problem where pid not in (select pid from exam_problem where eid = '".$eid."');";
										$_SESSION['eid'] = $eid;
									}
									else if($cid!=""){
										$strSql   = "select count(*) as total from problem where pid not in (select pid from contest_problem where cid = '".$cid."');";
										$_SESSION['cid'] = $cid;
									}
									else if($kid!=""){
										$strSql   = "select count(*) as total from problem where pid not in (select pid from course_problem where kid = '".$kid."');";//应用count 统计总的记录数
										$_SESSION['kid'] = $kid;
									}
									
									$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
									$page_count = ceil($total/$page_size);//计算页数
									$offset=($page-1)*$page_size;
									
									if($total==0)
									{
										echo '<tr ><td colspan="7"><font color="red">未搜索到相关信息</font></td></tr>';
									}

									if($eid!=""){
										$strSql   = "select * from problem where pid not in (select pid from exam_problem where eid = '".$eid."') order by pid limit $offset,$page_size;";
									}
									else if($cid!=""){
										$strSql   = "select * from problem where pid not in (select pid from contest_problem where cid = '".$cid."') order by pid limit $offset,$page_size;";
									}
									else if($kid!=""){
										$strSql   = "select * from problem where pid not in (select pid from course_problem where kid = '".$kid."') order by pid limit $offset,$page_size;";
									}
									$rsResult = $oDD->Query($strSql);
									$checkboxid = 1;
									
									while($rsProblem = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
									{
										echo '<tr class="tr1 vt"><td class="td1"><input type="checkbox" name="checkbox" id="'.$checkboxid.'" value="'.$rsProblem['pid'].'" onClick="check();"/>';
										echo '<td class="td1">'.$rsProblem['pid'].'</td>';
										echo '<td class="td1">'.$rsProblem['logicpid'].'</td>';
										echo '<td class="td1"><a href="problem.php?pid='.$rsProblem['pid'].'">'.$rsProblem['title'].'</td>';
										echo '<td class="td1">';
										  if (($rsProblem['defunct']) == 'Y')
											  echo  "可见";
										  else
											  echo  "不可见";
										echo '</td></tr>';
										$checkboxid = $checkboxid + 1;
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
					<div class="box-footer">
							<button  onclick="selectItems();">添加</button>
							<button  onClick="location.href='editproblem.php'">取消</button>
					</div>
				</div>
			</div>
		</div>	
    </div>

</section>

<?php	
	require_once 'template/footer.tpl';
?>
