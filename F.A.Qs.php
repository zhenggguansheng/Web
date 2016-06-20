<?php
	require_once 'template/header.tpl';
?>

<div id="bt"><h2><center>Frequently Asked Questions</center></h2></div>
<section class="page container">
	<div class="span2"></div>
	<div class="span12">
		<div class="box"> 
						<div class="box-header"> 
								  <i class="icon-book"></i> 
								  <h5>1001如何通过评测(多组输入)？</h5> 
						</div> 
						<div class="box-content"> 
<pre>
	 #include &lt;stdio.h>
	 int main(void) 
	 {
		int a, b;
		while ( scanf("%d%d",&a,&b) != EOF )
		{   
			printf("%d\n", a + b);
		}
		return 0;
	 }
</pre>
						 </div> 
						 <div class="box"> 
							 <div class="box-header"> 
								  <i class="icon-book"></i> 
								  <h5>C(输入组数的多组输入)？</h5> 
							 </div> 
							 <div class="box-content"> 
<pre>
	 #include &lt;stdio.h>
	 int main(void) 
	 {
		int n;
		scanf("%d",&n);
		for(int i = 0; i &lt n; i++)
		{   
			int a, b;
			scanf("%d%d",&a,&b)；
			printf("%d\n", a + b);
		}
		return 0;
	 }
</pre>
							</div>
							<div class="box-header"> 
							  <i class="icon-book"></i> 
							  <h5>C++(输入组数的多组输入)？</h5> 
							</div> 
							<div class="box-content"> 
<pre>
	#include &lt;iostream>
	using namespace std;
	int main(void)
	{
		int n;
		cin >> n;
		for(int i=0;i &lt; n;++i)
		{  
			int a,b;
			cin >> a >> b;
			cout << a + b;
		}
	 return 0;
	}
</pre>
							</div> 
							<div class="box-header"> 
							  <i class="icon-book"></i> 
							  <h5>Java(输入组数的多组输入)？</h5> 
							</div> 
							<div class="box-content"> 
<pre>
	import java.util.Scanner;
	public class Main {
		public static void main(String[] args) {
			Scanner in = new Scanner(System.in);
			int n = in.nextInt();
			for(int i=0;i&lt;n;++i)
			{
				int a = in.nextInt();
				int b = in.nextInt();
				System.out.println(a + b);
			}
		}
	}
</pre>
							</div> 
						</div>
			</div>
					
			<div class="box pattern pattern-sandstone">
						<div class="box-header">
							<i class="icon-table"></i>
							<h5>评判说明</h5>
						</div>
						<div class="box-content box-table">
							<table id="sample-table" class="table table-bordered">
								<thead>
									<tr>
										<th>评判结果</th>
										<th>含义</th>
								   </tr>
								</thead>
								<tbody>
									<tr>
										<td>Accepted</td>
										<td>程序的输出完全满足题意，通过了全部的测试数据的测试</td>
									</tr>
									<tr>
										<td>Wrong Answer</td>
										<td>程序顺利地运行完毕并正常退出，但是输出的结果却是错误的。注意：有的题包含多组测试数据，你的程序只要有一组数据是错误的，结果就是WA</td>
									</tr>
									<tr>
										<td>Presentation Error</td>
										<td>程序输出的答案是正确的，但输出格式不对，比如多写了一些空格、换行。请注意，大部分程序的输出，都要求最终输出一个换行。不过，计算机程序是很难准确判断PE错误的，所以，很多PE错误都会被评判成WA</td>
									</tr>
									<tr>
										<td>Compilation Error</td>
										<td>程序没有通过编译。可以点击文字上的链接，查看详细的出错信息，对照此信息，可以找出出错原因</td>
									</tr>
									<tr>
										<td>Judging</td>
										<td>正在运行评测程序进行测试，请稍候</td>
									</tr>
									<tr>
										<td>Time Limit Exceeded</td>
										<td>程序运行的时间超过了该题规定的最大时间，程序被Online Judge强行终止。注意：TE并不能说明你的程序的运行结果是对还是错，只能说明你的程序用了太多的时间</td>
									</tr>
									<tr>
										<td>Runtime Error</td>
										<td>OJ系统将返回一个Runtime Error的编号，由SIG或FPE开头，后面跟随一个整数</td>
									</tr>
									<tr>
										<td>System Error</td>
										<td>系统发生了错误。由于异常因素导致系统没有正常运作。我们尽力保证系统的稳定运行，但如您遇此情况，请联系管理员</td>
									</tr>
								</tbody>
							</table>
						</div>
				</div>	
						
				<div class="box pattern pattern-sandstone">
						<div class="box-header">
							<i class="icon-table"></i>
							<h5>评测系统的编译器及采用的语言标准</h5>
						</div>
						<div class="box-content box-table">
							<table id="sample-table" class="table table-bordered">
								<thead>
									<tr>
										<th>语言</th>
										<th>标准</th>
										<th>工具下载1</th>
										<th>工具下载2</th>
								   </tr>
								</thead>
								<tbody>
									<tr>
										<td>C</td>
										<td>C99</td>
										<td><a href="app/Dev-Cpp.exe">Dev-CPP</a></td>
										<td><a href="app/CodeBlocks.exe">CodeBlocks</a></td>
									</tr>
									<tr>
										<td>C++</td>
										<td>C++98</td>
										<td><a href="app/Dev-Cpp.exe">Dev-CPP</a></td>
										<td><a href="app/CodeBlocks.exe">CodeBlocks</a></td>
									</tr>
									<tr>
										<td>Java</td>
										<td>JDK 1.6</td>
										<td><a href="app/eclipse.exe">JDK 1.6(eclipse)</a></td>
										<td></td>
									</tr>
									<tr>
										<td>浏览器</td>
										<td>Chrome(Google)</td>
										<td><a href="app/ChromeStandaloneSetup.exe">下载安装</a></td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
				</div>
		</div>
</section>
<?php	require_once 'template/footer.tpl';
?>