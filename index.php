<?php
	require_once 'template/header.tpl';
	require_once 'functions.php';
?>

		<section class="page container">
					<div class="row">
						<div class="span5">
							<div class="box">
								<div class="box-header">
										<h4>Last News</h4>
								</div>
								<div>
									<ul>
										 <?php
											  $strSQL = "select * from news order by nid desc limit 0,3";
											  $rsResult = $oDD->Query($strSQL);
											  while($news = $oDD->FetchArray($rsResult,MYSQLI_ASSOC)){
												  echo '<h4><li><img src="images/star.png">&nbsp;&nbsp;'.$news['in_date'].'&nbsp;&nbsp;</h4>';
												  echo '<h5><font style="font-size:12px; color:#00F">'.$news['data'].'</font></h5></li>';
											  }
										 ?>
									 </ul>
								</div>
								<div class="box-content box-list collapse in">
									<div class="box-collapse">
										<button class="btn btn-box" data-toggle="collapse" data-target=".more-list">
											Show More
										</button>
									</div>
									
									<ul class="more-list collapse out">
										<?php
											  $strSQL = "select * from news order by nid desc limit 3,9999999";
											  $rsResult = $oDD->Query($strSQL);
											  while($news = $oDD->FetchArray($rsResult,MYSQLI_ASSOC)){
												  echo '<li><div><img src="images/star.png">&nbsp;&nbsp;'.$news['in_date'].'&nbsp;&nbsp;</h4>';
												  echo '<font style="font-size:12px; color:#00F">'.$news['data'].'</font></div></li>';
											  }
										 ?>
									</ul>
								</div>
								<div>
									 <ul>
											<li>
												<h4><?php echo $MSG_Introduction;?></h4>
												<?php
													echo '<img src="images/star.png">';
													echo '<h5><font style="font-size:18px; color:#F00">'.$Introduction.'</font></h5>';
												?>				
											</li>		
											<!---
											<li>
												<h5>Your IP Address：
												<?php
													//$mac = new GetMacAddr('windows'); 
													//echo $mac->mac_addr;
													//$ipaddr = get_real_ip();
													//echo $ipaddr;
												?></h5>				
											</li> 		
											--->
										</ul>
								</div>
							</div>
						</div>
						<div class="span10">
								<div class="box pattern pattern-sandstone">
									<div class="box-header">
										<h4>Problems</h4>
									</div>
									<div class="box-content box-table">
										<table id="sample-table" class="table table-hover table-bordered tablesorter">						
											<thead>
											   <tr>
												 <th class="list_desc" width="20%" scope="col"><?php echo $MSG_Problem_ID;?></th>
												 <th class="list_desc" width="32%" scope="col"><?php echo $MSG_Problem;?></th>
												 <th class="list_desc" width="16%" scope="col"><?php echo $MSG_Ratio;?></th>
												 <th class="list_desc" width="16%" scope="col"><?php echo $MSG_Number;?></th>
												 <th class="list_desc" width="16%" scope="col"><?php echo $MSG_Submit;?></th>
												</tr>
											</thead>
											<tbody>
													<?php
													
													$strSql = "select * from problem where defunct = 'Y' order by pid DESC limit 0,12;";
													$rsResult = $oDD->Query($strSql);
													while($rsProblem = $oDD->FetchArray($rsResult, MYSQLI_ASSOC))
													{
														$ratio = round($rsProblem['ratio']*100 ,2);
														echo '<tr><td>'.$rsProblem['pid'].'</td>';
														echo '<td><a href="exercise/problem.php?pid='.$rsProblem['pid'].'">'.$rsProblem['title'].'</a></td>';
														echo '<td>'.$ratio.' %</td>';
														echo '<td>'.$rsProblem['accepted'].'</td>';
														echo '<td>'.$rsProblem['submit'].'</td> </tr>';
													}
												?>		
											 </tbody>
										</table>
									</div>
								</div>
						</div>
					</div>
			</section>

<?php	require_once 'template/footer.tpl';
?>