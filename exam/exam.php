<?php
	require_once 'template/header.tpl';
	require_once '../global.php';
	require_once("../functions.php");	
	
	if(isset($_GET['eid']))
	{
		$_SESSION['eeid'] = $oDD->EscapeString($_GET['eid']);
		$eid = $oDD->EscapeString($_GET['eid']);
		$_SESSION['eeid'] =$eid;
		if(!isset($_SESSION['eeid']))
		{
			$_SESSION['eeid'] = $eid;
		}
	}else{$eid="";}
	
	confirmuserlogin(2);
	
	if(!isset($_SESSION['eeid']) && !isset($_SESSION['euid']))
	{
			echo "<script language='javascript'>\n";
			echo 'parent.location.href = "examlist.php";';
			echo "</script>";
	}


	if(isset($_SESSION['euid']))
	{
		$uid = $_SESSION['euid'];
	}
	else{$uid="";}
	if(isset($_SESSION['eeid']))
	{
		$eid = $_SESSION['eeid'];
	}
	else{$eid="";}


	$strSql = "select * from exam where eid = '".$eid."';";
	$rsResult = $oDD->Query($strSql);
	$rsExam = $oDD->FetchArray($rsResult,MYSQLI_ASSOC);
	
	$_SESSION['end_time'] = $rsExam['end_time'];
	$in_date = strftime("%Y-%m-%d %H:%M:%S", time());
	if ($_SESSION['end_time'] < $in_date && ($_SESSION['power'] != "admin") )
	{
		echo "<script language='javascript'>\n";
		echo "alert(\"考试时间到！\");";
		echo 'parent.location.href = "../exit.php";';
		echo "</script>";
		exit;
	}

?>


<section class="page container">
	<div class="row">
		<div class="span2"></div>
		<div class="span12">
			<div class="box pattern pattern-sandstone">
			<div class="box-content box-table">
				<div class="box"> 
					<div class="box-header"> 
							  <h3><?php echo $rsExam['title'];?></h3> 
					</div> 
					<div class="box-content">
					<blockquote>
						<?php 
						   $description = str_replace("<p>","",$rsExam['description']);
						   $description2 = str_replace("</p>","",$description);
						   echo '<p>'. $MSG_Description.' : '.$description2.'<br /></p>';
						   echo '<p>'. $MSG_Timeplus.' : '.$rsExam['timeplus'].'min (每次不正确的提交增加的时间，计入总用时，以便排名)<br /></p>';               
						   echo '<p>'. $MSG_StartTime.' : '.$rsExam['start_time'].'&nbsp;&nbsp;&nbsp;&nbsp;'.$MSG_EndTime.' : '.$rsExam['end_time'].'</p>' ;
						?>
					</blockquote>
					</div>
				</div>
				<table id="sample-table" class="table table-hover table-bordered">						
					<thead>
					   <tr>
						 <th class="menu" width="15%" scope="col"><?php echo $MSG_Problem_ID;?></th>
						 <th class="menu" width="50%" scope="col"><?php echo $MSG_Problem;?></th>
						 <th class="menu" width="25%" scope="col"><?php echo $MSG_Status;?></th>
						 <!--
						 <th class="menu" width="25%" scope="col"><?php echo $MSG_Ratio;?></th>
						 <th class="menu" width="15%" scope="col"><?php echo $MSG_Number;?></th>
						 <th class="menu" width="15%" scope="col"><?php echo $MSG_Submit?></th>
						 -->
						</tr>
					</thead>
					<tbody>
						<form action="exam.php" method="get">
						  <?php
								if(isset($_GET['Page'])){$page = $_GET['Page'];}
								else{$page = 1;}
								$page_size = 10;//每页的信息行数
								$strSql = "select count(*) as total from exam_problem where eid=".$eid.";";//应用count 统计总的记录数
								$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
								$page_count = ceil($total/$page_size);//计算页数
								$offset=($page-1)*$page_size;
								if($total == 0 && !isset($_SESSION['power']))
								{
									echo '<tr><td colspan="5"><font color="red">未搜索到相关信息</font></td></tr>';
								}
								else 
								{	
									$strSql   = "select * from exam_problem where eid=".$eid." order by logicpid  limit $offset,$page_size;";
									$rsResult = $oDD->Query($strSql);
									while($rsExam = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
									{	
										$strSql = "SELECT  count(result) as total
										  FROM  solution where uid = '".$uid."' and result = 1 and eid = '".$eid."' and pid = '".$rsExam['pid']."' ;";
										
										$total1   = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
										$strSql = "select title from problem where pid='".$rsExam['pid']."';";
										$title = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
										echo "<tr><td>".$rsExam['logicpid']."</td>";
										echo '<td><a href="problem.php?logicpid='.$rsExam['logicpid'].'">'.$title.'</a></td>';
										if($total1 == 0)
										{
											echo "<td>"."To Do"."</td>";
										}
										else
										{
											echo "<td>". 'Accepted'."(ac)</td></tr>";
										}	
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