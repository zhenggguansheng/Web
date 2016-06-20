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
    	
	if(isset($_SESSION['uid']))
	{
		$uid = $_SESSION['uid'];
	}
	else{$uid="";}
    
	if (!empty($uid) || !empty($cid)||isset($_SESSION['power']))	
    {
	    $strSql = "select * from contest_user where cid= '".$cid."' and uid ='".$uid."';";
	
	    $rsResult = $oDD->Query($strSql);
	    $count = $oDD->NumOfRows($rsResult);
	
		
	    //if($count == 0 || !isset($_SESSION['power'])) // 2014_11_7
	    if($count == 0 )
	    {
		    echo "<script language='javascript'>\n";
		
		    echo 'parent.location.href = "contestlist.php";';
		    echo "</script>";
	    }

	    $strSql = "select * from contest where cid = '".$cid."';";
	    $rsResult = $oDD->Query($strSql);
	    $rsContest = $oDD->FetchArray($rsResult,MYSQLI_ASSOC);
	    $description = str_replace("<p>","",$rsContest['description']);
	    $description2 = str_replace("</p>","",$description);
	    $strDes = $MSG_Description .' : '. $description2;
    }
    else
    {
         echo "<script language='javascript'>\n";
	     echo "alert(\"请先登录！\");";
		 echo 'parent.location.href = "contestlogin.php";';
		 echo "</script>";
    }
?>
<div id="bt">
	<div><h2><center><?php echo $rsContest['title'];?></center></h2></div>
</div>
<div id="bt">
	<div><h3><?php echo $strDes; ?></br></h3></div>
	<div><h3><center><?php echo $MSG_Timeplus.' : '.$rsContest['timeplus'].'min';?></center></h3></div>             
	<div><h3><center><?php echo $MSG_StartTime.' : '.$rsContest['start_time'].'&nbsp;&nbsp;&nbsp;&nbsp;'.$MSG_EndTime.' : '.$rsContest['end_time'];?> </center></h3></div>
</div>
<div id="table">
	<table >
		<tr>
			 <th class="menu" width="23%" scope="col"><?php echo $MSG_Problem_ID;?></th>
			 <th class="menu" width="23%" scope="col"><?php echo $MSG_Problem;?></th>
			 <th class="menu" width="15%" scope="col"><?php echo $MSG_Ratio;?></th>
			 <th class="menu" width="16%" scope="col"><?php echo $MSG_Accept;?></th>
			 <th class="menu" width="23%" scope="col"><?php echo $MSG_Submit;?></th>
		</tr>
		<?php
		if(isset($_GET['Page'])){$page = $_GET['Page'];}
		else{$page = 1;}
		if($page)
		{
			$page_size = 10;//每页的信息行数
			$strSql = "select count(*) as total from contest_problem where cid='".$cid."';";//应用count 统计总的记录数
			$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
			$page_count = ceil($total/$page_size);//计算页数
			$offset=($page-1)*$page_size;
			if($total == 0 && !isset($_SESSION['power']))
			{
				echo '<tr><td colspan="5"><font color="red">未搜索到相关信息</font></td></tr>';
			}
			else 
			{	
				$end_time =  strftime("%Y-%m-%d %H:%M:%S", time());
				$strSql = "select * from contest_problem where cid=".$cid." order by logicpid  limit $offset,$page_size;";
				$rsResult = $oDD->Query($strSql);

				while($rsContest = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
				{	
			
					$strSql = "SELECT  COUNT(CASE  WHEN uid = '".$uid."' and result = 1 THEN uid  END) as accept,
							COUNT(CASE  WHEN result = 1 THEN result END) as totalaccept,
							COUNT(*) as total FROM  solution where cid = '".$cid."' and pid = '".$rsContest['pid']."' ;";
					
					$total1   = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
					$accepted = $oDD->GetValue($strSql, MYSQLI_NUM, 1);
					$submit   = $oDD->GetValue($strSql, MYSQLI_NUM, 2);
					
					if($submit == 0){$ratio = 0;}
					else {$ratio = round(($accepted/$submit)*100 ,2);}
					
					
					$strSql = "select title from problem where pid='".$rsContest['pid']."';";
					$title = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
			
					if($total1 == 0)
					{
						echo "<tr><td>".$rsContest['logicpid']."</td>";
					}
					else
					{
						echo "<tr><td>".$rsContest['logicpid']."(ac)</td>";
					}

					echo '<td><a href="problem.php?logicpid='.$rsContest['logicpid'].'">'.$title.'</a></td>';
					echo '<td>'.$ratio.' %</td>';
					echo '<td>'.$accepted.'</td>';
					echo '<td>'.$submit.'</td></tr>';			
				}
						
			}
		}
		?>	
		<Script Language="JavaScript">
			ShowoPage("","","<div id=\"pagechange\">页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
		</Script>
	</table>
</div>	

	
<div style="clear: both;">&nbsp;</div>
</div>
<?php
	require_once 'template/footer.tpl';
?>