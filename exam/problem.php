<?php
	require_once 'template/header.tpl';
	require_once '../global.php';
	require_once("../functions.php");	

	
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
        $strSql = "select a.end_time from exam as a where a.eid = '".$eid."' and a.defunct = 'Y' ;";
		$rsResult = $oDD->Query($strSql);
		$rsExam = $oDD->FetchArray($rsResult, MYSQLI_ASSOC);
		$end_time = $rsExam['end_time'];
	}else{$eid="";}
	
	confirmuserlogin(2);
	
	if(isset($_GET['logicpid']))
	{
		$logicpid = $oDD->EscapeString($_GET['logicpid']);
		$_SESSION['logicpid'] = $logicpid;
	}
	if (!empty($logicpid))
	{
		$strSql = "SELECT b.logicpid as logicpid, a.pid,a.title as title ,a.description as description, a.time_limit as time_limit,  
		                  a.memory_limit as memory_limit,a.input as input,a.output as output,a.sample_input as sample_input,
						  a.sample_output as sample_output, a.source as source
               		FROM problem as a, exam_problem as b 
		           where a.pid = b.pid and b.eid = '".$eid."' and b.logicpid = '".$logicpid."';";
		$rsResult = $oDD->Query($strSql);
		$rsProblem = $oDD->FetchArray($rsResult, MYSQLI_ASSOC);
		$pid = $rsProblem['pid'];
		$_SESSION['pid'] = $pid;
	}
    if (!isset($_SESSION['logicpid']) && !isset($_SESSION['pid']) )
	{
		echo "<script language='javascript'>\n";
		echo "alert(\"Submit Error！\");";
		echo 'parent.location.href = "examlist.php";';
		echo "</script>";
		exit;
	}
	
	$in_date = strftime("%Y-%m-%d %H:%M:%S", time());
	
	if ( $end_time <= $in_date)
	{
		echo "<script language='javascript'>\n";
		echo "alert(\"考试时间已到！\");";
		echo 'parent.location.href = "../exit.php";';
		echo "</script>";
		exit;
	}
	
	if ($_SERVER['REQUEST_METHOD'] == "POST" )
	{
		if(isset($_POST['lang']) && isset($_POST['code']))
		{
			$lang = $oDD->EscapeString($_POST['lang']);
			$source = $oDD->EscapeString($_POST['code']);
			if ((!empty($_SESSION['power'])))
					$uid =  $_SESSION['uid'];
				else
					$uid =  $_SESSION['euid'];
			
			delaysub($uid);

			$logicpid = $_SESSION['logicpid'];
			$pid = $_SESSION['pid'];
			
			$dup_checking = duplicate_checking(2,$source,$pid,$eid,$uid);
			
			//$dup_checking =0;
			if ( !empty($source) )	
			{	if ($dup_checking >80)
				{
					header("Location: duplicate_checking.php?m_max=$dup_checking");
					exit;
				}
				else if( (!empty($uid) || !empty($_SESSION['power']) ) && !empty($eid) && !empty($pid) )
				{
					
					$in_date = strftime("%Y-%m-%d %H:%M:%S", time());
					$strSql = "insert solution(pid,logicpid,uid,language,in_date,eid) values('".$pid."','".$logicpid."','".$uid."','".$lang."','".$in_date."','".$eid."');";
					$rsResultsolution = $oDD->Query($strSql);
					$sid = $oDD->InsertId($strSql);
					$strSql = "insert source_code(sid,source) values('".$sid."','".$source."');";
					$rsResultsourcecode = $oDD->Query($strSql);
					
					echo "<script language='javascript'>\n";
					echo "location.replace(\"status.php\");\n";
					echo "</script>";
					exit;
				}
			}
		}
	}
?>
	<div id="bt"><h3><center>Problem Description</center></h3></div>

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
		</div>

	</section>
	<section class="page container">
		<div class="span15">
		<div class="box"> 
			<div class="box-header">
				<i class="icon-qrcode"></i><h5>Your Code</h5>
			</div>
			<form class="form-horizontal" action="problem.php" method="post">
				<div class="box-content">
					<label class="col-lg-2 control-label" for="lang">Select Language</label>
					<div class="col-lg-10">
						<select name="lang" class="selectize-select" style="width: 150px">
						<option value="1" selected="selected">GNU C</option>
						<option value="2" >GNU C++</option>
						<option value="3" >JAVA</option>
						</select>
					</div>
				</div>
				<fieldset>
					<div class="form-group">
						<div class="col-lg-10">
							<textarea name="code" class="form-control textarea-wysihtml5" placeholder="Enter or Paste Source Code Here..." style="width:98.5%; height: 300px"></textarea>
						</div>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="reset" class="btn btn-default">Cancel</button>
				</fieldset>
			</form>
		</div>
		</div>
	</section>
<?php	
	require_once 'template/footer.tpl';
?>