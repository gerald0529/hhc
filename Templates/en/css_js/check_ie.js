function IEVersion() {
	var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串  
	var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1; //判断是否IE<11浏览器  
	var isEdge = userAgent.indexOf("Edge") > -1 && !isIE; //判断是否IE的Edge浏览器  
	var isIE11 = userAgent.indexOf('Trident') > -1 && userAgent.indexOf("rv:11.0") > -1;
	if(isIE) {
		var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
		reIE.test(userAgent);
		var fIEVersion = parseFloat(RegExp["$1"]);
		if(fIEVersion == 7) {
			co()
			return 7;
		} else if(fIEVersion == 8) {
			co()
			return 8;
		} else if(fIEVersion == 9) {
			co()
			return 9;
		} else if(fIEVersion == 10) {
			co()
			return 10;
		} else {
			co()
			return 6; //IE版本<=7
		}
	} else if(isEdge) {

		return 'edge'; //edge
	} else if(isIE11) {
		return 11; //IE11  
	} else {
		return -1; //不是ie浏览器
	}
}

function co() {
	alert("当前使用ie浏览器,颁布不足以显示效果,请升级到11,或者使用其他浏览器!");
	return false;
}