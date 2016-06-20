<?php
	require_once 'template/header.tpl';
	require_once("../global.php");	

	
	if(isset($_GET['bh']))
	{
		$bh = $oDD->EscapeString($_GET['bh']);
	}
	else{$bh = "";}
	
	$postfix = "1";
	
	if(isset($_GET['select']))
	{
		switch($_GET['select'])
		{
			case 0 :$select = "title like '%".$bh."%' ";break;
			case 1 :$select = "  pid = '".$bh."' ";break;
			default:$select = "";break;
		}
	}
	if(!empty($bh) && !empty($select))
		$postfix = $select;
	else
		$postfix = "1";


?>
<div id="bt">
	<h2><center><?php echo $MSG_List;?></center></h2>
</div>
<section class="page container">
	<div class="row">
		<div class="span2"></div>
	<div class="span12">
	<div class="box pattern pattern-sandstone">
	<div class="box-content box-table">
		<table>
			<th colspan="4">
			<form action="problemlist.php" type="get">
			<select name="select">
			    <option value="0" selected="selected"><?php echo $MSG_Problem;?></option>
				<option value="1"><?php echo $MSG_Problem_ID;?></option>
			</select>			
			<input type="text" id="bh" name="bh" value="<?php echo $bh?>" />			
			<input type="submit" id="search-submit" value="<?php echo $MSG_Search;?>" /> 
			</form>
			</th>
		</table>
		<table id="sample-table" class="table table-hover table-bordered">						
			<thead>
			   <tr>
				 <th class="list_desc" width="20%" scope="col"><?php echo $MSG_Problem_ID; ?></th>
				 <th class="list_desc" width="32%" scope="col"><?php echo $MSG_Problem; ?></th>
				 <th class="list_desc" width="16%" scope="col"><?php echo $MSG_Ratio ; ?></th>
				 <th class="list_desc" width="16%" scope="col"><?php echo $MSG_Number ; ?></th>
				 <th class="list_desc" width="16%" scope="col"><?php echo $MSG_Submit ; ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
					if(isset($_GET['Page'])){$page = $_GET['Page'];}
					else{$page = 1;}
					if($page)
					{
						if(isset($_SESSION['uid']))
						{
							$uid = $_SESSION['uid'];
						}
						else
						{
							$uid = "";
						}
						$page_size = 50;//每页的信息行数
						$strSql = "select count(*) as total from problem where defunct='Y' and ".$postfix.";";//应用count 统计总的记录数
						$total = $oDD->GetValue($strSql, MYSQLI_NUM, 0); //总记录数的值
						$page_count = ceil($total/$page_size);//计算页数
						$offset=($page-1)*$page_size;
						
						$strSql   = "select * from problem  where defunct='Y' and ".$postfix." order by pid  limit $offset,$page_size;";
						$rsResult = $oDD->Query($strSql);
						while($rsProblem = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
						{
							/* $flag = "";
							if($uid != "")
							{
								$strSql   = "select result from solution where uid = '".$uid."' and pid = '".$rsProblem['pid']."';";
								$rsResult_r = $oDD->Query($strSql);
								while($rsRes= $oDD->FetchArray($rsResult_r, MYSQLI_ASSOC))
								{
									if($rsRes['result'] == 1)
									{
										$flag = "(ac)";
										break;
									}
								}
							} */
							$ratio = round($rsProblem['ratio']*100 ,2);
							echo '<tr><td>'.$rsProblem['pid'].'</td>';
							echo '<td><a href="problem.php?pid='.$rsProblem['pid'].'">'.$rsProblem['title'].'</a></td>';
							echo '<td>'.$ratio.' %</td>';
							echo '<td>'.$rsProblem['accepted'].'</td>';
							echo '<td>'.$rsProblem['submit'].'</td><tr>';
						}
						if($total == 0)
						{
							echo '<tr><td colspan="5"><font color="red">未搜索到相关信息</font></td></tr>';
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