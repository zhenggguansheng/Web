<?php
	require_once 'template/header.tpl';
    require_once '../global.php';
	require_once("../functions.php");	
	
	confirmuserlogin(2);

	if(!isset($_SESSION['eeid']) && !isset($_SESSION['euid']))
	{
			echo "<script language='javascript'>\n";
			echo 'parent.location.href = "examlist.php";';
			echo "</script>";
	}
	
	if(isset($_GET['sid']))
	{
		$sid = $oDD->EscapeString($_GET['sid']);
	}
	else{$sid = "";}
	if(isset($_SESSION['user_name']))
	{
		$user = $oDD->EscapeString($_SESSION['user_name']);
	}else{	$user = "";	}
	if(isset($_SESSION['euid']))
	{
		$uid = $oDD->EscapeString($_SESSION['euid']);
	}else{	$uid = "";	}
	if(isset($_SESSION['eeid']))
	{
		$eid = $oDD->EscapeString($_SESSION['eeid']);
	}else{	$eid = "";	}

	if(!empty($sid))
	{
		$strSql = "select result from solution where sid = '".$sid."';";
		$rsResult = $oDD->Query($strSql);
		$rsSolution = $oDD->FetchArray($rsResult, MYSQLI_ASSOC);
		switch($rsSolution['result'])
		{
	            case 0:$result = "Submitted";break;
				case 1:$result = "Accepted";break;
	            case 2:$result = "Presentation Error";break;
				case 3:$result = "Wrong Answer";break;
	            case 4:$result = "Runtime Error";break;
				case 5:$result = "Time Limit Exceed";break;
	            case 6:$result = "Memory Limit Exceed";break;
	            case 7:$result = "Compile Error";break;
	            case 8:$result = "System Error";break;
	            case 9:$result = "Waiting";break;
		}
	}
?>
	<div id="bt"><h2><center>Submit Summary</center></h2></div> 
	<section class="page container">
        <div class="row">
            <div class="span15">
			<div class="box">
				<div class="box-header">
					<i class="icon-sign-blank"></i>
					<h5>评测状态: <?php echo $result; ?></h5>
				 </div>
				 <div class="box-content">
					<legend class="lead">
						错误信息
					</legend>
					<code>
						<?php
							$strSql = "select error from compileinfo where sid = '".$sid."';";
							$rsResult = $oDD->Query($strSql);
							$rsInfo = $oDD->FetchArray($rsResult, MYSQLI_ASSOC);
							if ( !empty($rsInfo['error']) )
								echo '<li><span style="font-size:16px" > '.$rsInfo['error'].'</span></li>';
							else
								echo '<li><span style="font-size:16px" >No errors</span></li>';
						?>
					
					</code>
				</div>
            </div>
			</div>
		</div>

        <div class="row">
            <div class="span15">
			<div class="box">
				<div class="box-header">
					<i class="icon-sign-blank"></i>
					<h5>源代码:Source Code</h5>
				 </div>
				 <div class="box-content">
					<legend class="lead">
						Source Code
					</legend>
						<?php
							if ( isset($_SESSION['power']) && ($_SESSION['power']=="admin")  )
							{
								$strSql = "select source from source_code where sid = '".$sid."';";
								
							}
							else if ( !empty($user) && $rsSolution['result'] > 0 )  //$rsSolution['result'] != 1 
							{
								$strSql = "SELECT a.source as source FROM source_code AS a, solution AS b where a.sid = b.sid 
												AND b.sid = '".$sid."' and b.uid = (SELECT uid FROM commonuser WHERE student_num = '".$user."');";
							}
							else
							{
								echo "<script language='javascript'>\n";
								echo 'parent.location.href = "status.php";';
								echo "</script>";
							}
							$rsResult = $oDD->Query($strSql);
							$rsSource = $oDD->FetchArray($rsResult, MYSQLI_ASSOC);
						?>
						<pre><code class="html"><?php echo htmlspecialchars($rsSource['source']); ?></code></pre>
				</div>
				<div class="box-footer">
					<h5><a href="status.php"><?php echo $MSG_Back;?></a></h5>
				</div>
            </div>
			</div>
		</div>
	</section>	
<?php
	require_once 'template/footer.tpl';
?>