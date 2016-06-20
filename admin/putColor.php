<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	$type = '1';
	unset($_SESSION['eid']);
	unset($_SESSION['kid']);
	
	if(isset($_SESSION['cid']))
	{
		$cid = $oDD->EscapeString($_SESSION['cid']);
	}	
	else {$cid = ""; }
	if($cid!="")
	{
		$strSql = "select title from contest where cid='".$cid."';";
		$contest = $oDD->GetValue($strSql,MYSQLI_NUM,0);
	}
	
?>

<Script Language="JavaScript" type="text/JavaScript" src="../include/js/showo_page.js"></Script>


<script>	
function myrefresh(people)
{
	if(people != 0)
	{
		alert("有"+people+"个人的气球没有放置");
	}
	window.location.reload();
}
</script>
<?php
		$strSql = "select count(distinct uid) as totall from solution where uid >= 120 and cid = '".$cid."' and result = 1 and mark=0;";
		$rstotal = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
		echo '<script language="JavaScript">setTimeout("myrefresh('.$rstotal.')",60000);</script>';
?>


<section class="container">
    <div class="row">
		<div class="span2">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><p><a href="editcontestinfo.php">信息编辑</a></p></li>
					<li><p><a href="editproblem.php">题目列表</a></p></li>
					<li><p><a href="addproblem.php">添加题目</a></p></li>
					<li><p><a href="editstudent.php">学生列表</a></p></li>
					<li><p><a href="addstudent.php">添加学生</a></p></li>
					<li><p><a href="status.php">状态</a></p></li>
					<li><p><a href="ranklist.php">排名</a></p></li>
					<li><p><a href="statistics.php">统计</a></p></li>
					<li><p><a href="putColor.php">气球登记</a></p></li>
				</ul>
			</div>
		</div>
		<div class="span14">
			<div class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i><h5> 气球统计 >>>> <?php echo $contest;?></h5>
				</div>
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<thead>
							<th>学号  </th>
							<th>姓名  </th>
							<th>教室  </th>
							<th>座位号</th>
							<?php
								$strSql = "select * from contest_problem where cid = '".$cid."' order by logicpid ASC;";
								$rsResult_p = $oDD->Query($strSql);
								while($rsP = $oDD->FetchArray($rsResult_p, MYSQLI_ASSOC))
								{
									echo '<th>'.$rsP['logicpid']."::". $rsP['color'].'</th>';
								}
							?>
							</tr>
						</thead>
						<tbody>
							
							<?php

								$strSql = "select * from contest_user where uid >= 120 and cid = '".$cid."' and uid not in (select distinct uid from solution where cid = '".$cid."' and result = 1 and mark=0);";
								$rsUu = $oDD->Query($strSql);
								while($rsU = $oDD->FetchArray($rsUu, MYSQLI_ASSOC))
								{
									$strSql = "select * from commonuser where uid='".$rsU['uid']."';";
									$rsUuu = $oDD->Query($strSql);
									echo '<tr>';
									if($rsURS = $oDD->FetchArray($rsUuu, MYSQLI_ASSOC))
									{
										echo '<td>'.$rsURS['student_num'].'</td>';
										echo '<td>'.$rsURS['name'].'</td>';
										echo '<td>'.$rsU['room'].'</td>';
										echo '<td>'.$rsU['seat'].'</td>';
									}
									$strSql = "select * from contest_problem where cid = '".$cid."' order by logicpid ASC;";
									$rsResult_p = $oDD->Query($strSql);
									while($rsP = $oDD->FetchArray($rsResult_p, MYSQLI_ASSOC))
									{
										$strSql = "select count(*) from solution where uid='".$rsU['uid']."' and logicpid='".$rsP['logicpid']."' and result = 1 and cid = '".$cid."' and mark=1;";
										$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
										if($total != 0)
										{
											echo '<td>通过</td>';
										}
										else
										{
											echo '<td></td>';
										}
									}
									echo '</tr>';
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