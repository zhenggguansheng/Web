<?php
	require_once 'template/header.tpl';
	require_once("../global.php");	
	require_once '../functions.php';

   	if(isset($_GET['cid']))
	{
		 $cid = $oDD->EscapeString($_GET['cid']);
         $_SESSION['ccid'] = $cid;
         if(!isset($_SESSION['ccid']))
	     {
		      $_SESSION['ccid'] = $cid;
	     } 
    }
	else{$cid = "";}  //再改
  
    confirmuserlogin(1);

	if(isset($_SESSION['ccid']) && isset($_SESSION['cuid']))
	{
			echo "<script language='javascript'>\n";
			echo 'parent.location.href = "contest.php";';
			echo "</script>";
	}
	
	if(isset($_SESSION['cuid']))
	{
		$uid = $oDD->EscapeString($_SESSION['cuid']);
		$uidSQL = " solution.cid = '".$uid."' ";
	    $strSql = "select * from contest_user where uid ='".$uid."';";
	
	    $rsResult = $oDD->Query($strSql);
	    $count = $oDD->NumOfRows($rsResult);	
	    if($count == 0&&!isset($_SESSION['power']))
	    {
		    echo "<script language='javascript'>\n";
		
		    echo 'parent.location.href = "contestlogin.php";';
		    echo "</script>";
	    }			
     }
	else
	{
		$uid="";
		if (!isset($_SESSION['power']))
        {
            echo "<script language='javascript'>\n";
	        echo "alert(\"请先登录！\");";
		    echo 'parent.location.href = "contestlogin.php";';
		    echo "</script>";
		    exit;
         }
	}


?>
<div id="bt">
	<h2><center><?php echo $MSG_Contest_List;?></center></h2>
</div>


<div id="table">
	<table>
		<tr>
			<th class="menu" width="15%" scope="col" ><?php echo $MSG_ID ;?></th>
			<th class="menu" width="35%" scope="col"><?php echo $MSG_Title ;?></th>
			<th class="menu" width="20%" scope="col"><?php echo $MSG_StartTime;?></th>
			<th class="menu" width="20%" scope="col"><?php echo $MSG_EndTime;?></th>
			<th class="menu" width="15%" scope="col"><?php echo $MSG_Status ;?></th>
		</tr>
		<?php
			if(isset($_SESSION['uid']))
			{
				$uid = $_SESSION['uid'];
			}
			else
			{
				$uid = "";
			}
			
			if(isset($_GET['Page'])){$page = $_GET['Page'];}
			else{$page = 1;}
			if($page)
			{
				$page_size = 50;//每页的信息行数
				$strSql = "select count(*) as total from contest ;";//应用count 统计总的记录数
				$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
				$page_count = ceil($total/$page_size);//计算页数
				$offset=($page-1)*$page_size;
				if($total==0)
				{
					echo '<tr ><td colspan="4"><font color="red">未搜索到比赛信息</font></td></tr>';
				}
				$strSql ="select (@rowNO := @rowNo+1) AS rowno, a.cid,a.title,a.start_time,a.end_time from contest as a ,(select @rowNO :=0) as b, contest_user as c where a.cid = c.cid and c.uid = '".$uid."' order by a.cid DESC limit $offset,$page_size;";
				
				$rsResult= $oDD->Query($strSql);
				$count = $oDD->NumOfRows($rsResult);
				
				while($rsContest = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
				{		
					echo '<tr><td>'.$rsContest['rowno'].'</td>';
					if(strftime("%Y-%m-%d %H:%M:%S", time()) > $rsContest['start_time'] && strftime("%Y-%m-%d %H:%M:%S", time()) < $rsContest['end_time'])
					{
						if($uid != "")
						{
							echo '<td><a href="contest.php?cid='.$rsContest['cid'].' ">'.$rsContest['title'].'</a></td>';
						}
					
					}
					else 
					{
						if (isset($_SESSION['power']) && ($_SESSION['power'] == "admin"))
                        {
							echo '<td><a href="contest.php?cid='.$rsContest['cid'].' ">'.$rsContest['title'].'</a></td>';
						}
						else
						{
							echo "<td>".$rsContest['title']."</td>";
						}
					}
					echo '<td>'.$rsContest['start_time'].'</td>';
					echo '<td>'.$rsContest['end_time'].'</td>';
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
		<div>
		<Script Language="JavaScript">
			ShowoPage("","","<div id=\"pagechange\">页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
		</Script></div>
    </table>
</div>
<div id="table">			
	<Script Language="JavaScript">
		ShowoPage("","","<div id=\"pagechange\">页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
	</Script></div>
</div>
<?php
	require_once 'template/footer.tpl';
?>
</body>