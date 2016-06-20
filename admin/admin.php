<?php
	require_once 'template/header.tpl';
	require_once 'global.php';


?>

<section class="page container">
        <div class="row">
            <div class="span8">
                <div class="box">
                    <div class="box-header">
                        <i class="icon-bookmark"></i>
                        <h5>Shortcuts</h5>
                    </div>
                    <div class="box-content">
                        <div class="btn-group-box">
                            <a href="contest.php?id=1"    ><button class="btn"><i class="icon-star    icon-large"></i><br/>竞赛</button></a>
                            <a href="exam.php?id=2"       ><button class="btn"><i class="icon-road    icon-large"></i><br/>考试</button></a>
                            <a href="problemlist.php?id=3"><button class="btn"><i class="icon-book    icon-large"></i><br/>题库</button></a>
                            <a href="course.php?id=4"     ><button class="btn"><i class="icon-tasks   icon-large"></i><br/>课程</button></a>
							<a href="manageruser.php"     ><button class="btn"><i class="icon-user    icon-large"></i><br/>教师</button></a>
							<a href="news.php"            ><button class="btn"><i class="icon-comment icon-large"></i><br/>公告</button></a>
							<a href="setstudentpsd.php"       ><button class="btn"><i class="icon-key icon-large"></i><br/>学生信息</button></a>
						</div>
                    </div>
                </div>
            </div>
            <div class="span8">
                <div class="blockoff-left">
                    <legend class="lead">
                        Welcome
                    </legend>
                    <p>
                        OJ系统管理端
                    </p>
                </div>
            </div>
        </div>
</section>

<?php	
	require_once 'template/footer.tpl';
?>
