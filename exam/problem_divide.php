<?php
	require_once 'template/header.tpl';
	require_once '../global.php';
	require_once("../functions.php");	

	confirmuserlogin(2);
	if(!isset($_SESSION['eeid']) && !isset($_SESSION['euid'])&&isset($_SESSION['power']))
	{
			echo "<script language='javascript'>\n";
			echo 'parent.location.href = "examlist.php";';
			echo "</script>";
			exit;
	}
	
	if(isset($_SESSION['eeid']))
	{
		$eid = $oDD->EscapeString($_SESSION['eeid']);;
	}else{$eid="";}
	
	
	if(isset($_GET['logicpid']))
	{
		$logicpid = $oDD->EscapeString($_GET['logicpid']);
	}else{$logicpid = "";}
	
	if (!empty($logicpid))
	{
		$strSql = "SELECT b.logicpid as logicpid, a.pid,a.title as title ,a.description as description, a.time_limit as time_limit,  
		                  a.memory_limit as memory_limit,a.input as input,a.output as output,a.sample_input as sample_input,
						  a.sample_output as sample_output, a.source as source
               		FROM problem as a, exam_problem as b 
		           where a.pid = b.pid and b.eid = '".$eid."' and b.logicpid = '".$logicpid."';";
		$rsResult = $oDD->Query($strSql);
		$rsProblem = $oDD->FetchArray($rsResult, MYSQLI_ASSOC);
	}
?>
	<div id="bt"><h3><center>Problem Discribtion</center></h3></div>

	<section class="page container">
	<div class="span15">
		<div class="box pattern pattern-sandstone">
			<div class="box-header">
				<i class="icon-list"></i>
				<h5><center><?php echo $rsProblem['title'].' ( ' . $rsProblem['logicpid'].' ) '; ?></center></h5>
				<button class="btn btn-box-right" data-toggle="collapse" data-target=".box-list">
					<i class="icon-reorder"></i>
				</button>
			</div>
			<div class="box-content box-list collapse in">
			<h5 style="color:#0000FF"><center>  
					<?php  
							$value = ceil($rsProblem['memory_limit']/1024);
							echo $MSG_Time_Limit.' : '.$rsProblem['time_limit'].'&nbsp; MS &nbsp&nbsp&nbsp&nbsp '.$MSG_Memory_Limit.' : '.$value.'&nbsp;KB ';
					?>
				</center>
			</h5>			</div>
		</div>
		<div class="box"> 
			<div class="box-header">
				<i class="icon-file"></i><h5><?php echo $MSG_ProblemDescription ; ?></h5>
			</div>
			<div class="box-content"> 
				<p><?php echo $rsProblem['description']?></p>
			</div>
		</div>
		<div class="box"> 
			<div class="box-header">
				<i class="icon-file"></i><h5><?php echo $MSG_Input ; ?></h5>
			</div>
			<div class="box-content"> 
				<p><?php echo $rsProblem['input'];?></p>
			</div>
		</div>
		<div class="box"> 
			<div class="box-header">
				<i class="icon-file"></i><h5><?php echo $MSG_Output ; ?></h5>
			</div>
			<div class="box-content"> 
				<p><?php echo $rsProblem['output'];?></p>
			</div>			
		</div> 
		<div class="box"> 
			<div class="box-header">
				<i class="icon-file"></i><h5><?php echo $MSG_Sample_Input ; ?></h5>
			</div>
			<div class="box-content"> 
				<p><?php echo $rsProblem['sample_input'];?></p>
			</div>			
		</div> 		
		<div class="box"> 
			<div class="box-header">
				<i class="icon-file"></i><h5><?php echo $MSG_Sample_Output ; ?></h5>
			</div>
			<div class="box-content" > 
				<p><?php echo $rsProblem['sample_output'];?></p>
			</div>			
		</div> 
		<div class="box"> 
			<div class="box-header">
				<i class="icon-file"></i><h5><?php echo $MSG_Source ; ?></h5>
			</div>
			<div class="box-content"> 
				<p><?php echo $rsProblem['source'];?></p>
			</div>			
		</div> 
		
		<div style="text-align:center;"><b>
			<a href="submit.php?logicpid=<?php echo $rsProblem['logicpid'];?>"><?php echo $MSG_Submit;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="course.php"><?php echo $MSG_Back;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="status.php"><?php echo $MSG_Status;?></a></b>
		</div>

	</div>
</section>

<?php	
	require_once 'template/footer.tpl';
?>