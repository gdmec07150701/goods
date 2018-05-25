(function(doc, win) {
	
//响应
var docEl = doc.documentElement,
resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
recalc = function() {
	var clientWidth = docEl.clientWidth;
	if(!clientWidth) return;
	docEl.style.fontSize = 10 * (clientWidth / 320) + 'px';
};

if(!doc.addEventListener) return;
win.addEventListener(resizeEvt, recalc, false);
doc.addEventListener('DOMContentLoaded', recalc, false);

//点击返回按钮
$("#event-back").click(function(){

//方法一：返回
history.go(-1);

//方法二:跳转
//window.location.href="home.html";
});

})(document, window);


function ajaxUrl(controType){
	var type='api';
	if(controType){
		type=controType;
	}
	return "http://www.wlytpay.com/qfb/index.php/api/"+type+"/";
}


//数据请求
function requestAjax(data,type){
	var controType='api';
	if(data && data.controType){
		controType=data.controType;
	}
	console.log(data);
	$.ajax({
		type: "POST",
		url: ajaxUrl(controType)+data.action,
		data: data,
		dataType: "json",
		success: function(res) {
			console.log(res);
			if(type==1){
				callBack1(res);
			}
			else if(type==2){
				callBack2(res);
			}
			else if(type==3){
				callBack3(res);
			}else if(type==101){
				callBack101(res);
			}else{
				callBack(res);
			}
		},
		error: function(msg) {
			hideToast();
			if(type<100){
				alert("操作失败");
			}else if(type==101){
				callBackError101();
			}
		}
	});
}

function ajaxNps(){
	var url="http://www.wlytpay.com/qfb/index.php/api/Nps/";
	// var url="http://localhost:90/qingfubei/index.php/api/api/";
	return url;
}

//数据请求
function requestNps(data,type){
	console.log(data);
	$.ajax({
		type: "POST",
		url: ajaxNps()+data.action,
		data: data,
		dataType: "json",
		success: function(res) {
			console.log(res);
			if(type==1){
				callBack1(res);
			}
			else if(type==2){
				callBack2(res);
			}
			else if(type==3){
				callBack3(res);
			}else if(type==101){
				callBack101(res);
			}else{
				callBack(res);
			}
		},
		error: function(msg) {
			hideToast();
			if(type<100){
				alert("操作失败");
			}else if(type==101){
				callBackError101();
			}
		}
	});
}

function ajaxHl(){
	var url="http://www.wlytpay.com/qfb/index.php/api/Hl/";
	// var url="http://localhost:90/qingfubei/index.php/api/api/";
	return url;
}

//数据请求
function requestHl(data,type){
	console.log(data);
	$.ajax({
		type: "POST",
		url: ajaxHl()+data.action,
		data: data,
		dataType: "json",
		success: function(res) {
			console.log(res);
			if(type==1){
				callBack1(res);
			}
			else if(type==2){
				callBack2(res);
			}
			else if(type==3){
				callBack3(res);
			}else if(type==101){
				callBack101(res);
			}else{
				callBack(res);
			}
		},
		error: function(msg) {
			hideToast();
			if(type<100){
				alert("操作失败");
			}else if(type==101){
				callBackError101();
			}
		}
	});
}


// showToast
function showToast(msg) {
	var msg = msg ? msg : '加载中';
	var body = document.querySelector('body');
	var toastWrap = document.createElement('div');
	toastWrap.setAttribute('class', 'toast-wrap');
	var toastOut = document.createElement('div');
	toastOut.innerHTML = msg + '...';
	toastWrap.appendChild(toastOut);
	body.appendChild(toastWrap);
}


// hideToast
function hideToast() {
	var body = document.querySelector('body');
	var toastWrap = document.getElementsByClassName('toast-wrap')[0];
	if(toastWrap){
		body.removeChild(toastWrap);
	}
}


// function getOption(selectName){
// 	var select=document.querySelector("select[name='"+selectName+"']");
// 	select.onchange=function(){
// 		var selectedIndex=select.selectedIndex;
// 		var text=select.options[selectedIndex].text;

// 		return text;
// 	}
// }