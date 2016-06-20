<?php
	require_once 'template/header.tpl';
	require_once '../global.php';
	require_once '../functions.php';

	if(isset($_SESSION['eeid']))
	{
		$eid = $oDD->EscapeString($_SESSION['eeid']);
	}else
	{
		$eid="";
		echo "<script language='javascript'>\n";
		echo "alert(\"请先登录！\");";
		echo 'parent.location.href = "login.php";';
		echo "</script>";
		exit;
	}
	
	confirmuserlogin(2);
		
///////////////////////		
    $strSql = "select end_time from exam where eid = '".$eid."';";
	$rsEndTime = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
	$EndTime = strtotime($rsEndTime);//比赛结束时间
	$EndBefore = $EndTime - 3600;//比赛前60分钟
	$Now = time();//当前时间
	if(($Now>$EndBefore) && ($Now<$EndTime) && !isset($_SESSION['power']))
	{
		echo "<script language='javascript'>\n";
		echo 'alert("此时间您没有权限查看排名！");';
		echo 'parent.location.href = "contest.php";';
		echo "</script>";
		exit;
	}
///////////////////////

	if(isset($_SESSION['eeid']) && isset($_SESSION['euid'])||isset($_SESSION['power']))
	{
        $strSql = "call proranklist(2,$eid)";
 	    $rsResult = $oDD->Query($strSql);
	}
	else
	{
		echo "<script language='javascript'>\n";
		echo 'parent.location.href = "../index.php";';
		echo "</script>";
	}
?>


	<div id="bt"><h2><center><?php echo gettitlename("2",$eid) . ' Rank List ' ;?></center></h2></div>
	<section class="page container">
		<div class="row">
			<div class="span2"></div>
		<div class="span12">
		<div class="box pattern pattern-sandstone">
		<div class="box-content box-table">
			<table id="sample-table" class="table table-hover table-bordered">						
				<thead>
					<tr>
						<th class="list_desc" width="20%" scope="col"><?php echo $MSG_RANK ;?></th>
						<th class="list_desc" width="25%" scope="col"><?php echo $MSG_UsersID ;?></th>
						<th class="list_desc" width="16%" scope="col"><?php echo $MSG_USERNAME ;?></th>
						<th class="list_desc" width="12%" scope="col"><?php echo $MSG_SOVLED ;?></th>
						<th class="list_desc" width="12%" scope="col"><?php echo $MSG_SUBMIT ;?></th>
						<th class="list_desc" width="27%" scope="col"><?php echo $MSG_RATIO ;?></th>
					</tr>
				</thead>
				<tbody>
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
                                if(isset($_SESSION['power']) && ($_SESSION['power'] == "admin") )
							        echo '<td><a href="userpage.php?userid='.$rsRanklist['uid'].'">'.$rsRanklist['user_name'].'</a></td>';
                                else
                                    echo '<td>'.$rsRanklist['user_name'].'</td>';
								echo '<td>'.$rsRanklist['name'].'</td>';	
								/*echo '<td>'.$rsRanklist['college'].'</td>';	
								echo '<td>'.$rsRanklist['major'].'</td>';	
								echo '<td>'.$rsRanklist['grade'].'</td>';*/				
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
	</section>

<?php
	require_once 'template/footer.tpl';
?>