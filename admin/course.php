<?php
	require_once 'template/header.tpl';
	require_once 'global.php';
	require_once '../functions.php';
	
	confirmlogin();

	$type = 3;
	unset($_SESSION['cid']);
	unset($_SESSION['eid']);

?>

<Script Language="JavaScript" type="text/JavaScript" src="../include/js/showo_page.js"></Script>

<section class="page container">
    <div class="row">
		<div class="span2">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><p><a href="newcourse.php">添加课程</a></p></li>
					<li><p><a href="editcourseinfo.php">编辑课程</a></p></li>
 				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>课程管理</h5>
				</div>
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>编号</th>
								<th>课程名称</th>
								<th>课程开始时间</th>
								<th>课程结束时间</th>
							</tr>
						</thead>
							<tbody>
								<?php
									if(isset($_GET['Page'])){$page = $_GET['Page'];}
									else{$page = 1;}
									if($page)
									{
										$page_size = 20;//每页的信息行数
										$strSql = "select count(*) as total from course;";//应用count 统计总的记录数
										$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
										$page_count = ceil($total/$page_size);//计算页数
										$offset=($page-1)*$page_size;
										
										$strSql = "select (@rowNO := @rowNo+1) AS rowno, creator,kid,coursename,start_time,end_time from course ,(select @rowNO :=0) b  where creator = '".$_SESSION['uid']."'  order by kid asc  limit $offset,$page_size;";
										$rsResult = $oDD->Query($strSql);
										
										while($rsCourse = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
										{
											echo '<tr class="tr1 vt"><td class="td1">'.($rsCourse['rowno']+$offset).'</td>';
											if($_SESSION['uid'])//==$rsCourse['creator'])
										  {
											echo '<td class="td1"><a href="editcourseinfo.php?kid='.$rsCourse['kid'].'">'.$rsCourse['coursename'].'</a></td>';
											echo '<td class="td1">'.$rsCourse['start_time'].'</td>';
											echo '<td class="td1">'.$rsCourse['end_time'].'</td></tr>';
										  }
										  else 
										  {
											echo '<td class="td1">'.$rsCourse['coursename'].'</td>';
											echo '<td class="td1"></td>';
											echo '<td class="td1"></td>';
											echo '<td class="td1"></td></tr>';
										  }
										}
									}
								?>
							</tbody>
					</table>
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
