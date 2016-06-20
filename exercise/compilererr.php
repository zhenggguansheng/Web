<?php
 	require_once 'template/header.tpl';
    require_once '../global.php';
	require_once("../functions.php");	
	
	confirmuserlogin(0);

	if(!isset($_SESSION['uid']))
	{
			echo "<script language='javascript'>\n";
			echo 'parent.location.href = "login.php";';
			echo "</script>";
	}
	
	if(isset($_GET['sid']))
	{
		$sid = $oDD->EscapeString($_GET['sid']);
	}
	else
	{
		echo "<script language='javascript'>\n";
		echo 'parent.location.href = "status.php";';
		echo "</script>";
	}


?>
	<section class="page container">
        <div class="row">
            <div class="span15">
			<div class="box">
				<div class="box-header">
					<i class="icon-sign-blank"></i>
					<h5>评测状态:Compile Error</h5>
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
							$errstr = $rsInfo['error'];
							$replace = "<br/>";
							$newstr = str_replace("\n",$replace,$errstr);
							echo '<li><span style="font-size:16px" > '.$newstr.'</span></li>';
						?>
					
					</code>
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