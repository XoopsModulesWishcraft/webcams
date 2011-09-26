/*
This code has been written to work around many browser issues, alter at your own risk

Compatible Browsers in decending order of player mode preference:

Flash H.264 / H.263 mode (All features work) ***********************
PC - Firefox, IE, Chrome, Opera, AOL, Netscape, Safari
Mac - Firefox, Opera, Safari
Linux - Firefox, Mozilla, SeaMonkey 

Silverlight 3 enhanced  mode *******************************
PC - IE6+, FireFox, Opera
Mac - Safari, FireFox

*/
var account_id = new SessionVar("account_id",'');
var gateway_ip = new SessionVar("gateway_ip",'');
var member_user = new SessionVar("member_user",'');
var member_pass = new SessionVar("member_pass",'');
var mode_request = new SessionVar("mode_request",'');
var host_name = new SessionVar("host_name",'');

var zoomIndex = new SessionVar("zoomIndex",-1);
var volumeSession = new SessionVar("volumeSession",-1);
var chatWidthMinimum = new SessionVar("chatWidthMinimum",0);
var chatWidthNominal = new SessionVar("chatWidthNominal",0);
var chatWindowMode = new SessionVar("chatWindowMode",-1);
var hideChat = new SessionVar("hideChat",-1);
var port = new SessionVar("port",3000);//default port is 3000
var alerts = new SessionVar("alerts",-1);//keep track if user turned off alerts
var bypassPPMconfirm = new SessionVar("bypassPPMconfirm",0);//show pop up in flash for user to confirm he understands the PPM price
var modulePath = new SessionVar("modulePath",'');

var videoWidth;
var videoHeight;
var clientWidth;
var clientHeight;
var configObj;
var updateSizeTimerID = null;
var lightBoxOpacity;
var zoomArray = Array();
var mutedVolume = -1;//not muted
var volume = 0;
var containerCSS;
var chatCSS;

var agt = navigator.userAgent.toLowerCase();
var ie = ((agt.indexOf("msie")!=-1) && (agt.indexOf("opera")==-1));
var ff = (agt.indexOf("firefox")!=-1);
var mac = (agt.indexOf("mac")!=-1);
var windows = (agt.indexOf("windows")!=-1);
var opera = (agt.indexOf("opera")!=-1);
var zoomEvent = false;
var initialZoom = true;
var chatOnly = false;
var videoCodec = "H26x";//default

/*
loadConfig()
It all starts here, parse the configuration.xml file and build the player 
*/
function loadConfig()
{	
	//parse href for query
	location.url = /\?.+/.exec(location.href);
	location.url = location.url?(location.url[0].substring(1).split('&')):[];
		
	for (var i=0,len=location.url.length;i<len;i++){
		var nameValuePair = location.url[i].split('=');
		location.url[nameValuePair[0]]=unescape(nameValuePair[1]);
	}
	
	if(location.url['host_name'])
		host_name.set(location.url['host_name']);//set session cookie
		
	if(location.url['mode_request'])		
		mode_request.set(location.url['mode_request']);//set session cookie		
	
	loadXML("config/configuration.xml",configCallBack,false);//non async
}

function configCallBack(xmlDoc)
{
	configObj = getXMLObj(xmlDoc);
	
	chatWidthMinimum.set(configObj.chatWidthMinimum);
	chatWidthNominal.set(configObj.chatWidthNominal);
	lightBoxOpacity = parseInt(configObj.lightBoxOpacity);
	bypassPPMconfirm.set(configObj.bypassPPMconfirm);
	
	if(chatWindowMode.geti() == -1)
		chatWindowMode.set(configObj.chatWindowMode);//1=lightbox, 2=pop up or tabbed 
	
	if(hideChat.geti() == -1)//not be set by an optional cookie
		hideChat.set(configObj.hideChat);//use config file setting
	
	if(zoomIndex.geti() == -1)
		zoomIndex.set(configObj.zoomIndexDefault);
	
	if(volumeSession.geti() == -1)
		volume = parseInt(configObj.initialVolume);//no previous volume setting, take initial
	else
		volume = volumeSession.geti();

	var sizes = configObj.zoomSizes;
	var tmpZoomSizes = sizes.split(",");
	
	for(var x=0;x<tmpZoomSizes.length;x++)
		zoomArray.push(parseFloat(tmpZoomSizes[x]));

	containerCSS = getCSS("container");	
	chatCSS = getCSS("fchat");
	
	if(window.addEventListener){ // ff
		parent.addEventListener('resize',updateSize,false);
	} else { // ie
		parent.attachEvent('onresize',updateSize);
	}			
	loadFlash();
}

function loadFlash()
{	
	var gatewayIP = gateway_ip.get();
	if(gatewayIP.indexOf("http://") == -1)
		gatewayIP = "http://"+gatewayIP;
	if(gatewayIP.indexOf("/gateway") == -1)
		gatewayIP += "/gateway/";

	videoWidth = 320;//initial setting
	videoHeight = 240;//initial setting

	var flashvars = {};
	flashvars.configFile = "config/configuration.xml";
	flashvars.accountID = account_id.get();
	flashvars.user = member_user.get();
	flashvars.pass = member_pass.get();	
	flashvars.gatewayIP = gatewayIP;
	flashvars.hostName = host_name.get();
	flashvars.modeRequest = mode_request.get();
	flashvars.port = port.get();
	flashvars.hideChat_ = hideChat.get();	
	flashvars.alerts = alerts.get();
	flashvars.bypass = bypassPPMconfirm.get();
	flashvars.userParams = "12345678";// pass thru vars for external balance	
	
	flashvars.mediaWidth = videoWidth;
	flashvars.mediaHeight = videoHeight;
	flashvars.volume = volume;

	var params = {quality:"high",allowscriptaccess:"always",allowfullscreen:"true",scale:"exactfit"};
	var attributes = {id:"fplayer",name:"fplayer",wmode:"opaque",allowScriptAccess:"always"};	
	swfobject.embedSWF("flash/Preloader.swf","dynamicContent","100%", "100%", "10.0.0", "", flashvars, params, attributes);
	
	zoom(zoomIndex.geti());//init	
	
	setTimeout(function(){						
		//// make player visible now
		if(chatWindowMode.geti()==1){//lightbox mode
			resizeMask();
			parent.document.getElementById("playerDiv").style.visibility = "visible";
			var player2Obj = $("playerDiv2");//this div is along for the ride in this mode
			if(player2Obj){
				player2Obj.style.visibility = "visible";
				player2Obj.style.border = "0px";//kill border since the floating outer div will already have one when chatWindowMode=1
			}	
			
		}else if(chatWindowMode.geti() == 2){
			parent.document.getElementById("playerDiv2").style.visibility = "visible";
		}
	},1);
}

/*
startMediaPlayer(url)
Called by the Flash player once it receives the host's url from the gateway
*/
function startMediaPlayer(url)
{	
	if(initialZoom){//no need to zoom a second time when going from free to ppm, fixes screen flashing
		zoom(zoomIndex.geti());
		initialZoom = false;
	}	
	
	if(chatOnly || videoCodec == "H26x"){
		return;

	}else if(Silverlight.isInstalled("2.0.31005")){
		setTimeout("createSilverlight('"+ url +"')",100);//let screen catch up before init silverlight
		return;
	
	}else{ ////// needs silverlight message //////////////////
		$("container").style.backgroundColor = "#ffffff";
		$("container").style.textAlign = "center";
		$("container").innerHTML = '<a href="http://go.microsoft.com/fwlink/?LinkID=149156&v=3.0.40624.0" style="text-decoration:"><img src="http://go.microsoft.com/fwlink/?LinkId=108181" alt="" style="border-style:none;margin-top:100px"/></a>';
	}
}
/*
Callback from flash chat, video size and silverlight capable, before StartMediaPlayer()
*/
function fplayer_DoFSCommand(command, args)
{
	if(command == "hostVideoInfo"){//wxh sl_capable video_codec chat_only
		try{$("fplayer").focus();}catch(e){}
		
		var pieces = args.split(" ");
		var sepIndex = pieces[0].indexOf("x");//320x240, wxh
		videoWidth = pieces[0].substr(0,sepIndex);
		videoHeight = pieces[0].substr(sepIndex+1);
		videoCodec = pieces[2] == "H264" ? "H26x":(pieces[2]=="H263"?"H26x":"WMV");
		chatOnly = pieces[3] == "1" ? true:false;

	}else if(command == "port"){//port probe found this port so use it next time to speed up connection
		port.set(args);
	}else if(command == "alerts"){//keep track of alerts settings in flash with session cookie
		alerts.set(args);
	}else if(command == "initialZoom"){//h264 and chat only mode
		zoom(zoomIndex.geti());
		initialZoom = false;			
	}else if(command == "zoom"){
		onZoom();
	}else if(command == "volume"){
		volumeSession.set(args);	//0 - 100
	}else if(command == "message"){
		message(args);
	}else if(command == "startMediaPlayer"){
		startMediaPlayer(args);
	}
}
/*
Message callback from flash chat
*/
function message(mess)
{	
	try{$("fchat").innerHTML = "";}catch(e){}
	try{$("leftDiv").innerHTML="";}catch(e){}

	var xmlTagName = "msg" + mess;
	var messageStr = configObj[xmlTagName];
	var containerH = $("container").style.height;	
 	var messStr = '<div class="messages"><span style="line-height:' + containerH + '" >' + messageStr + '</span></div>';
	$("container").innerHTML = messStr;	
}

function zoom(index)
{
	var sizeMultiplier = zoomArray[index];//1 to 4, but size 2 could point to multiplier 1.5
	var doc = window.parent.document;
	var playerDiv = chatWindowMode.geti() == 1 ? "playerDiv" : "playerDiv2";
	
	var playerDivPBMwidth = getPaddingBorderMargin(playerDiv,"w",parent);//outer most div 
	var playerDivPBMheight = getPaddingBorderMargin(playerDiv,"h",parent);
	
	var containerPBMwidth = containerCSS.marginLeft + containerCSS.borderLeftWidth + containerCSS.paddingLeft + containerCSS.marginRight + containerCSS.borderRightWidth + containerCSS.paddingRight;  
	var containerPBMheight = containerCSS.marginTop + containerCSS.borderTopWidth + containerCSS.paddingTop + containerCSS.marginBottom + containerCSS.borderBottomWidth + containerCSS.paddingBottom;
	
	var mediaBorder = 2 * parseInt(configObj.mediaStrokeThickness);
	var chatBorder = 2 * parseInt(configObj.chatStrokeThickness);

	var zoomBarHeight = (2*parseInt(configObj.zoomBarStrokeThickness)) + parseInt(configObj.zoomBarHeight) + parseInt(configObj.zoomBarMarginTop);

	var videoW = videoWidth * sizeMultiplier;	
	var videoH = videoHeight * sizeMultiplier;
	
	var chatW = chatWidthNominal.geti() - chatBorder;
	var chatH = videoH + mediaBorder + zoomBarHeight;

	if(hideChat.geti()==1){
		chatW = 0;
		chatH = 0;
		chatBorder = 0;

		chatWidthMinimum.set(0);
		chatWidthNominal.set(0);
	}

	var headerH = getPaddingBorderMargin("header","h");
	headerH += parseInt(getStyle("header","height"));
	
	if(headerH > 0){
		$("header").innerHTML = '<div id="logoDiv"></div><div class="closeButton" onClick="closePlayer()" onMouseOver="this.className=\'closeButtonOver\'" onMouseOut="this.className=\'closeButton\'"></div>';
	}
	var containerW, containerH, playerDivW, playerDivH, left, top;
	top = parseInt(configObj.floatingPlayerDivY);
	
	clientWidth = (doc.documentElement && doc.documentElement.clientWidth) ? doc.documentElement.clientWidth : parent.innerWidth;
	clientHeight = (doc.documentElement && doc.documentElement.clientHeight) ? doc.documentElement.clientHeight : parent.innerHeight;
	
	for(var x=0;x<800;x++){//adjust player to fit in browser window without scrollbars
		
		containerW = videoW + mediaBorder + chatW + chatBorder;
		containerH = videoH + mediaBorder + zoomBarHeight;					
	
		playerDivW = containerW + containerPBMwidth + playerDivPBMwidth;
		playerDivH = headerH + containerH + containerPBMheight + playerDivPBMheight;
		
		//test to make sure player < browser window
		if(clientWidth > playerDivW && clientHeight > playerDivH){
			break;
		}else{
			if(zoomEvent)//if manual click, not needed for window resize events
				index = zoomArray.length - 1;	//hitting window boundaries so reset zoom index to lowest zoom for next onZoom call		
			
			if(playerDivW > clientWidth){
				chatW-=1;
				
				if(chatW < chatWidthMinimum.geti()){
					if(!chatOnly)
						chatW = chatWidthMinimum.geti();						
					
					videoW-=1;
					videoH = Math.round((videoW-parseInt(configObj.chatMediaGap)-mediaBorder) * (videoHeight/videoWidth));
					chatH = videoH + mediaBorder + zoomBarHeight;				
				}
				
			}
			
			if(playerDivH > clientHeight){
				videoH-=1;
				if(!chatOnly)
					videoW = Math.round(videoH * (videoWidth/videoHeight));
					
				chatH = videoH + mediaBorder + zoomBarHeight;
			}
		}
	}
	
	left = Math.round((clientWidth/2) - (playerDivW/2));// center player horizontally
	if(playerDivH + top > clientHeight){	//need to center player vertically
		top = Math.round((clientHeight/2) - (playerDivH/2));
	}
	
	playerDivW -= playerDivPBMwidth;//remove after test
	playerDivH -= playerDivPBMheight;
	/// set sizes of everything
	var playerDiv = doc.getElementById(playerDiv);//this is outer most div
	playerDiv.style.left = left + "px";
	playerDiv.style.top = top + "px";
	playerDiv.style.width = playerDivW + "px";
	playerDiv.style.height = playerDivH + "px";
	
	var playerFrame = doc.getElementById("playerFrame");//iframe
	if(playerFrame){
		playerFrame.style.width = playerDivW + "px";
		playerFrame.style.overflow = "visible";
		playerFrame.style.height = playerDivH + "px";
	}
	$("header").style.width = playerDivW + "px";
	$("container").style.width = containerW + "px";
	$("container").style.height = containerH + "px";
	
	if(!chatOnly && videoCodec == "WMV"){//silverlight
		$("leftDiv").style.height = containerH + "px";
		$("leftDiv").style.width = (videoW + mediaBorder) + "px";		
	}

	if(hideChat.geti() == 1){
		chatH = containerH;		
		chatW = videoW == 0 ? containerW:videoW;		
		$("fchat").style.position = "absolute";
		$("fchat").style.left = Math.round(containerPBMwidth/2)+"px";
		$("fchat").style.width = (videoW+mediaBorder) + "px";		
	
	}else{
		if(chatOnly || videoCodec == "H26x"){//flash player stretches full container width
			$("fchat").style.width = (videoW+chatW+mediaBorder+chatBorder) + "px";
		
		}else{//silverlight with flash chat on the right
			$("fchat").style.width = (chatW-parseInt(configObj.chatMediaGap)+chatBorder) + "px";	
			$("fchat").style.marginLeft = configObj.chatMediaGap + "px";
		}
	}
	$("fchat").style.height = chatH + "px";		

	zoomIndex.set(index);//remember zoom size
	zoomEvent = false;
}

function resizeMask()
{
	if(chatWindowMode.geti() != 1)//only for lightbox mode
		return;
		
	var doc = window.parent.document;
	var maskObj = doc.getElementById("mask"); 
	if(!maskObj){
		var dabody = doc.getElementsByTagName('body')[0];//dynamically create mask on parent window under floating player div
		maskObj = doc.createElement("div");
		maskObj.id = "mask";
		maskObj.style.position = "absolute";
		maskObj.style.top = "0px";
		maskObj.style.left = "0px";
		maskObj.style.width = "100%";
		maskObj.style.zIndex = "10";
		maskObj.style.visibility = "hidden";
		
		var userAgent = navigator.userAgent.toLowerCase();
		if (userAgent.indexOf('mac') != -1 && userAgent.indexOf('firefox')!=-1) {//mac ff bug :/
			maskObj.style.backgroundRepeat = "repeat";
			maskObj.style.backgroundImage = "url(themes/images/mask70.png)";// 70% opacity png
			maskObj.innerHTML = '<iframe src="about:blank" style="position:absolute;top:0;left:0;z-index:-1;width:100%;height:99%;"></iframe>';
			
		}else{
			maskObj.style.backgroundColor = "#000000";
			maskObj.style.MozOpacity = lightBoxOpacity/100;
			maskObj.style.opacity = lightBoxOpacity/100;
    		maskObj.style.filter = "alpha(opacity="+ lightBoxOpacity +")";			
			if(userAgent.indexOf("msie 6") != -1)//use iframe to maskout selects in ie 6
				maskObj.innerHTML = '<iframe src="about:blank" style="position:absolute;top:0;left:0;z-index:-1;filter:mask();width:3000px;height:3000px;"></iframe>';
		}		
		dabody.appendChild(maskObj);
	}
	
	var clientHeight = parent.innerHeight ? parent.innerHeight : parent.document.documentElement.clientHeight;
	
	var scrollHeight; 
	if(window.innerHeight && window.scrollMaxY){//ff
		scrollHeight = parent.innerHeight + parent.scrollMaxY;
	}else if(doc.documentElement && doc.documentElement.scrollHeight > doc.documentElement.offsetHeight){ // ie strict mode
		scrollHeight = doc.documentElement.scrollHeight - (doc.documentElement.scrollHeight-doc.body.offsetHeight);
	}else{
		scrollHeight = doc.body.offsetHeight;
		if(!ie)
			scrollHeight += 20;
	}
	
	clientHeight = scrollHeight > clientHeight ? scrollHeight : clientHeight;
	maskObj.style.height = clientHeight + "px";
	maskObj.style.visibility = "visible";	
}

function updateSize()
{
	if(ie){
		clearTimeout(updateSizeTimerID);//ie constantly fires the onresize event so dont resize tell 500 millisecs after last event
		updateSizeTimerID = setTimeout( function(){try{resizeMask();}catch(e){} zoom(zoomIndex.geti());},500);
	}else{//everyone else
		try{resizeMask();}catch(e){} 
		zoom(zoomIndex.geti());
		clearTimeout(updateSizeTimerID);//cleanup vertical scroll bar issue on ff after resize to smaller width
		updateSizeTimerID = setTimeout( function(){try{resizeMask();}catch(e){} zoom(zoomIndex.geti());},1);
	}
}

function closePlayer()
{		
	if(chatWindowMode.geti() == 2){//tabbed / pop up window
		window.close();
		return;
	}	

	//teardown looks messy, hide our mess
	try{parent.document.getElementById("playerDiv").style.visibility = "hidden";}catch(e){}
	try{parent.document.getElementById("mask").style.visibility = "hidden";}catch(e){}
	
	//delay teardown to allow player to hide
	setTimeout(function(){						
		var dabody = parent.document.getElementsByTagName('body')[0];
		var playerObj = parent.document.getElementById("playerDiv");
		var maskObj = parent.document.getElementById("mask");	
		
		try{$("fchat").innerHTML = "";}catch(e){}
		
		//remove resize event handler from parent window
		if(window.removeEventListener){ // ff
			try{parent.removeEventListener('resize',updateSize,false);}catch(e){}
		} else { // ie
			try{parent.detachEvent('onresize',updateSize);}catch(e){}
		}
			
		if(ie){
			var playerFrame = parent.document.getElementById("playerFrame");
			if(playerFrame)
				playerFrame.src = "about:blank";//force ie to relase memory holding wmp
		}
		
		if(playerObj){//remove playerDiv
			while(playerObj.hasChildNodes()) {playerObj.removeChild(playerObj.lastChild );}
			dabody.removeChild(playerObj);
		}
		
		if(maskObj){//remove mask
			while(maskObj.hasChildNodes()) {maskObj.removeChild(maskObj.lastChild );}
			dabody.removeChild(maskObj);
		}
	},1);
}
/*
Called by silverlight so dont change function name
*/
function onZoom()
{
	var size=zoomIndex.geti();
	if(size+1>=zoomArray.length)
		zoomIndex.set(0);
	else 
		zoomIndex.set(size+1);
		
	zoomEvent = true;//user clicked zoom button
	zoom(zoomIndex.geti());
}

function getCSS(cssName)
{
	var cssObj = {};
	var styles = Array("margin-top","border-top-width","padding-top","padding-bottom","border-bottom-width","margin-bottom",
	"margin-left","border-left-width","padding-left","padding-right","border-right-width","margin-right","height","width",
	"border-bottom-color","background-image","background-color","left","line-height");

	for(var x=0; x<styles.length;x++){ 
		var styleName = styles[x].replace(/\-(\w)/g, function (str, p1){return p1.toUpperCase();});      
		var val = getStyle(cssName,styles[x]);
		if(val.indexOf("px") != -1){
			cssObj[styleName] = parseInt(val);
		}else if(val.indexOf("rgb") != -1){//rgb(144,144,144) convert to #909090
			var colors = val.substr(4).split(",");
			cssObj[styleName] = "#" + parseInt(colors[0]).toString(16) + parseInt(colors[1]).toString(16) + parseInt(colors[2].substr(0)).toString(16);
		}else if(val.indexOf("#") != -1){
			cssObj[styleName] = val;
		}else if(val.indexOf("url(") != -1){
			cssObj[styleName] = val.substr(4).replace(/'|"|\)/g,"");								  
		}else{
			cssObj[styleName] = 0;	
		}		
	}
	return cssObj;
}

/*
Silverlight Init
*/
function createSilverlight(url)
{	
	var initParams = "configFile=../config/configuration.xml";	
	initParams += ",mediaSource="+url;	
	initParams += ",mediaElementWidth=" + videoWidth;
	initParams += ",mediaElementHeight=" + videoHeight;
	initParams += ",volume=" + volume;
	
	$("leftDiv").innerHTML = '<object data="data:application/x-silverlight," type="application/x-silverlight-2" width="100%" height="100%"><param name="source" value="silverlight2/SilverlightPlayer.xap"/><param name="isWindowless" value="false"/><param name="background" value="#000000" /><param name="initParams" value="'+ initParams +'" /></object>';
		
	$("fplayer").focus();	
}

if(ie && !opera){
	document.write('<script FOR="fvideo" EVENT="FSCommand" LANGUAGE="Jscript">fvideo_DoFSCommand(arguments[0],arguments[1]);</script>');
	document.write('<script FOR="fplayer" EVENT="FSCommand" LANGUAGE="Jscript">fplayer_DoFSCommand(arguments[0],arguments[1]);</script>');
}
