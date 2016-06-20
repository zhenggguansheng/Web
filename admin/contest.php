<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	$type = '1';
	unset($_SESSION['eid']);
	unset($_SESSION['kid']);
?>


<section class="page container">
    <div class="row">
		<div class="span2">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><a href="newcontest.php">添加竞赛</a></li></ul>	
				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5><?php echo $MSG_ManageContest;?></h5>
				</div>
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th><?php echo $MSG_ID;?>       </th>
								<th><?php echo $MSG_Title;?>    </th>
								<th><?php echo $MSG_StartTime;?></th>
								<th><?php echo $MSG_EndTime;?>  </th>
								<th><?php echo $MSG_Defunct;?>  </th>
							</tr>
						</thead>
						<tbody>
							<?php
								if(isset($_GET['Page'])){$page = $_GET['Page'];}
								else{$page = 1;}
								if($page)
								{
									$page_size = 20;//每页的信息行数
									$strSql = "select count(*) as total from contest;";//应用count 统计总的记录数
									$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
									$page_count = ceil($total/$page_size);//计算页数
									$offset=($page-1)*$page_size;
								
									$strSql = "select (@rowNO := @rowNo+1) AS rowno,cid,title,start_time,end_time,defunct from contest ,(select @rowNO :=0) b  order by cid limit $offset,$page_size;";
									$rsResult = $oDD->Query($strSql);
								
									while($rsContest = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
									{
										echo '<tr><td>'.($rsContest['rowno']+$offset).'</td>';
										echo '<td><a href="editcontestinfo.php?cid='.$rsContest['cid'].'">'.$rsContest['title'].'</td>';
										echo '<td>'.$rsContest['start_time'].'</td>';
										echo '<td>'.$rsContest['end_time'].'</td>';
										if($rsContest['defunct'] == "N")
										{
											$defunct = "不可见";
										}
										else{$defunct = "可见";}
										echo '<td>'.$defunct.'</td></tr>';
									}
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="pagechange">
		<Script Language="JavaScript">
				ShowoPage("","","<div id=\"pagechange\">页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
		</Script>
	</div>
</section>
<?php	
	require_once 'template/footer.tpl';
?>
