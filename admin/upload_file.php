<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	
	if(isset($_SESSION['pid']))
	{
	 $pid = $oDD->EscapeString($_SESSION['pid']);
	}
	else {$pid = "";}
	
?>
<section class="container">
    <div class="row">
		<div class="span3">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><p><a href="problem.php?pid=<?php echo $pid;?>">题目信息</a></p></li>
					<li><p><a href="editprobleminfo.php">编辑题目</a></p></li>
					<li><p><a href="file.php">上传测试数据</a></p></li>
				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>文件上传 </h5>
				</div>	
				<form action="upload_file.php" method="post" enctype="multipart/form-data">
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<tbody>
							<?php 

								if ($_FILES["file"]["error"] > 0)
								{
									echo '<tr><td>Error:</td>';
									echo '<td>'.$_FILES["file"]["error"].'</td>';
									echo '<td></td></tr>';
								}
								else
								{
									$fileName = $_FILES["file"]["name"];
									
									$filePath = $filePath . $pid;

									if (!is_dir($filePath))
									{
										$except = array('\\', '/', ':', '*', '?', '"', '<', '>', '|'); 
										str_replace($except, '', $filePath); 
										mkdir($filePath);
										move_uploaded_file($_FILES["file"]["tmp_name"],"$filePath/$fileName");
										echo '<th>Stored in:'.$filePath.'/'.$_FILES["file"]["name"].'</th>';
										//echo '</th>';
									}
									else
									{
										move_uploaded_file($_FILES["file"]["tmp_name"],"$filePath/$fileName");
										echo '<th width="100%">Stored in:'.$filePath.'/'.$_FILES["file"]["name"].'</th>';
										//echo '<tr><td>Stored in:'.$filePath.'/'.$_FILES["file"]["name"].'</td>';
										//echo '<td></td></tr>';
									}
									
									echo '<tr><td width="10%">Upload:</td>';
									echo '<td width="90%">'. $_FILES["file"]["name"].'</td></tr>';
									
									echo '<tr><td width="10%">Type:</td>';
									echo '<td width="90%">'. $_FILES["file"]["type"].'</td></tr>';
									
									echo '<tr><td width="10%">Size:</td>';
									echo '<td width="90%">'. $_FILES["file"]["size"] / 1024 .'Kb</td></tr>';
									
									echo '<tr><td width="10%">Temp file:</td>';
									echo '<td width="90%">'.$_FILES["file"]["tmp_name"].'</td></tr>';
									
								}
							?>
						</tbody>
					</table>
				</div>
								</form>
				<div class="box-footer">
					<button class="btn btn-primary"  type="buttom" onClick="location.href='file.php'">继续上传</button>
					<button class="btn btn-primary"  type="buttom" onClick="location.href='problemlist.php'">上传完成</button>
				</div>
			</div>
		</div>
	</div>
</section>

<script> 
function   getVal(){ 
      if(confirm( "文件已存在，您确定要提交吗？ ")) 
            document.form1.choice.value   =   'true '; 
} 
</script> 

<?php	
	require_once 'template/footer.tpl';
?>

