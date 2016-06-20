<?php
	require_once 'template/header.tpl';
	require_once '../global.php';
	require_once("../functions.php");	
	
	if($_GET['userid']){
		$userid = $oDD->EscapeString($_GET['userid']);
	}
	$strSql="select * from commonuser where uid='".$userid."';";
	$rsResult = $oDD->Query($strSql);
	$rsUser = $oDD->FetchArray($rsResult, MYSQLI_ASSOC);
	
	$strSqlP = "SELECT orderNo FROM (SELECT (@rowNum:=@rowNum + 1) orderNo, uid
                  FROM commonuser, (SELECT (@rowNum:=0)) b ORDER BY p_ac DESC , p_ratio ASC) t
                 WHERE t.uid ='".$userid."';";
	if ($userid > 120)
    {
       $rank1 = $oDD->GetValue($strSqlP, MYSQLI_NUM, 0); 
    }  
    else{$rank1="";}
    

	$strSqlQ = "select distinct solution.pid from solution,problem where uid='".$userid."' and result=1 and solution.pid=problem.pid and defunct = 'Y' order by pid;";
	$rsResultQ = $oDD->Query("$strSqlQ");

?>
<div id="bt"><h2><center><?php echo $rsUser['user_name'];echo'---';echo $rsUser['name'];?></center></h2></div>
<section class="page container">
	<div class="row">
		<div class="span2"></div>
		<div class="span12">
		<div class="box pattern pattern-sandstone">
		<div class="box-content box-table">
			<div class="col-lg-10">		
				 <table id="sample-table" class="table table-hover table-bordered">
					 <tr><td width=15%>Rank:</td>
					 <td align=center width=25%><font color=red><?php echo $rank1;?></font></td>
					 <td width=60% align=center>Solved Problems List</td></tr>
					 <tr><td width=15%>Solved:</td> 
					 <td align=center width=25%>
					 <?php
						  $num = 0;
						  
						 while($rsProblem = $oDD->FetchArray($rsResultQ,MYSQLI_ASSOC))
						{	   
							   $num = $num + 1;  
						}
						echo $num;
					 ?>
					 </td>
					 <td width=60% rowspan=9 valign="top">
					 <?php 
						  $num = 0;
						  $rsResultE = $oDD->Query("$strSqlQ");
						 while($rsProblem = $oDD->FetchArray($rsResultE,MYSQLI_ASSOC))
						{
							   if($num%10==0){ echo '<br />'; }
							   echo $rsProblem['pid'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							   
							   $num = $num + 1;  
						}
					 ?>
					 
					 </td></tr>
					 <tr><td width=15%>Submissions:</td>
					 <td align=center width=25%><?php echo $rsUser['p_submit'];?></td></tr>
					 <tr><td width=15%>School:</td>
					 <td align=center width=25%><?php echo $rsUser['school'];?></td></tr>
					 <tr><td width=15%>College:</td>
					 <td align=center width=25%><?php echo $rsUser['college'];?></td></tr>
					 <tr><td width=15%>Grade:</td>
					 <td align=center width=25%><?php echo $rsUser['grade'];?></td></tr>     
					 <tr><td width=15%>Major:</td>
					 <td align=center><?php echo $rsUser['major'];?></td></tr>        
					 <tr><td width=15%>Class:</td>
					 <td align=center width=25%><?php echo $rsUser['class'];?></td></tr>
					 <tr><td width=15%>Student_ID:</td>
					 <td align=center width=25%><?php echo $rsUser['student_num'];?></td></tr>
					 <tr><td width=15%>Email:</td>
					 <td align=center width=25%><?php echo $rsUser['e-mail'];?></td></tr>
				 </table>
			</div>
		</div>
		</div>
		</div>
	</div>
</section>
<?php
	require_once 'template/footer.tpl';
?>
