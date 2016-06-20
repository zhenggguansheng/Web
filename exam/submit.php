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
	}else{$eid="";}
	
	confirmuserlogin(2);
	
	if(isset($_GET['logicpid']))
	{
		$logicpid = $oDD->EscapeString($_GET['logicpid']);
		$_SESSION['logicpid'] = $logicpid;
		if(!isset($_SESSION['logicpid']))
		{
			$_SESSION['logicpid'] = $logicpid;
		}
	}else{$logicpid = "";}

//	echo $logicpid . ' <br /> '. $logicpid;

	if ($_SERVER['REQUEST_METHOD'] == "POST" )
	{
		if(isset($_POST['lang']) && isset($_POST['code']) && !empty($_SESSION['logicpid']))
		{
			$logicpid = $_SESSION['logicpid'];
			$lang = $oDD->EscapeString($_POST['lang']);

			$source = $oDD->EscapeString($_POST['code']);
			if ((!empty($_SESSION['power'])))
					$uid =  $_SESSION['uid'];
				else
					$uid =  $_SESSION['euid'];
			delaysub($uid);
			
			$strSql = "SELECT pid from exam_problem where eid = '".$eid."' and logicpid = '".$logicpid."';";
			$rsResult = $oDD->Query($strSql);
			$rsPid = $oDD->FetchArray($rsResult, MYSQLI_ASSOC);
			$pid = $rsPid['pid'];
			
			//echo $logicpid . ' <br /> '. $pid . ' <br /> '. $source;
			//exit;
			
			
			$dup_checking = duplicate_checking(2,$source,$pid,$eid,$uid);
			if ( !empty($source) )	
			{	if ($dup_checking >85)
				{
					header("Location: duplicate_checking.php?m_max=$dup_checking");
					exit;
				}
				if( (!empty($uid) || !empty($_SESSION['power']) ) && !empty($eid) && !empty($pid) )
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

<section class="page container">
	<div id="bt"><h4><center><?php echo  $MSG_Problem_ID . ':  ' . $logicpid . ' ';?></center></h4></div>
	<div class="span15">
	<div class="box"> 
		<div class="box-header">
			<i class="icon-qrcode"></i><h5>Your Code</h5>
		</div>
		<form class="form-horizontal" action="submit.php" method="post">
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