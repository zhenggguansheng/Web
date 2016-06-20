<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	unset($_SESSION['eid']);
	unset($_SESSION['cid']);
	unset($_SESSION['kid']);

?>

<Script Language="JavaScript" type="text/JavaScript" src="../include/js/showo_page.js"></Script>
<section class="container">
    <div class="row">
		<div class="span3">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><p><a href="newmanager.php">添加管理员</a></p></li>
					<li><p><a href="adminstatus.php">测试记录</a></p></li>
					<li><p><a href="deletejudging.php">解决Judging</a></p></li>
 				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>教师管理</h5>
				</div>							
				<div class="box-content box-table">
					<form action="manageruser.php" method="get">
					<table class="table table-hover table-bordered">
						<thead>
							<th>序号</th>
							<th>用户名称</th>
							<th>用户类别</th>
							<th>权限</th>
						</thead>
						<tbody>
							<?php    
								if(isset($_GET['Page'])){$page = $_GET['Page'];}
								else{$page = 1;}
								if($page)
								{
										$page_size = 20;//每页的信息行数
										$strSql = "select count(*) as total from manageruser;";//应用count 统计总的记录数
										$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
										$page_count = ceil($total/$page_size);//计算页数
										$offset=($page-1)*$page_size;
										$strSql = "select (@rowNO := @rowNo+1) AS rowno, uid,user_name,name,authority_id from manageruser ,(select @rowNO :=0) b where uid  > 1 order by uid limit $offset,$page_size;";
										$rsResult = $oDD->Query($strSql);
										while($rsManager = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
										{
											echo '<tr><td>'.$rsManager['rowno'].'</td>';
											echo '<td><a href="edituserinfo.php?id='.$rsManager['uid'].'">'.$rsManager['user_name'].'</a></td>';
											echo '<td>'.$rsManager['name'].'</td>';
								
											if($rsManager['authority_id'] == "0")
											{
													$authority_id = "管理员";
											}
											else{$authority_id = "课程负责人";}
											echo '<td>'.$authority_id.'</td></tr>';
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
