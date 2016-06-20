<?php
	require_once 'global.php';
	require_once 'template/header.tpl';
	require_once '../functions.php';
	
	if(isset($_SESSION['ccid']))
	{
		$cid = $oDD->EscapeString($_SESSION['ccid']);
	}
	else{	$cid="";}
	
	confirmuserlogin(1);
		
	
///////////////	
    if (!empty($cid))
    {
        $strSql = "select end_time from contest where cid = '".$cid."';";
        $rsEndTime = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
	    $EndTime = strtotime($rsEndTime);//比赛结束时间
	    $EndBefore = $EndTime - 1800;//比赛前30分钟
	    $Now = time();//当前时间
	    if(($Now>$EndBefore) && ($Now<$EndTime) && !isset($_SESSION['power']))
	    {
		    echo "<script language='javascript'>\n";
		    echo 'alert("此时间您没有权限查看排名！");';
		    echo 'parent.location.href = "contest.php";';
		    echo "</script>";
		    exit;
	    }
        else
        {
             $strSql = "call proranklist(1,$cid)";
 	         $rsResult = $oDD->Query($strSql);
        }
    }
    else
    {
            echo "<script language='javascript'>\n";
	        echo "alert(\"请先登录！\");";
		    echo 'parent.location.href = "contestlogin.php";';
		    echo "</script>";
		    exit;
     }
////////////////


?>
<div id="bt">
	<h2><center><?php echo gettitlename("1",$cid);?></center></h2>
</div>

<div>			
	<Script Language="JavaScript">
		ShowoPage("","","<div id=\"pagechange\">页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
	</Script>
</div>


<body>
<div id="table">
	<table>
      		<tr>
				<th class="menu"  width="5%" scope="col"><?php echo $MSG_RANK ;?></th>
				<th class="menu"  width="10%" scope="col"><?php echo $MSG_UsersID ;?></th>
				<th class="menu"  width="9%" scope="col"><?php echo $MSG_USERNAME ;?></th>
				<th class="menu"  width="20%" scope="col">学院</th>
				<th class="menu"  width="20%" scope="col">专业</th>
				<th class="menu"  width="8%" scope="col">年级</th>
				<th class="menu"  width="8%"  scope="col"><?php echo $MSG_SOVLED ;?></th>
				<th class="menu"  width="10%" scope="col"><?php echo $MSG_SUBMIT ;?></th>
				<th class="menu"  width="10%" scope="col"><?php echo $MSG_RATIO ;?></th>
		    </tr>
		<?php
		
		    
		    if(isset($_GET['Page'])){$page = $_GET['Page'];}
		    else{$page = 1;}
		    if($page)
		    {
			    $page_size = 50;//每页的信息行数
           	
			    $strSql = "select count(*) from ranklist;";//应用count 统计总的记录数
			    $total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
			    $page_count = ceil($total/$page_size);//计算页数
			    $offset=($page-1)*$page_size;
			    $rank = $offset+1;
			    if ($total < $page_size)
                {   $strSql   = "select * from ranklist;";}
                else
                {   $strSql   = "select * from ranklist limit $offset,$page_size;";}
			    $rsResult = $oDD->Query($strSql);
			    while($rsRanklist = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
			    {
				    echo '<tr><td>'.$rank.'</td>';
				    echo '<td><a href="userpage.php?userid='.$rsRanklist['uid'].'">'.$rsRanklist['user_name'].'</a></td>';
				    echo '<td>'.$rsRanklist['name'].'</td>';	
                    echo '<td>'.$rsRanklist['college'].'</td>';	
                    echo '<td>'.$rsRanklist['major'].'</td>';	
                    echo '<td>'.$rsRanklist['grade'].'</td>';				
				    echo '<td>'.$rsRanklist['ac'].'</td>';
				    echo '<td>'.$rsRanklist['submit'].'</td>';
				    $ratio = round($rsRanklist['ratio']*100 ,2);
				    echo '<td>'.$ratio.'%</td><tr>';
				    $rank = $rank + 1 ;
			    }
			    if($total == 0)
			    {
				    echo '<tr ><td colspan="6"><font color="red">无相关信息</font></td></tr>';
			    }
		    }
		?>
		<div>
		<Script Language="JavaScript">
			ShowoPage("","","<div id=\"pagechange\">页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
		</Script></div>
    </table>
</div>
<div>			
	<Script Language="JavaScript">
		ShowoPage("","","<div id=\"pagechange\">页次:<font color='red'>","</font>/","<font color='red'>","</font>页&nbsp;","&nbsp;每页最多<font color='red'>","</font>条&nbsp;","&nbsp;共<font color='red'>","</font>个记录&nbsp;&nbsp;","首页","上一页","下一页","尾页","&nbsp;&nbsp;跳转:","<font color='red'>","</font>","[<font color='red'>","</font>]","","","&nbsp;","&nbsp;",<?php echo $total;?>,<?php echo $page_size;?>,4)
	</Script>
</div>

<div style="clear: both;">&nbsp;</div>
</div>
<?php
	require_once 'template/footer.tpl';
?>
</body>