<?php
	require_once 'template/header.tpl';
	require_once '../global.php';
	require_once("../functions.php");	
	
	if(isset($_GET['kid']))
	{
		$kid = $oDD->EscapeString($_GET['kid']);
		$_SESSION['kkid'] = $kid;
		if(!isset($_SESSION['kkid']))
		{
			$_SESSION['kkid'] = $kid;
		}
	}else{$kid="";}
	
	confirmuserlogin(3);
	
	if(!isset($_SESSION['kkid']) && !isset($_SESSION['kuid']))
	{
			echo "<script language='javascript'>\n";
			echo 'parent.location.href = "../home.php";';
			echo "</script>";
	}

	if(isset($_SESSION['kuid']))
	{
		$uid = $_SESSION['kuid'];
	}
	else{$uid="";}
	if(isset($_SESSION['kkid']))
	{
		$kid = $_SESSION['kkid'];
	}
	else{$kid="";}

	$strSql="select coursename from course where kid= '".$kid."';";
	$coursename=$oDD->GetValue($strSql, MYSQLI_NUM, 0);
?>
<div id="bt">
    <h2><center><?php echo $coursename;?></center></h2>
</div>


<section class="page container">
	<div class="row">
		<div class="span2"></div>
		<div class="span12">
			<div class="box pattern pattern-sandstone">
			<div class="box-content box-table">
			<div class="box"> 
				<table id="sample-table" class="table table-hover table-bordered">						
					<thead>
					   <tr>
						 <th class="menu" width="15%" scope="col"><?php echo $MSG_Problem_ID;?></th>
						 <th class="menu" width="65%" scope="col"><?php echo $MSG_Problem;?></th>
						 <th class="menu" width="25%" scope="col"><?php echo $MSG_Status;?></th>
						</tr>
					</thead>
					<tbody>
					<?php
						if(isset($_GET['Page'])){$page = $_GET['Page'];}
						else{$page = 1;}
						$strSql = "select count(*) as total from course_user where kid='".$kid."' and uid='".$uid."';";//应用count 统计总的记录数
						$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
						if ( $total == 0 && !isset($_SESSION['power']))
							echo '<tr ><td colspan="5"><font color="red">你不在课程中，无法进入！</font></td></tr>';
						else  
						{
							$page_size = 50;//每页的信息行数
							$strSql = "select count(*) as total from course_problem  where kid='".$kid."';";//应用count 统计总的记录数
							$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
							$page_count = ceil($total/$page_size);//计算页数
							$offset=($page-1)*$page_size;			
							if($total==0)
							{
								echo '<tr ><td colspan="5"><font color="red">未搜索到题目信息</font></td></tr>';
							}

							$strSql   = "select pid,logicpid from course_problem where kid= '".$kid."' order by logicpid ;";
							$rsResult = $oDD->Query($strSql);
							while($rsCourse = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
							{	
								//,
										//COUNT(CASE  WHEN result = 1 THEN result END) as totalaccept,
										//COUNT(*) as total
								$strSql = "SELECT  count(result) as total
								  FROM  solution where uid = '".$uid."' and result = 1 and kid = '".$kid."' and pid = '".$rsCourse['pid']."' ;";
								
								$total1   = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
								/*$accepted = $oDD->GetValue($strSql, MYSQLI_NUM, 1);
								$submit   = $oDD->GetValue($strSql, MYSQLI_NUM, 2);
								*/
								
								$strSql = "select title from problem where pid='".$rsCourse['pid']."';";
								$title = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
								/*
								if($submit == 0){$ratio = 0;}
								else {$ratio = round(($accepted/$submit)*100 ,2);}
								*/
								echo "<tr><td>".$rsCourse['logicpid']."</td>";
								echo '<td><a href="problem.php?logicpid='.$rsCourse['logicpid'].'">'.$title.'</a></td>';
								if($total1 == 0)
								{
									echo "<td>".ToDo."</td>";
								}
								else
								{
									echo "<td>".Accepted."(ac)</td></tr>";
								}
								
								//echo "<tr><td>".$rsProblem['logicpid']."</td>";
								//echo '<td><a href="problem.php?logicpid='.$rsProblem['logicpid'].'">'.$title.'</a></td>';			
								//echo '<td>'.$ratio.'%</td>';
								//echo '<td>'.$accepted.'</td>';
								//echo '<td>'.$submit.'</td></tr>';
							}
						}
					?>
					</tbody>
					<table>
						<Script Language="JavaScript">
							ShowoPage("","","<div id=\"pagechange\">页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]</div>","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
						</Script>
					</table>
				</table>
			</div>
			</div>
			</div>
		</div>
	</div>
</section>
<?php
	require_once 'template/footer.tpl';
?>