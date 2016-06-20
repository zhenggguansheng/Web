<?php
	require_once 'global.php';
    require_once 'template/header.tpl';
	require_once("../functions.php");	
	
	if(isset($_SESSION['ccid']))
	{
		$cid = $oDD->EscapeString($_SESSION['ccid']);
		$cidSQL = " solution.cid = '".$cid."' ";
	}
	else
	{
		$cid="";
		echo "<script language='javascript'>\n";
		echo "alert(\"请先登录！\");";
		echo 'parent.location.href = "contestlogin.php";';
		echo "</script>";
		exit;
	
	}
	
	confirmuserlogin(1);

    if(isset($_GET['logicpid']))
	{
		$_SESSION['logicpid'] = $oDD->EscapeString($_GET['logicpid']);
		$logicpid = $_SESSION['logicpid'];
	}
	else if(isset($_SESSION['logicpid']))
	{
		$logicpid = $_SESSION['logicpid'];
	}

	if($logicpid!="")
	{
		$strSql = "select b.*,a.logicpid from contest_problem as a,problem as b where a.pid = b.pid and a.logicpid = '".$logicpid."';";
		$rsResult = $oDD->Query($strSql);
		$rsProblem = $oDD->FetchArray($rsResult, MYSQLI_ASSOC);
	}

?>
	<div id="bt">
	<h2><center><?php echo $MSG_Problem .' : ' . $rsProblem['title'].' ( ' . $rsProblem['logicpid'].' ) '; ?></center></h2>
      <h3><center>
        <?php  
			   echo $MSG_Number.' : '.$rsProblem['accepted'].'&nbsp;&nbsp;&nbsp;&nbsp;'.$MSG_Submit.' : '.$rsProblem['submit'].'<br />';
		       echo $MSG_Time_Limit.' : '.$rsProblem['time_limit'].'&nbsp; msec &nbsp&nbsp&nbsp&nbsp '.$MSG_Memory_Limit.' : '.$rsProblem['memory_limit'].'&nbsp;KB ';
	    ?>
        </center></h3>
      </div>
	<div id="problem-content">
		<ul>
			<li>
				<h2><image src="../images/li.gif" /><?php echo $MSG_ProblemDescription ; ?></h2>
				<p><?php echo $rsProblem['description']?></p>
			</li>
			<li >
				<h2><image src="../images/li.gif" /><?php echo $MSG_Input ; ?></h2>
				<p><?php echo $rsProblem['input']?>
				</p>				
			</li>
			<li>
			    <h2><image src="../images/li.gif" /><?php echo $MSG_Output ; ?></h2>
				<p><?php echo $rsProblem['output']?></p>
            </li>
			<li>
			    <h2><image src="../images/li.gif" /><?php echo $MSG_Sample_Input ; ?></h2>
				<div class="data"><?php echo $rsProblem['sample_input']?>
                </div>
            </li>
			<li>
			    <h2><image src="../images/li.gif" /><?php echo $MSG_Sample_Output ; ?></h2>
				<div class="data"><?php echo $rsProblem['sample_output']?>
		    </li>
			<li>
			   <h2><image src="../images/li.gif" /><?php echo $MSG_Source ;?></h2>
			   <p><?php echo $rsProblem['source']?></p>
			 </li>
		</ul>
	</div>
	<div style="text-align:center;"><b>
		<a href="submit.php"><?php echo $MSG_Submit;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="contest.php"><?php echo $MSG_Back;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="status.php"><?php echo $MSG_Status;?></a></b>
	</div>

<div style="clear: both;">&nbsp;</div>
</div>
<?php	
	require_once 'template/footer.tpl';
?>
