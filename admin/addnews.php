<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	
	if(isset($_GET["action"]) and $_GET["action"]=="submit")
	{
		$news = $oDD->EscapeString($_POST['description']);
		if (!empty($news) )
		{
			$in_date = $date = date("Y-m-d");
			$strSql = "insert into news(data,in_date) values('".$news."','".$in_date."');";
			
            $result = $oDD->Query($strSql);
			if($result)
			{
				Header("Location:news.php");
			}
		}
	}
?>

<meta charset="utf-8">
<script src="../ubuilder/ueditor.config.js"></script>
<script src="../ubuilder/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../ubuilder/zh-cn/zh-cn.js"></script>
<section class="container">
    <div class="row">
		<div class="span3">
			<div class="blockoff-left">
				<ul class="nav nav-list">
            		<li><p><a href="news.php">公告管理</a></p></li>
				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>公告管理</h5>
				</div>							
				<div class="box-content box-table">
					<form name = "news" method = "post" action="addnews.php?action=submit">
					<table class="table table-hover table-bordered">
						<thead>
							<th>公告内容</th>
						</thead>
						<tbody>
							<tr>
								<td>
									<script id="editor1" name="description" type="text/plain" style="width:860px;height:200px;"></script>
									<script type="text/javascript">var ue1 = UE.getEditor('editor1');</script>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="box-footer">
						<button class="btn btn-primary" type="submit">提 交</button>
						<button class="btn btn-primary" type="button" onClick="history.go(-1);">返回</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</section>
<?php	
	require_once 'template/footer.tpl';
?>
