<?php
	require_once 'template/header.tpl';
	require_once 'global.php';
	require_once '../functions.php';
	
	confirmlogin();
	
	$type = 2;
	unset($_SESSION['cid']);
	unset($_SESSION['kid']);
	if(isset($_SESSION['uid']))
	{
	   $uid = $_SESSION['uid'];
	}
	else { $uid = "";}
?>

<Script Language="JavaScript" type="text/JavaScript" src="../include/js/showo_page.js"></Script>


<section class="page container">
    <div class="row">
		<div class="span2">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><p><a href="newexam.php">添加考试</a></p></li>
 				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5><?php echo $MSG_ManageExam;?></h5>
				</div>
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<thead>
							<th>序号    </th>
							<th>考试编号</th>
							<th>考试名称</th>
							<th>开始时间</th>
							<th>结束时间</th>
							<th>可见性  </th>
						</thead>
						<tbody>
							<?php
								if(isset($_GET['Page'])){$page = $_GET['Page'];}
								else{$page = 1;}
								if($page)
								{
									$page_size = 20;//每页的信息行数
									$strSql = "select count(*) as total from exam;";//应用count 统计总的记录数
									$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
									$page_count = ceil($total/$page_size);//计算页数
									$offset=($page-1)*$page_size;
									if ( !empty($uid) )
									{		
										$strSql = "select (@rowNO := @rowNo+1) AS rowno, eid,title,start_time,end_time,defunct from exam ,(select @rowNO :=0) b  where creator = '".$_SESSION['uid']."' order by eid limit $offset,$page_size;";
										$rsResult = $oDD->Query($strSql);
										
										while($rsExam = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
										{
											echo '<tr><td>'.$rsExam['rowno'].'</td>';
											echo '<td>'.$rsExam['eid'].'</td>';
											echo '<td><a href="editexaminfo.php?eid='.$rsExam['eid'].'">'.$rsExam['title'].'</a></td>';
											echo '<td>'.$rsExam['start_time'].'</td>';
											echo '<td>'.$rsExam['end_time'].'</td>';
											if($rsExam['defunct'] == "N")
											{
												$defunct = "不可见";
											}
											else{$defunct = "可见";}
											echo '<td>'.$defunct.'</td></tr>';
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
