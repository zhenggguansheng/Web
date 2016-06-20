<?php
	require_once 'template/header.tpl';
	require_once("../global.php");

	if(isset($_SESSION['kkid']) && isset($_SESSION['kuid']))
	{
			echo "<script language='javascript'>\n";
			echo 'parent.location.href = "course.php";';
			echo "</script>";
	}
?>
<div id="bt">
	<h2><center><?php echo $MSG_Course_List;?></center></h2>
</div>


<section class="page container">
	<div class="row">
		<div class="span2"></div>
	<div class="span12">
	<div class="box pattern pattern-sandstone">
	<div class="box-content box-table">
		<table id="sample-table" class="table table-hover table-bordered">						
			<thead>
			   <tr>
					<th   class="menu" width="5%" scope="col" ><?php echo $MSG_ID;?></th>
					<th   class="menu" width="20%" scope="col"><?php echo $MSG_Course;?></th>
					<th   class="menu" width="10%" scope="col">课程状态</th>
					<th   class="menu" width="10%" scope="col"><?php echo $MSG_Exam_Creator;?></th>
					<th   class="menu" width="15%" scope="col"><?php echo $MSG_Student_Number;?></th>
				</tr>
			</thead>
			<tbody>
				<?php
					if(isset($_GET['Page'])){$page = $_GET['Page'];}
					else{$page = 1;}
					if($page)
					{
						$page_size = 50;//每页的信息行数
						$strSql = "select count(*) as total from course ;";//应用count 统计总的记录数
						$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
						$page_count = ceil($total/$page_size);//计算页数
						$offset=($page-1)*$page_size;

						$strSql = "select (@rowNO := @rowNo+1) AS rowno, a.kid,a.coursename,c.name,a.start_time,a.end_time from course a,(select @rowNO :=0) as b ,manageruser c where  (a.creator = c.uid) order by a.kid DESC limit $offset,$page_size;";
						$rsResult= $oDD->Query($strSql);
						$count = $oDD->NumOfRows($rsResult);
						if($count==0)
						{
							echo '<tr ><td colspan="4"><font color="red">未搜索到课程信息</font></td></tr>';
						}
						while($rsCourse = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
						{		
							echo '<tr><td>'.$rsCourse['rowno'].'</td>';
							$strSql = "select count(*) as total from course_user where  kid = '".$rsCourse['kid']."';";
							$totalA = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
							if( strftime("%Y-%m-%d %H:%M:%S", time()) > $rsCourse['start_time'] && 
									strftime("%Y-%m-%d %H:%M:%S", time()) < $rsCourse['end_time'] )
							{
								if($totalA >= 1)
								{
									echo '<td><a href="course.php?kid='.$rsCourse['kid'].' ">'.$rsCourse['coursename'].'</a></td>';
									echo '<td>正常</td>';
								}
							}
							else
							{
								if (isset($_SESSION['power']) && ($_SESSION['power'] == "admin"))
								{
									echo '<td><a href="course.php?kid='.$rsCourse['kid'].' ">'.$rsCourse['coursename'].'</a></td>';
								}
								else
								{
									echo '<td>'.$rsCourse['coursename'].'</td>';
								}
								echo '<td>课程结束</td>';
							}
							echo '<td>'.$rsCourse['name'].'</td>';
							echo '<td>'.$totalA.'</td></tr>';
							
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