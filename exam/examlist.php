<?php
	require_once 'template/header.tpl';
	require_once("../global.php");	

	if(isset($_SESSION['eeid']) && isset($_SESSION['euid']))
	{
			echo "<script language='javascript'>\n";
			echo 'parent.location.href = "exam.php";';
			echo "</script>";
	}
?>
		<div id="bt"><h2><center><?php echo $MSG_Exam_List;?></center></h2></div>
		<section class="page container">
			<div class="row">
			<div class="span2"></div>
			<div class="span12">
				<div class="box pattern pattern-sandstone">
					<div class="box-content box-table">	
					<table id="sample-table" class="table table-hover table-bordered">	
					<thead>
						<tr>
							<th class="menu" width="6%"  scope="col"><?php echo $MSG_ID;?></th>
							<th class="menu" width="30%" scope="col"><?php echo $MSG_Exam;?></th>
							<th class="menu" width="10%" scope="col"><?php echo $MSG_Exam_Creator;?></th>
							<th class="menu" width="18%" scope="col"><?php echo $MSG_StartTime;?></th>
							<th class="menu" width="18%" scope="col"><?php echo $MSG_EndTime;?></th>
							<th class="menu" width="11%" scope="col"><?php echo $MSG_Statuses;?></th>
							<!---<th class="menu" width="7%" scope="col"><?php echo '成绩单';?></th>--->
						</tr>
					</thead>
					<tbody>
						<?php
							if(isset($_GET['Page'])){$page = $_GET['Page'];}
							else{$page = 1;}

							$page_size = 10;//每页的信息行数
							$strSql = "select count(eid) as count from exam where defunct = 'Y';";//应用count 统计总的记录数
							$total = $oDD->GetValue($strSql,MYSQLI_NUM,0); //总记录数的值
							$page_count = ceil($total/$page_size);//计算页数
							$offset=($page-1)*$page_size;
							if($total==0)
							{
								echo '<tr ><td colspan="4"><font color="red">未搜索到考试信息</font></td></tr>';
							}	
							
							else
							{
								$strSql = "select (@rowNO := @rowNo+1) AS rowno, a.eid,a.title,a.start_time,a.end_time,c.name from exam as a ,(select @rowNO :=0) as b  ,manageruser as c where c.uid = a.creator and a.defunct = 'Y' order by a.eid DESC limit $offset,$page_size;";
								$rsResult = $oDD->Query($strSql);
								$ii = 1;
								while($rsExam = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
								{	
									echo '<tr><td>'.$rsExam['rowno'].'</td>';
									$strSql = "select count(*) from exam_user where eid = '".$rsExam['eid']."';";
									$totalt = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
									$curtime = strftime("%Y-%m-%d %H:%M:%S", time());
									if ( $totalt >= 1 )
									{
										if( $curtime >= $rsExam['start_time'] && $curtime <= $rsExam['end_time'] || isset($_SESSION['power']) && ($_SESSION['power'] == "admin") )
										{
											echo '<td><a href="exam.php?eid='.$rsExam['eid'].' ">'.$rsExam['title'].'</a></td>';
										}
										else
										{
											echo '<td>'.$rsExam['title'].'</a></td>';
										}
									}
									else
									{   
										echo '<td>无考试信息！</a></td>';
									}
									echo '<td>'.$rsExam['name'].'</td>';
									echo '<td>'.$rsExam['start_time'].'</td>';
									echo '<td>'.$rsExam['end_time'].'</td>';
									if($rsExam['start_time'] > strftime("%Y-%m-%d %H:%M:%S", time()))
									{
										echo '<td>'.$MSG_Status_One.'</td></tr>';
									}
									else
									{
										if($rsExam['end_time'] < strftime("%Y-%m-%d %H:%M:%S", time()))
										{
											echo '<td>'.$MSG_Status_Two.'</td>';
										}
										else
										{
											echo '<td>'.$MSG_Status_Three.'</td>';
										}
									}
									/* if ($ii < 3)
										echo '<td><a href="grade.php?id='.$ii.' ">成绩单</a></td></tr>';
									else
										echo '<td></td></tr>';
									$ii = $ii + 1;  */
								}
							}
						?>
					</tbody>
					<table>
						<Script Language="JavaScript">
							ShowoPage("","","<div id=\"pagechange\">页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
						</Script>
					</table>
				</table>
			</div>
			</div>
			</div>
			</div>
		</section>
<?php
	require_once 'template/footer.tpl';
?>