<?php
	require_once 'template/header.tpl';
	require_once '../global.php';
	require_once '../functions.php';
	if(isset($_GET['id']))
	{
		$id = $oDD->EscapeString($_GET['id']);
	}
?>

	<section class="page container">
		<div class="row">
			<div class="span2"></div>
		<div class="span12">
		<div class="box pattern pattern-sandstone">
		<div class="box-content box-table">
			<table id="sample-table" class="table table-hover table-bordered">						
				<thead>
					<tr>
						<th class="list_desc" width="16%" scope="col"><?php echo $MSG_UsersID ;?></th>
						<th class="list_desc" width="10%" scope="col"><?php echo $MSG_USERNAME ;?></th>
						<th class="list_desc" width="20%" scope="col"><?php echo $MSG_COLLEGE ;?></th>
						<th class="list_desc" width="18%" scope="col"><?php echo $MSG_MAJOR ;?></th>
						<th class="list_desc" width="8%" scope="col"><?php echo $MSG_GRADE ;?></th>
						<th class="list_desc" width="6%" scope="col"><?php echo $MSG_SOVLED ;?></th>
						<th class="list_desc" width="6%" scope="col"><?php echo $MSG_SUBMIT ;?></th>
						<th class="list_desc" width="10%" scope="col"><?php echo $MSG_RATIO ;?></th>
					</tr>
				</thead>
				<tbody>
					<?php
						if($id == 2)
							$strSql   = "select * from ranklistforexam ORDER BY user_name;";
						else if($id == 1)
							$strSql   = "select * from ranklistforexam2 ORDER BY user_name;";
						$rsResult = $oDD->Query($strSql);
						$rank = 1 ;
						while($rsRanklist = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
						{
							echo '<td>'.$rsRanklist['user_name'].'</td>';
							echo '<td>'.$rsRanklist['name'].'</td>';	
							echo '<td>'.$rsRanklist['college'].'</td>';	
							echo '<td>'.$rsRanklist['major'].'</td>';	
							echo '<td>'.$rsRanklist['grade'].'</td>';				
							echo '<td>'.$rsRanklist['ac'].'</td>';
							echo '<td>'.$rsRanklist['submit'].'</td>';
							$ratio = round($rsRanklist['ratio']*100 ,2);
							echo '<td>'.$ratio.'%</td><tr>';
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