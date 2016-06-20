<?php
	require_once("global.php");
	confirmlogin();
	if(isset($_SESSION['cid']))
	{
		$cid = $oDD->EscapeString($_SESSION['cid']);
	}
	else{$cid="";}
		
	if(isset($_GET['userid']))
	{
		$userid = $oDD->EscapeString($_GET['userid']);
	}
	else{$userid="";}
	
	
	if(isset($_GET["action"]) and $_GET["action"]=="submit")
    {
		$room = $oDD->EscapeString($_POST['room']);
		$seat = $oDD->EscapeString($_POST['seat']);
		$sql = "update contest_user set `room`='".$room."',`seat`='".$seat."' where cid='".$cid."' and uid='".$userid."';" ;
		$res = $oDD->Query($sql);
		if($res)
		{
		}
	}
	
	$strSql = "select * from contest_user where cid='".$cid."' and uid='".$userid."';" ;
	$rsResult = $oDD->Query($strSql);
	$rsContest = $oDD->FetchArray($rsResult,MYSQLI_ASSOC);
	
?>
<link rel="stylesheet" type="text/css" href="css/contest.css" />
<body>
<div id="menubar">
		<div class="menubar">
			<div class="nav" id="nav">
            <ul>
				<li><p><a href="editcontestinfo.php">信息编辑</a></p></li>
				<li><p><a href="editproblem.php">题目列表</a></p></li>
				<li><p><a href="addproblem.php">添加题目</a></p></li>
				<li><p><a href="editstudent.php">学生列表</a></p></li>
				<li><p><a href="addstudent.php">添加学生</a></p></li>
				<li><p><a href="status.php">状态</a></p></li>
				<li><p><a href="ranklist.php">排名</a></p></li>
                <li><p><a href="statistics.php">统计</a></p></li>
            </ul>
 </div></div></div>
 
<div class="wrap">
<div class="location">
当前位置 > 信息编辑 > <?php echo $rsContest['uid'];?>
</div><br /><br />
<form name= form1 method="post" action="editcontestinfo.php?action=submit" onSubmit="return formcheck()">
<h2 class="h1"><b>修改教室座位号</b></h2>
<div class="admin_table mb10">
<table width="100%" cellspacing="0" cellpadding="0">
	<tr class="tr1 vt">
		<td class="td1">教室</td>
		<td class="td2">
			<input name="room" value="<?php echo $rsContest['room'];?>" style="width:200px;"/></td>
	</tr>
    <tr class="tr1 vt">
		<td class="td1">座位</td>
		<td class="td2"><input name="seat" value="<?php echo $rsContest['seat'];?>" style="width:200px;"/></td>
	</tr>
</table>
</div>

<br />
<div class="tac mb10">
	<span class="btn"><span><button type="submit">提 交</button></span></span>
	<span class="btn"><span><button type="reset">恢复初始设置</button></span></span>
</div>
</form>

</div>
<div class="wrap">
<h2 class="h1"><b>学生密码修改</b></h2>
<form method="post" action="spassword.php?action=submit">
<div class="admin_table mb10">
<table width="100%" cellspacing="0" cellpadding="0">
    <tr class="tr1 vt">
		<td class="td1" width="10%">用户名：</td>
		<td class="td2" width="50%"><input name="name" value=""/></td>
        <td class="td2" width="40%"></td>
	</tr>
    <tr class="tr1 vt">
		<td class="td1" width="10%">密码：</td>
		<td class="td2" width="50%"><input name="pwd" value=""/></td>
        <td class="td2" width="40%"></td>
	</tr>
</table>
</div>
<br />
<div class="tac mb10">
	<span class="btn"><span><button type="submit">提 交</button></span></span>
	<span class="btn"><span><button type="reset">清 空</button></span></span>
</div>
</form>
</div>
</body>
