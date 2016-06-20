<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	unset($_SESSION['eid']);
	unset($_SESSION['cid']);
	unset($_SESSION['kid']);
?>

<script Language="JavaScript" type="text/JavaScript" src="../include/js/showo_page.js"></script>
<section class="container">
    <div class="row">
		<div class="span2">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><p><a href="newproblem.php">添加题目</a></p></li>
				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>题库管理</h5>
				</div>
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<thead>
							<th>序号    </th>
							<th>题目编号</th>
							<th>逻辑编号</th>
							<th>题目标题</th>
							<th>可见性  </th>
							<!-- 
							<th>操作    </th>
							-->
						</thead>
						<tbody>
						<?php    
							if(isset($_GET['Page'])){$page = $_GET['Page'];}
							else{$page = 1;}
							if($page)
							{	
								$page_size = 50;//每页的信息行数
								$strSql = "select count(*) as total from problem;";//应用count 统计总的记录数
								$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
								$page_count = ceil($total/$page_size);//计算页数
								$offset=($page-1)*$page_size;
								
								$strSql = "select (@rowNO := @rowNo+1) AS rowno, pid, logicpid, title,defunct from problem ,(select @rowNO :=0) b order by pid limit $offset,$page_size;;";
								$rsResult = $oDD->Query($strSql);
							
								while($rsProblem = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
								{
									echo '<tr><td>'.($rsProblem['rowno'] + $offset).'</td>';
									echo '<td>'.$rsProblem['pid'].'</td>';
									echo '<td>'.$rsProblem['logicpid'].'</td>';
									echo '<td><a href="problem.php?pid='.$rsProblem['pid'].'">'.$rsProblem['title'].'</a></td>';
									if($rsProblem['defunct'] == "N")
									{
										$defunct = "不可见";
									}
									else{$defunct = "可见";}
									echo '<td>'.$defunct.'</td>';
									//echo '<td><a href="delete.php?pid='.$rsProblem['pid'].'" onclick="return confirm(\'确认要删除这条记录吗？\')";>删除</a></td></tr>';
									echo '<td></td></tr>';
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
				</div>
			</div>
		</div>
	</div>
</section>

<?php	
	require_once 'template/footer.tpl';
?>
