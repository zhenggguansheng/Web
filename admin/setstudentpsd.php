<?php
	require_once 'template/header.tpl';
	require_once 'global.php';

	confirmlogin();
	
?>


<section class="container">
    <div class="row">
		<div class="span3">
			<div class="blockoff-left">
				<ul class="nav nav-list">
					<li><p><a href="addnewuser.php" target="contentframe">添加学生</a></p></li>
					<li><p><a href="addbatchnewuser.php" target="contentframe">批量增加学生用户信息</a></p></li>
					<li><p><a href="addbatchexamuser.php" target="contentframe">批量增加考试学生</a></p></li>				</ul>
			</div>
		</div>
		<div class="span12">
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>学生密码修改</h5>
				</div>							
				<form name= form1 method="post" action="spassword.php?action=submit" onSubmit="return formcheck()">
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<tbody>
							<tr>
								<td>用户名：</td>
								<td><input name="name1" value=""/></td>
								<td></td>
							</tr>
							<tr>
								<td >密码：</td>
								<td ><input name="pwd1" value=""/></td>
								<td ></td>
							</tr>
						</tbody>
					</table>
					<div class="box-footer">
						<button class="btn btn-primary" type="submit" name = "form1sub">提 交</button>
						<button class="btn btn-primary" type="button" onClick="history.go(-1);">返回</button>
					</div>
				</div>
				</form>
			</div>

			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>考试座位变更(IP地址清空)</h5>
				</div>							
				<form name= form1 method="post" action="clearip.php?action=submit" onSubmit="return formcheck()">
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<tbody>
							<tr>
								<td>用户名：</td>
								<td><input name="name3" value=""/></td>
								<td></td>
							</tr>
							<tr>
								<td>考试号：</td>
								<td><input name="name4" value=""/></td>
								<td></td>
							</tr>
						</tbody>
					</table>
					<div class="box-footer">
						<button class="btn btn-primary" type="submit" name = "form1sub">提 交</button>
						<button class="btn btn-primary" type="button" onClick="history.go(-1);">返回</button>
					</div>
				</div>
				</form>
			</div>
			
			<div id="Person-1" class="box">
				<div class="box-header">
					<i class="icon-edit icon-large"></i>
					<h5>学生位置修改</h5>
				</div>							
				<form name= form2 method="post" action="sseat.php?action=submit" onSubmit="return formcheck()">
				<div class="box-content box-table">
					<table class="table table-hover table-bordered">
						<tbody>
						   <tr>
								<td>用户名：</td>
								<td><input name="name2" value=""/></td>
								<td></td>
							</tr>
							<tr>
								<td>考场号：</td>
								<td><input name="room" value=""/></td>
								<td></td>
							</tr>
							<tr>
								<td>座位号：</td>
								<td><input name="seat" value=""/></td>
								<td></td>
							</tr>						
						</tbody>
					</table>
					<div class="box-footer">
						<button class="btn btn-primary" type="submit" name="form2sub">提 交</button>
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
