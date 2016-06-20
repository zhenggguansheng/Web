<?php
	require_once 'template/header.tpl';
	
	if(isset($_GET['m_max']))
	{
		$max = (float)$oDD->EscapeString($_GET['m_max'])*0.9;
	}
	else
	{
		echo "<script language='javascript'>\n";
		echo "location.replace(\"problemlist.php\");\n";
		echo "</script>";
	}
?>
<link href="../include/css/min.css" rel="stylesheet">

<section class="page container">
	<div class="row">
		<div class="span2"></div>
	<div class="span12">
	<div class="box pattern pattern-sandstone">
	<div class="box-content box-table">
		<div class="col-lg-10">			
			<div class="col-lg-12">
				<div class="centering text-center">
					<div class="text-center">
						<h3><small>提交的代码重复率:</small></h3>
					</div>
					<div class="progress progress-with-value">
						<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow=<?php echo $max;?> aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $max;?>%;"></div>
						<span class="value-container">
							<span class="value"><?php echo $max;?>%</span>
						</span>
					</div>
					<div>
						<span class="value-container">
							<span class="value">重复率过高，请重新编写代码！！</span>
						</span>
					</div>
				</div>
				<hr>
				<ul class="pager">
					<li><a href="javascript:history.go(-1)">&larr; 返回</a></li>
					<li><a href="problemlist.php">题目列表</a></li>
					<li><a href="../index.php">主页 &rarr;</a></li>
				</ul>
			</div>
		</div>
	</div>
	</div>
	</div>
	</div>
</section>

<?php
	require_once 'template/footer.tpl';
?>
	
	
