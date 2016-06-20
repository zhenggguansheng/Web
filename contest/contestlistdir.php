<?php
	require_once 'template/header.tpl';
	require_once("global.php");		
?>
<div id="bt">
	<h2><center><?php echo $MSG_Contest_List;?></center></h2>
</div>

<div id="table">
	<table>
		<?php
		if(isset($_SESSION['uid']))
		{
			$uid = $_SESSION['uid'];
		}
		else
		{
			$uid = "";
		}
		
		echo '<tr>
					<th class="menu" width="15%" scope="col" >'.$MSG_ID.'</th>
					<th class="menu" width="35%" scope="col">'.$MSG_Title.'</th>
					<th class="menu"  width="35%" scope="col">'.$MSG_StartTime.'</th>
					<th class="menu"  width="15%" scope="col">'.$MSG_Status.'</th>
				</tr>';
				
		if(isset($_GET['Page'])){$page = $_GET['Page'];}
		else{$page = 1;}
		if($page)
		{
			$page_size = 50;//每页的信息行数
			$strSql = "select count(*) as total from contest ;";//应用count 统计总的记录数
			$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
			$page_count = ceil($total/$page_size);//计算页数
			$offset=($page-1)*$page_size;

			$strSql ="select * from contest order by cid limit $offset,$page_size;";
			$rsResult= $oDD->Query($strSql);
			$count = $oDD->NumOfRows($rsResult);
			if($count==0)
		{
			echo '<tr ><td colspan="4"><font color="red">未搜索到比赛信息</font></td></tr>';
		}
			while($rsContest = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
			{		
				echo '<tr><td>'.$rsContest['cid'].'</td>';
				if(strftime("%Y-%m-%d %H:%M:%S", time()) > $rsContest['start_time'] && strftime("%Y-%m-%d %H:%M:%S", time()) < $rsContest['end_time']) {
					if($uid != "")
					{
						$strSql = "select count(*) as total from contest_user where uid = '".$uid."' and cid = '".$rsContest['cid']."' and room is not null and seat is not null;";
						$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
						echo '<td><a href="contest.php?cid='.$rsContest['cid'].' ">'.$rsContest['title'].'</a></td>';
						//if($total == 1)
						//{
						//	echo '<td><a href="contest/contest.php?cid='.$rsContest['cid'].' ">'.$rsContest['title'].'</a></td>';
						//}
						//else
						//{
						//	echo '<td><a href="javascript:pop_confirm('.$rsContest['cid'].')">'.$rsContest['title'].'</a></td>';
						//}
					}
					else
					{
						echo '<td><a href="contest.php?cid='.$rsContest['cid'].' ">'.$rsContest['title'].'</a></td>';
					}
				}
				else 
				{
					echo "<td>".$rsContest['title']."</td>";
				}
				echo '<td>'.$rsContest['start_time'].'</td>';
				if($rsContest['start_time'] > strftime("%Y-%m-%d %H:%M:%S", time()))
				{
					echo '<td>'.$MSG_Status_One.'</td></tr>';
				}
				else
				{
					if($rsContest['end_time'] < strftime("%Y-%m-%d %H:%M:%S", time()))
					{
						echo '<td>'.$MSG_Status_Two.'</td></tr>';
					}
					else
					{
						echo '<td>'.$MSG_Status_Three.'</td></tr>';
					}
				}
			}
		}
		?>
         <Script Language="JavaScript">
			ShowoPage("","","<div id=\"pagechange\">页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
		</Script>
    </table>
</div>


	 
<?php
	require_once 'template/footer.tpl';
?>