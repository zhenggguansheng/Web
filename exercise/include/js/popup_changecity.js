//---------------------------------弹窗类-----------------------------------
function popupchangecity(popId,bgcolor,alpha){//
    this.popWindow=document.getElementById(popId);
    this.bgcolor=bgcolor;
    this.alpha=alpha;   
	this.mybg=null; 
	
}

//创建弹窗
popupchangecity.prototype.create=function(sourceForm){ 
	var isIE6 = navigator.userAgent.indexOf("MSIE 6.0")>0;
	var sTop;
	var obj;
    if(!this.mybg){	
			
		//设置窗口属性	
		this.popWindow.style.display = "block";
		this.popWindow.style.position = "fixed";
		this.popWindow.style.zIndex = 9999;	
		this.popWindow.style.top = "20%";
		this.popWindow.style.left = "50%";
		this.popWindow.style.marginTop = -(this.popWindow.clientHeight/2)+"px";
		this.popWindow.style.marginLeft = -(this.popWindow.clientWidth/2)+"px";	
		
		//创建遮盖层	
		mybg = document.createElement("div");	
		mybg.style.background = this.bgcolor;
		mybg.style.width = "100%";
		mybg.style.height = "100%";
		mybg.style.position = "fixed";
		mybg.style.top = "0";
		mybg.style.left = "0";
		mybg.style.zIndex = "9000";
		mybg.style.opacity = (this.alpha/100);
		mybg.style.filter = "Alpha(opacity="+this.alpha+")";
		document.body.appendChild(mybg);	
		this.mybg=mybg;	
		
		if(isIE6){
			var mybg_iframe = document.createElement("iframe");		
			document.body.appendChild(mybg_iframe);
			mybg_iframe.style.position = "absolute";		
			mybg_iframe.style.zIndex = "450";
			mybg_iframe.style.top = "0";
			mybg_iframe.style.left = "0";
			mybg_iframe.style.width = "100%";
			mybg_iframe.src = "";
			mybg_iframe.style.filter = "Alpha(opacity=0)";
			this.mybg_iframe = mybg_iframe;
			this.popWindow.style.position = "absolute";
			mybg.style.position = "absolute";
			
		}
	}
	
	if(this.mybg_iframe){this.mybg_iframe.style.display="block";}
	
	this.mybg.style.display="block";
	this.popWindow.style.display = "block";
	
	if(isIE6){	
		var sh=document.body.scrollHeight;
		var ch=document.documentElement.clientHeight;
		if(sh<ch){
			mybg.style.height=ch+"px";
			if(mybg_iframe){mybg_iframe.style.height = ch+"px";}
			}
		else{mybg.style.height=sh+"px";
			if(mybg_iframe){mybg_iframe.style.height = sh+"px";}
			
		}//针对ie6.0不定义body高度遮盖层高度无效
		var obj=this.popWindow;
		sTop=setInterval(init, 100); 

	};	

	//ie6下调整登录框位置
	function init(){ 
	var st=document.documentElement.scrollTop;
	if (st!=0){  
	 var ch=document.documentElement.clientHeight;
	 obj.style.top= st+(ch*0.5)+"px";
     clearInterval(sTop);//执行成功，清除监听  
		}
	}
}
//弹窗拖动
popupchangecity.prototype.drag=function(handId){//
    $(handId).onselectstart=function(){return false};
    var s_left=0;
    var s_top=0;
	var popupchangecity=this.popWindow;
    ev.addEvent($(handId),"mousedown",mDown);
	//按下时
	function mDown(){
	    var evn=ev.getEvent();        
        //拖动修正值
        f_left=evn.clientX-popupchangecity.offsetLeft;
        f_top=evn.clientY-popupchangecity.offsetTop;       
        s_left=evn.clientX-f_left+"px";
        s_top=evn.clientY-f_top+"px";	
		ev.addEvent(document,"mousemove",mMove);
		ev.addEvent(document,"mouseup",mUp);
	}
	//拖动时
	function mMove(){
        var evn=ev.getEvent();        
        popupchangecity.style.left=evn.clientX-f_left+(popupchangecity.clientWidth/2)+"px";
        popupchangecity.style.top=evn.clientY-f_top+(popupchangecity.clientHeight/2)+"px";
   }
   //放下时
   function mUp(){
        ev.removeEvent(document,"mousemove",mMove);
        ev.removeEvent(document,"mouseup",mUp);
   }
}

//关闭弹窗
popupchangecity.prototype.closepopupchangecity=function(){  	
    this.popWindow.style.display="none";	
	this.mybg.style.display="none";		
	if(this.mybg_iframe){this.mybg_iframe.style.display="none";}
}
