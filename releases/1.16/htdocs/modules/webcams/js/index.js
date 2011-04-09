var account_id = new SessionVar("account_id","");
var gateway_ip = new SessionVar("gateway_ip","");
var member_user = new SessionVar("member_user","");
var member_pass = new SessionVar("member_pass","");
var sessionTheme = new SessionVar("sessionTheme","");
var chatWindowMode = new SessionVar("chatWindowMode",-1);
var hideChat = new SessionVar("hideChat",-1);

function setSessionVars()
{
	account_id.set($("accountID").value);
	gateway_ip.set($("gatewayIP").value);
	member_user.set($("memberUser").value);
	member_pass.set($("memberPass").value);
	obj = $("chatWindowModeSelect");
	chatWindowMode.set(obj.options[obj.selectedIndex].value);
	obj = $("hideChatSelect");
	hideChat.set(obj.options[obj.selectedIndex].value);
}

function fillInValues()
{
	$("accountID").value = account_id.get();
	$("gatewayIP").value = gateway_ip.get();
	$("memberUser").value = member_user.get();
	$("memberPass").value = member_pass.get();

	obj = $("chatWindowModeSelect");
	for(var x=0;x<obj.length;x++){
		if(obj.options[x].value == chatWindowMode.get())
			obj.options[x].selected = true;
		else
			obj.options[x].selected = false;
	}
	obj = $("hideChatSelect");
	for(var x=0;x<obj.length;x++){
		if(obj.options[x].value == hideChat.get())
			obj.options[x].selected = true;
		else
			obj.options[x].selected = false;	
	}
}

function checkSilverlight(){
	var version = "";
	for(var x=1.0; x<5.0; x+=0.1){//brute force version detection
		var ver = x.toFixed(1).toString();
		if(Silverlight.isInstalled(ver))
			version = ver;
	}		
	
	if(version)
		$("silverlightInstalled").innerHTML = "Silverlight version " + version + " is installed";
	else
		$("silverlightInstalled").innerHTML = "Silverlight is not installed";		
}


function getSwfVer(){
	var isIE  = (navigator.appVersion.indexOf("MSIE") != -1) ? true : false;
	var isWin = (navigator.appVersion.toLowerCase().indexOf("win") != -1) ? true : false;
	var isOpera = (navigator.userAgent.indexOf("Opera") != -1) ? true : false;
	var flashVer = -1;
	
	if (navigator.plugins != null && navigator.plugins.length > 0) {
		if (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"]) {
			var swVer2 = navigator.plugins["Shockwave Flash 2.0"] ? " 2.0" : "";
			var flashDescription = navigator.plugins["Shockwave Flash" + swVer2].description;
			var descArray = flashDescription.split(" ");
			var tempArrayMajor = descArray[2].split(".");			
			var versionMajor = tempArrayMajor[0];
			var versionMinor = tempArrayMajor[1];
			var versionRevision = descArray[3];
			if (versionRevision == "") {
				versionRevision = descArray[4];
			}
			if (versionRevision[0] == "d") {
				versionRevision = versionRevision.substring(1);
			} else if (versionRevision[0] == "r") {
				versionRevision = versionRevision.substring(1);
				if (versionRevision.indexOf("d") > 0) {
					versionRevision = versionRevision.substring(0, versionRevision.indexOf("d"));
				}
			}
			var flashVer = versionMajor + "." + versionMinor + "." + versionRevision;
		}
	}else if ( isIE && isWin && !isOpera ) {
		var e;
		try{
			var axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7");
			var str = new String(axo.GetVariable("$version"));
			str = str.replace(/,/g,".");// 
			flashVer = str.replace(/WIN/g,"");

		}catch(e){}
	}	
	$("flashInstalled").innerHTML = "Flash version " + flashVer + " is installed";
}	

function checkSilverlight(){
	var version = "";
	for(var x=1.0; x<5.0; x+=0.1){//brute force version detection
		var ver = x.toFixed(1).toString();
		if(Silverlight.isInstalled(ver))
			version = ver;
	}		
	
	if(version)
		$("silverlightInstalled").innerHTML = "Silverlight version " + version + " is installed";
	else
		$("silverlightInstalled").innerHTML = "Silverlight is not installed";
}		
