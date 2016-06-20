<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();

	if(isset($_SESSION['cid']))
	{
		$cid = $oDD->EscapeString($_SESSION['cid']);
	}
	else{$cid="";}
	
	if(isset($_SESSION['eid']))
	{
		$eid = $oDD->EscapeString($_SESSION['eid']);
	}
	else{$eid="";}
	
	if(isset($_SESSION['kid']))
	{
		$kid = $oDD->EscapeString($_SESSION['kid']);
	}
	else{$kid="";}
	
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
	
	$strSql_G = "select distinct grade from commonuser;";
	$rsResult_G = $oDD->Query($strSql_G);
	
	$strSql_M = "select distinct major from commonuser;";
	$rsResult_M = $oDD->Query($strSql_M);
	
	$strSql_C = "select distinct class from commonuser;";
	$rsResult_C = $oDD->Query($strSql_C);
	
    if(isset($_GET['student_num']))
	{
		$student_num = $oDD->EscapeString($_GET['student_num']);
		if (!empty($student_num ))
		{	$student_numSQL = " user_name = '".$student_num."' ";}
		else
		{	$student_num = "";$student_numSQL = "1 ";}
	}
	else{$student_num = "";$student_numSQL = "1 ";}
	
	if(isset($_GET['major']))
	{
		$major = $oDD->EscapeString($_GET['major']);
		if($major == 99){$majorSQL= "1 ";}
		else {$majorSQL = " major = '".$major."' ";}
	}
	else{$major = "";$majorSQL = "1 ";}
	
	if(isset($_GET['grade']))
	{
		$grade = $oDD->EscapeString($_GET['grade']);
		if($grade == 99){$gradeSQL = "1 ";}
		else{$gradeSQL = " grade = '".$grade."' ";}
	}
	else{$grade = "";$gradeSQL = "1 ";}
	
	if(isset($_GET['class']))
	{
		$class = $oDD->EscapeString($_GET['class']);
		if($class == 99){$classSQL="1 ";}
		else{$classSQL = " class = '".$class."' ";}	
	}
	else{$class="";$classSQL = "1 ";}

	$postfix = "where ".$majorSQL." and ".$gradeSQL." and ".$classSQL." and ".$student_numSQL." ";
	
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
  window.location.href='add.php?users='+values.join(',');
 }else{
  alert('未选择学生编号！');
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
					<h5> 添加学生 >>> <?php if($cid!=""){echo $contest;}else if($eid!=""){echo $exam;}else if($kid!=""){echo $course;}?></h5>
				</div>
				<div class="control-group ">
				<form action="addstudent.php" method="get">
				   学号
				   <input name = "student_num" type="text" style="width:160px;" maxlength="20"/>
				   年级
				   <select name = "grade">
				   <option value="99">All</option>
				   <?php
				   
				   while($Grade = $oDD->FetchArray($rsResult_G,MYSQLI_ASSOC))
				   {
					   echo '<option value = "'.$Grade['grade'].'">'.$Grade['grade'].'</option>';
				   }
				   ?>
				   </select>	   
				   专业
				   <select name = "major">
				   <option value="99">All</option>
				   <?php
				   while($Major = $oDD->FetchArray($rsResult_M,MYSQLI_ASSOC))
				   {
					   echo '<option value = "'.$Major['major'].'">'.$Major['major'].'</option>';
				   }
				   ?>
				   </select>	   
				   <input name="submit" value="Find" type="submit" style="width:68px;" />
				</form>
				</div>
				<div class="box-content box-table">
					<div class="box-footer">
						<button class="btn btn-primary" onclick="selectItems();">添加</button>
						<button class="btn btn-primary" onClick="location.href='editstudent.php'">取消</button>
					</div>
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<span class="select-all">
									 <th>   <input type="checkbox" name="checkbox1" onClick="selectAll();">All
									        <input type="checkbox" name="checkbox2" onClick="unalls();">No</th>
									 <th>学号</th>
									 <th>用户名</th>
									 <th>年级  </th>
									 <th>专业  </th>
							</tr>
						</thead>
						<tbody>
							<?php
								if(isset($_GET['Page'])){$page = $_GET['Page'];}
								else{$page = 1;}
								if($page)
								{
									$page_size = 200;//每页的信息行数
									if($eid!=""){
										$strSql = "select count(*) as total from commonuser ".$postfix." and uid not in (select uid from exam_user where eid = '".$eid."');";}
									else if($cid!=""){
										$strSql = "select count(*) as total from commonuser ".$postfix." and uid not in (select uid from contest_user where cid = '".$cid."');";}
									else if($kid!=""){
										$strSql = "select count(*) as total from commonuser ".$postfix." and uid not in (select uid from course_user where kid = '".$kid."');";}//应用count 统计总的记录数
									
									$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
									$page_count = ceil($total/$page_size);//计算页数
									$offset=($page-1)*$page_size;
									
									if($total==0)
									{
										echo '<tr ><td colspan="7"><font color="red">未搜索到相关信息</font></td></tr>';
									}
									
									if($eid!=""){
									$strSql = "select * from commonuser ".$postfix." and uid not in (select uid from exam_user where eid = '".$eid."') order by uid limit $offset,$page_size;";}
									else if($cid!=""){
									$strSql = "select * from commonuser ".$postfix." and uid not in (select uid from contest_user where cid = '".$cid."') order by uid limit $offset,
								$page_size;";}
									else if($kid!=""){
									$strSql = "select * from commonuser ".$postfix." and uid not in (select uid from course_user where kid = '".$kid."') order by uid limit $offset,$page_size;";        }
									$rsResult = $oDD->Query($strSql);
									$checkboxid = 1;
									while($rsUser = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
									{
										echo '<tr><td><input type="checkbox" name="checkbox" id="'.$checkboxid.'" value="'.$rsUser['uid'].'" onClick="check();"/></td>';
										echo '<td>'.$rsUser['user_name'].'</td>';
										echo '<td>'.$rsUser['name'].'</td>';
										echo '<td>'.$rsUser['grade'].'</td>';
										echo '<td>'.$rsUser['major'].'</td></tr>';
										$checkboxid = $checkboxid + 1;
									}
								}
							?>	
						</tbody>
					</table>
					<div class="box-footer">
						<button class="btn btn-primary" onclick="selectItems();">添加</button>
						<button class="btn btn-primary" onClick="location.href='editstudent.php'">取消</button>
					</div>
				</div>
			</div>
			<div class="page-container"">
					<Script Language="JavaScript">
							ShowoPage("","","<div class=\"alert alert-block alert-info\" style = \"TEXT-ALIGN:center\";><div>页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
					</Script>
					</div></div>
			</div>
		</div>	
    </div>

</section>

<?php	
	require_once 'template/footer.tpl';
?>
