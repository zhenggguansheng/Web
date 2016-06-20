<?php
	require_once 'template/header.tpl';
	require_once("../global.php");
	require_once("../functions.php");	
	error_reporting(E_ALL & ~E_NOTICE);
	confirmuserlogin(0);
	
	if(isset($_GET['pid']))
	{
		$_SESSION['pid'] = $oDD->EscapeString($_GET['pid']);
		$pid = $_SESSION['pid'];
	}
	if ( !empty($pid) )
	{
		$strSql = "select a.pid,a.title as title ,a.description as description,a.accepted as accepted,
		                  a.submit as submit, a.time_limit as time_limit,a.memory_limit as memory_limit,a.input as input,
						  a.output as output,a.sample_input as sample_input,a.sample_output as sample_output, a.source as source
					 from problem  as a
					 where a.defunct = 'Y' and pid = '".$pid."';";
		$rsResult = $oDD->Query($strSql);
		$rsProblem = $oDD->FetchArray($rsResult, MYSQLI_ASSOC);
		if (empty($rsProblem))
		{
			header("Location: problemlist.php");
			exit;
		}
		else		
		{
			if ( $rsProblem['submit'] == 0 )
				$ratio = 0;
			else
				$ratio =  round($rsProblem['accepted']/$rsProblem['submit']*100 ,0);
		}
	}
	else
	{
		echo "<script language='javascript'>\n";
		echo "题目读取有误，请稍后重试！;\n";
		echo "</script>";
	}
	if (empty($pid))
	{
		echo "<script language='javascript'>\n";
		echo "题目读取有误，请稍后重试！;\n";
		echo "</script>";

	}

	if ($_SERVER['REQUEST_METHOD'] == "POST" )
	{
		if(isset($_POST['lang']) && isset($_POST['code']))
		{
			$lang = $oDD->EscapeString($_POST['lang']);
			$source = $oDD->EscapeString($_POST['code']);
			if(isset($_SESSION['uid']))
			{
				$uid =  $_SESSION['uid'];
				$pid = $_SESSION['pid'];
				delaysub($uid);
	/* 
				$strSql = "select user_name from commonuser where uid = '".$uid."';";
				$user_name = $oDD->GetValue($strSql, MYSQLI_NUM, 0);
			
				if((!empty($uid) || !empty($_SESSION['power']) ) && !empty($pid) && !empty($source))
				{
					$in_date = strftime("%Y-%m-%d %H:%M:%S", time());
					$strSql = "insert solution(pid,uid,language,in_date) values('".$pid."','".$uid."','".$lang."','".$in_date."');";
					$rsResultsolution = $oDD->Query($strSql);
					$sid = $oDD->InsertId($strSql);
					$strSql = "insert source_code values('".$sid."','".$source."');";
					$rsResultsourcecode = $oDD->Query($strSql);
					
					echo "<script language='javascript'>\n";
					echo "location.replace(\"status.php\");\n";
					echo "</script>";
				}
	*/
				$dup_checking = 0;
				if ( !empty($source) ) 
				{
					$dup_checking = duplicate_checking(0,$source,$pid,0,$uid);
					if ($dup_checking >83)
					{
						header("Location: duplicate_checking.php?m_max=$dup_checking");
						exit;
					}
					else if((!empty($uid) || !empty($_SESSION['power']) ) && !empty($pid) )
					{
						
						$in_date = strftime("%Y-%m-%d %H:%M:%S", time());
						$strSql = "insert solution(pid,uid,language,in_date) values('".$pid."','".$uid."','".$lang."','".$in_date."');";
						$rsResultsolution = $oDD->Query($strSql);
						$sid = $oDD->InsertId($strSql);
						$strSql = "insert source_code (sid,source) values('".$sid."','".$source."');";
						$rsResultsourcecode = $oDD->Query($strSql);

						echo "<script language='javascript'>\n";
						echo "location.replace(\"status.php\");\n";
						echo "</script>";
						exit;
					}
				}	
			}
		}
	}

?>
	<div id="bt"><h3><center>Problem Description</center></h3></div>

	<section class="page container">
	<div class="span12">
		<div class="box pattern pattern-sandstone">
			<div class="box-header">
				<i class="icon-list"></i>
				<h5><center><?php echo $rsProblem['title'].' ( ' . $rsProblem['pid'].' ) '; ?></center></h5>
				<button class="btn btn-box-right" data-toggle="collapse" data-target=".box-list">
					<i class="icon-reorder"></i>
				</button>
			</div>
			<div class="box-content box-list collapse in">
				<h5><center>  
					<?php  echo $MSG_Number.' : '.$rsProblem['accepted'].'&nbsp;&nbsp;&nbsp;&nbsp;'.$MSG_Submit.' : '.$rsProblem['submit'].'<br />';
						   $value = round(($rsProblem['memory_limit']+1)/1024,0);
						   echo $MSG_Time_Limit.' : '.$rsProblem['time_limit'].'&nbsp; MS &nbsp&nbsp&nbsp&nbsp '.$MSG_Memory_Limit.' : '.$value.'&nbsp;KB ';
					?>
				</center></h5>
			</div>
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
		<div class="span12">
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