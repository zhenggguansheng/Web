<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
?>

<Script Language="JavaScript" type="text/JavaScript" src="../include/js/showo_page.js"></Script>

<section class="container">
    <div class="row">
		<div class="span3">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><p><a href="addnews.php">添加公告</a></p></li>
				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>公告管理</h5>
				</div>							
				<div class="box-content box-table">
					<form action="news.php" method="get">
					<table class="table table-hover table-bordered">
						<thead>
							<th>编号</th>
							<th>时间</th>
							<th>公告内容</th>
							<th>操作</th>
						</thead>
						<tbody>
							<?php
								if(isset($_GET['Page'])){$page = $_GET['Page'];}
								else{$page = 1;}
								if($page)
								{
									$page_size = 20;//每页的信息行数
									$strSql = "select count(*) as total from news";//应用count 统计总的记录数
									$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
									$page_count = ceil($total/$page_size);//计算页数
									$offset=($page-1)*$page_size;
									
									$strSql = "select (@rowNO := @rowNo+1) AS rowno, nid,in_date,data from news ,(select @rowNO :=0) b order by nid limit $offset,$page_size;";
									$rsResult = $oDD->Query($strSql);
									
									while($rsNews = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
									{
										echo '<tr><td>'.$rsNews['rowno'].'</td>';
										echo '<td>'.$rsNews['in_date'].'</td>';
										echo '<td><a href="editnews.php?nid='.$rsNews['nid'].'">'.$rsNews['data'].'</a></td>';
										echo '<td><a href="delete.php?nid='.$rsNews['nid'].'" onclick="return confirm(\'确认删除这条记录？\')">删除</a></td></tr>';
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
