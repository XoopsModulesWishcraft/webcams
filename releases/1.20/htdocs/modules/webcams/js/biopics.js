var account_id = new SessionVar("account_id","");
var gateway_ip = new SessionVar("gateway_ip","");
var member_user = new SessionVar("member_user","");
var member_pass = new SessionVar("member_pass","");
var host_name = new SessionVar("host_name","");
var mode_request = new SessionVar("mode_request","");
var sessionTheme = new SessionVar("sessionTheme","");
var chatWindowMode = new SessionVar("chatWindowMode",-1);
var modulePath = new SessionVar("modulePath",'');

var newHostImage;
var pbm;
var host_obj;
var configXML;
var myfavsUpdate;
var myfavsUpdateError;
var windowRef = null;
var lightBoxOpacity;
var loadingImg;
var imgWidth = 0;
var imgHeight = 0;
var agt = navigator.userAgent.toLowerCase();
var ie = ((agt.indexOf("msie")!=-1) && (agt.indexOf("opera")==-1));


function loadConfig()
{
	loadXML("config/configuration.xml",configCallBack,false);//non-async

	function configCallBack(xmlDoc)
	{
		configXML = xmlDoc;
		newHostImage = "themes/" + sessionTheme.get() + "/images/" + getXMLvalue(xmlDoc,"newHostImage","value");
		myfavsUpdate = getXMLvalue(xmlDoc,"myfavsUpdate","value");
		myfavsUpdateError = getXMLvalue(xmlDoc,"myfavsUpdateError","value");
		lightBoxOpacity = parseInt(getXMLvalue(xmlDoc,"lightBoxOpacity","value"));
		loadingImg = getXMLvalue(xmlDoc,"loadingImage","value");
		if(chatWindowMode.geti() == -1)
			chatWindowMode.set(getXMLvalue(xmlDoc,"chatWindowMode","value"));//1=lightbox, 2=tabbed browser & popup
		doAjax("host_info_request");
	}	
}

function ajaxCallback(obj)
{
	if(obj.action == "host_info_request"){
		host_obj = obj;
		loadNav();
		loadMainPic();
		loadPics();
		loadBio();
		loadRates();
		setTimeout("loadScheduler()",1);
		doAjax("user_myfavs_request");
	}else if(obj.action == "user_myfavs_request"){
		var hostName = "," + host_name.get() + ",";
		if(member_pass.get() != "guestpass"){
			if(obj.my_favs.indexOf(hostName) > -1){
				$("myfavsCB").checked = true;
			}else{
				$("myfavsCB").checked = false;
			}
		}
	}else if(obj.action == "user_myfavs_update"){		
		if(obj.message.indexOf("updated") > -1){//for updated or not updated
			$("myfavsUpdateDiv").innerHTML = myfavsUpdate;
		}else{
			$("myfavsUpdateDiv").innerHTML = myfavsUpdateError;
		}
	}
}

function doAjax(action)
{
	var params = '';
	if(action == "host_info_request"){
		params = "&action=host_info_request&account_id=" + account_id.get() + "&host_name=" + host_name.get();
    
	}else if(action == "user_myfavs_request"){
		params = "&action=user_myfavs_request&account_id=" + account_id.get() + "&user=" + member_user.get() + "&pass=" + member_pass.get();
	
	}else if(action == "user_myfavs_update"){
		params = "&action=user_myfavs_update&account_id=" + account_id.get() + "&user=" + member_user.get() + "&pass=" + member_pass.get();
		params += "&fav=" + host_name.get();
		$("myfavsUpdateDiv").innerHTML = "wait...";		
	}	
	
	if(params){
		var gatewayIP = gateway_ip.get();
		if(gatewayIP.indexOf("http://") == -1)
			gatewayIP = "http://"+gatewayIP;
		if(gatewayIP.indexOf("/gateway") == -1)
			gatewayIP += "/gateway/";
		sendAjax(gatewayIP, params, "ajaxCallback");		
	}	
}

function loadNav()
{
	var innerHTML = "";
	var navCamlist = getXMLvalue(configXML,"bioPicsNavCamlist","value");
	if(navCamlist){
		var mouseActions = ' onMouseOver="this.className=\'navButtonLeft navButtonLeftOver\'" onMouseOut="this.className=\'navButtonLeft\'"';
		innerHTML += '<div class="navButtonLeft" onClick="document.location=\'camlist.html\'" '+ mouseActions +'>&laquo;&nbsp;'+ navCamlist + '</div>';	
	}
	if(host_obj.online){
		var navPrivate = getXMLvalue(configXML,"bioPicsNavPrivate","value");
		if(parseFloat(host_obj.mode3) > 0 && navPrivate){
			var mouseActions = ' onMouseOver="this.className=\'navButtonRight navButtonRightOver\'" onMouseOut="this.className=\'navButtonRight\'"';
			innerHTML += '<div class="navButtonRight" onClick="openVideoChat(3)" '+ mouseActions +'>'+ navPrivate + '</div>';	
		}
		var navGroup = getXMLvalue(configXML,"bioPicsNavGroup","value");
		if(parseFloat(host_obj.mode2) > 0 && navGroup){
			var mouseActions = ' onMouseOver="this.className=\'navButtonRight navButtonRightOver\'" onMouseOut="this.className=\'navButtonRight\'"';
			innerHTML += '<div class="navButtonRight" onClick="openVideoChat(2)" '+ mouseActions +'>'+ navGroup + '</div>';	
		}
		var navFree = getXMLvalue(configXML,"bioPicsNavFree","value");
		if(parseFloat(host_obj.mode1) > 0 && navFree){
			var mouseActions = ' onMouseOver="this.className=\'navButtonRight navButtonRightOver\'" onMouseOut="this.className=\'navButtonRight\'"';
			innerHTML += '<div class="navButtonRight" onClick="openVideoChat(1)" '+ mouseActions +'>'+ navFree + '</div>';	
		}
	}
	
	$("bioPicsNav").innerHTML = innerHTML;
}

function loadMainPic()
{
	if(host_obj.main_pic == "newhost")
		host_obj.main_pic = newHostImage;
	var img = host_obj.main_pic +"_c.jpg";
	$("picInnerDiv").style.backgroundImage = 'url('+ img +')';	
	$("picInnerDiv").style.backgroundPosition = "center";
	$("picInnerDiv").style.backgroundRepeat = "no-repeat";
}

function loadPics()
{
	var picsHtml = "";
	for(var x=0;x<100;x++){
		if(host_obj["pic"+x]){
			picsHtml += "<a href='javascript:picWindow("+x+")' onfocus='blur()'><img src='" + host_obj["pic"+x] + "_b.jpg' class='thumb'/></a>";
		}		
	}
	$("picsDiv").innerHTML = picsHtml;
}

function loadBio()
{
	var hdrContent = "<div style='float:left'>" + getXMLvalue(configXML,"bio","value") + "</div>";
	var myfavs = getXMLvalue(configXML,"myfavs","value");
	if(myfavs && member_pass.get() != "guestpass"){
		hdrContent += "<div style='float:right;'><input type=checkbox id='myfavsCB' onClick='doAjax(\"user_myfavs_update\")'></div>";
		hdrContent += "<div style='float:right;'>"+ myfavs +"</div>";
		hdrContent += "<div id='myfavsUpdateDiv' style='float:right;'></div>";
	}
	
	$("bioHdrDiv").innerHTML = hdrContent;
	var bioHtml ="";
	var labelsArray = new Array("bioName","host_name","bioAge","age","bioLocation","local","bioOrientation","pref","bioCategories","category_list");
	labelsArray.push("bioLanguages","language_list","bioAimScreenName","aim","bioLikes","likes","bioDislikes","dislikes","bioBlurb","bio_blurb");
	for(var x=0; x<(labelsArray.length);x+=2){
		var tmp = getXMLvalue(configXML,labelsArray[x],"value");
		if(tmp)
			bioHtml += "<div class='bioRow'><span class='bioRowLabel'>"+tmp+"</span><span class='bioRowContent'>"+host_obj[labelsArray[x+1]]+"</span></div>";
	}

	$("bioDiv").innerHTML = bioHtml;
}

function picWindow(index)
{		
	if(chatWindowMode.geti() == 1){
		showFloatingDiv("floatingPicDiv",index);

	}else{
		var picWindow = window.open("");		
		var url = host_obj["pic"+index] + "_c.jpg";
		
		var bgColor = bgColor = getStyle("picsDiv","background-color");
		picWindow.document.open();
		picWindow.document.write("<html><body style='margin:0;padding:0;width:100%;height:100%;");
		picWindow.document.write("background-position:center;background-repeat:no-repeat;background-image:url("+url+");background-color:"+bgColor+"'>");
		picWindow.document.write("</body></html>");
		picWindow.document.close();
		if(window.focus)
			picWindow.focus();
	}
}

function loadRates()
{
	var innerHTML = "";
	var innerTxt = getXMLvalue(configXML,"perMinute","value");
	var pieces;
	if(innerTxt){
		innerHTML = '<span id="perMinuteTxt">' + innerTxt + '</span>';
		
		innerTxt = getXMLvalue(configXML,"groupRate","value");		
		if(innerTxt && host_obj.mode2){
			pieces = host_obj.mode2.split(" ");
			if(pieces[0] > 0)
				innerHTML += '<span id="groupRateTxt">' + innerTxt + host_obj.mode2 + '</span>';
		}
		innerTxt = getXMLvalue(configXML,"privateRate","value");
		if(innerTxt && host_obj.mode3){
			pieces = host_obj.mode3.split(" ");
			if(pieces[0] > 0)
				innerHTML += '<span id="privateRateTxt">' + innerTxt + host_obj.mode3 + '</span>';
		}
		$("ratesDiv").innerHTML = innerHTML;
	}	
}

function loadScheduler()
{
	var scheduleTxt = getXMLvalue(configXML,"schedule","value");
	var adjustedTxt = getXMLvalue(configXML,"adjusted","value");		
	var scheduleDays = getXMLvalue(configXML,"scheduleDays","value");
	scheduleDays = " ," + scheduleDays;
	var dayArray = scheduleDays.split(",");
	var hostTSArray = host_obj.schedule_secs_list;
	var s = $('schedDiv');
	var time = new Date();	
	var blockSecs = 0;
	var schedSecs = '';
	
	$("scheduleTxt").innerHTML = scheduleTxt;
	$("adjustedTxt").innerHTML = adjustedTxt;
	var schedule = "<table border='0' cellpadding='0' cellspacing='1' width='100%'>";	
	for(day=0;day<8;day++){//days
		schedule += '<tr>';
		
		for(hr=0;hr<25;hr++){//hours
			if(hr == 0){
				schedule += "<td class='schedDayCell'>"+ dayArray[day] +"</td>";
			}else{
				if(day==0){					 
					var hour = hr-1;
					if(hr == 1){
						hour = 12;
					}else if(hr > 12){
						hour = hr - 13;	 
						if(hour == 0)
							hour = 12;
					}
					schedule += "<td class='schedHourCell'>"+ hour +"</td>";		
				}else{
					var z = 0;
					for(;z<hostTSArray.length;z++){						
						time.setTime(hostTSArray[z] * 1000);
						schedSecs = (time.getDay()*86400) + (time.getHours()* 3600);
						if(schedSecs == blockSecs){
							schedule += "<td class='schedCellOnline'></td>";		
							break;
						}						
					}
					if(z >= hostTSArray.length)
						schedule += "<td class='schedCellOffline'></td>";		
					
					blockSecs += 3600;
				}	
			}	
		}
		schedule += "</tr>";
	}
	
	schedule += "</table>";
	s.innerHTML = schedule;
}

////////////////////////////////////////////////////////////////////////////////////////
///////////// Pop Up Window / Floating Div Section /////////////////////////////////////
function openVideoChat(mode)
{
	if(chatWindowMode.geti() == 1){// lightbox
		mode_request.set(mode);
		showFloatingDiv("playerDiv",0);		
	}else{
		if(!windowRef || windowRef.closed){
			mode_request.set(mode);
			var optStr = "";//if you add options, you must also use scrollbars=1, otherwise ff might not resize video window
			windowRef = window.open(modulePath.get()+"index.php?op=videochat","",optStr);		
		}
		if(windowRef.focus)
			windowRef.focus();
	}
}

function showFloatingDiv(divID,picIndex)
{
	var divObj = parent.document.getElementById(divID);
	if(!divObj){
		var dabody = parent.document.getElementsByTagName('body')[0];
		divObj = parent.document.createElement("div");
		divObj.id = divID;
		divObj.style.zIndex = "100";
		divObj.style.visibility = "hidden";
		divObj.style.position = "absolute";	
		divObj.style.top = "0px";
		divObj.style.left = "0px";
		dabody.appendChild(divObj);
	}
	if(divID == "playerDiv"){
		divObj.style.overflow = "visible";		
		
		if(parent != window){//we are in an iframe so need css proxy since player div is dynamically created in parent and our css won't directly apply
			var dabody = document.getElementsByTagName('body')[0];
			var proxyDivObj = document.createElement("div");
			proxyDivObj.id = "playerDiv";
			proxyDivObj.style.visibility = "hidden";
			proxyDivObj.style.position = "absolute";
			proxyDivObj.style.top = "0px";
			proxyDivObj.style.left = "0px";
			dabody.appendChild(proxyDivObj);
			var stylesArray = Array("border-left-width","border-left-style","border-left-color","border-right-width","border-right-style","border-right-color");
			stylesArray.push("border-top-width","border-top-style","border-top-color","border-bottom-width","border-bottom-style","border-bottom-color");
			for(var x=0;x<stylesArray.length;x++){//transfer css styles from proxy div to floatingdiv in parent
				var style = stylesArray[x];
				divObj.style[style.replace(/\-(\w)/g, function (str, p1){return p1.toUpperCase();})] = getStyle("playerDiv",style);
			}
			dabody.removeChild(proxyDivObj);//discard proxy div
		}		
		divObj.innerHTML = '<iframe id="playerFrame" src="'+modulePath.get()+'index.php?op=videochat" allowtransparency="true" frameborder="0" scrolling="no" vspace="0" hspace="0" marginwidth="0" marginheight="0" style="background-color:transparent;border:0px;"></iframe>';
	
	}else{//floatingPicDiv
		resizeMask();
		document.onkeypress=keyPressHandler;//to catch esc key for floating pic		
		pbm = getPaddingBorderMargin("floatingPicDiv","w");
		
		if(parent != window){//we are in an iframe so need css proxy since floating div is dynamically created in parent and our css won't directly apply
			var dabody = document.getElementsByTagName('body')[0];
			var proxyDivObj = document.createElement("div");
			proxyDivObj.id = "floatingPicDiv";
			proxyDivObj.style.visibility = "hidden";
			proxyDivObj.style.position = "absolute";	
			proxyDivObj.style.top = "0px";
			proxyDivObj.style.left = "0px";
			dabody.appendChild(proxyDivObj);
			pbm = getPaddingBorderMargin("floatingPicDiv","w");
			var stylesArray = Array("border-left-width","border-left-style","border-left-color","border-right-width","border-right-style","border-right-color");
			stylesArray.push("border-top-width","border-top-style","border-top-color","border-bottom-width","border-bottom-style","border-bottom-color","cursor");
			stylesArray.push("background-color","font-family","font-size","font-weight","color","cursor","text-align");
			for(var x=0;x<stylesArray.length;x++){//transfer css styles from proxy div to floatingdiv in parent
				var style = stylesArray[x];
				divObj.style[style.replace(/\-(\w)/g, function (str, p1){return p1.toUpperCase();})] = getStyle("floatingPicDiv",style);
			}
			dabody.removeChild(proxyDivObj);//discard proxy div
		}
		
		var floatingImg = new Image();	
		var clientWidth = (document.documentElement && document.documentElement.clientWidth) ? parent.document.documentElement.clientWidth : parent.innerWidth;
		var clientHeight = (document.documentElement && document.documentElement.clientHeight) ? parent.document.documentElement.clientHeight : parent.innerHeight;
		
		floatingImg.onload=function(){			
			imgWidth = floatingImg.width;//globals used for recentering on window resize
			imgHeight = floatingImg.height;
			divObj.style.left = Math.round((clientWidth/2) - ((imgWidth + pbm)/2)) + "px";//re-center horiz
			divObj.style.height = (imgHeight) + "px";
			divObj.style.width = imgWidth + "px";
			divObj.innerHTML = '<img src="' + host_obj['pic'+picIndex] + '_c.jpg' + '">';		
		};
		divObj.style.top = parseInt(getXMLvalue(configXML,"floatingPicDivY","value")) + "px"; //y offset
		divObj.style.left = Math.round((clientWidth/2) - (320+pbm)/2) + "px";//center horiz
		divObj.style.width ="320px";//init
		divObj.style.height = "240px";
		divObj.style.lineHeight = "240px";
		
		divObj.onmousedown = closeFloatingPicDiv;//click on image closes lightbox, esc does also
		
		divObj.innerHTML = loadingImg;//Loading Image ......
		floatingImg.src = host_obj["pic"+picIndex] + '_c.jpg';		
		divObj.style.visibility = "visible";		
	}
}

function keyPressHandler(e) {
	var keyCode  = (window.event) ? event.keyCode : e.keyCode; //ie : ff
	var esc = (window.event) ? 27 : e.DOM_VK_ESCAPE; // ie : ff
	if(keyCode == esc)
		closeFloatingPicDiv();
}
/*
resizeMask()
Used only to mask behind floating pic, video chat controls mask from within itself
*/
function resizeMask()
{
	if(!parent.document.getElementById("floatingPicDiv"))
		return;	//pic not showing 

	var doc = window.parent.document;
	var maskObj = doc.getElementById("mask"); 
	if(!maskObj){
		var dabody = doc.getElementsByTagName('body')[0];
		maskObj = doc.createElement("div");
		maskObj.id = "mask";
		maskObj.style.position = "absolute";
		maskObj.style.top = "0px";
		maskObj.style.left = "0px";
		maskObj.style.width = "100%";
		maskObj.style.zIndex = "10";
		maskObj.style.visibility = "hidden";
		
		// add resize event handler
		if(window.addEventListener){ // firefox
			parent.addEventListener('resize',resizeMask,false);
		} else { // ie
			parent.attachEvent('onresize',resizeMask);
		}		

		var userAgent = navigator.userAgent.toLowerCase();
		if (userAgent.indexOf('mac') != -1 && userAgent.indexOf('firefox')!=-1) {//mac ff bug :/
			maskObj.style.backgroundRepeat = "repeat";
			maskObj.style.backgroundImage = "url(themes/images/mask70.png)";
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
	
	var divObj = parent.document.getElementById("floatingPicDiv");
	if(divObj && imgWidth > 0){//recenter pic div
		var clientWidth = (document.documentElement && document.documentElement.clientWidth) ? parent.document.documentElement.clientWidth : parent.innerWidth;
		divObj.style.left = Math.round((clientWidth/2) - ((imgWidth + pbm)/2)) + "px";//re-center horiz
	}
}

function closeFloatingPicDiv()
{
	try{//remove resize event handler from parent window
		if(window.removeEventListener){ // ff
			parent.removeEventListener('resize',updateSize,false);
		} else { // ie
			parent.detachEvent('onresize',updateSize);
		}
	}catch(e){}	
	
	var dabody = parent.document.getElementsByTagName('body')[0];

	var maskObj = parent.document.getElementById("mask");
	if(maskObj){//remove mask
		while(maskObj.hasChildNodes()) {maskObj.removeChild(maskObj.lastChild );}
		dabody.removeChild(maskObj);
	}
	
	var divObj = parent.document.getElementById("floatingPicDiv");
	if(divObj){//remove pic div
		while(divObj.hasChildNodes()) {divObj.removeChild(divObj.lastChild );}
		dabody.removeChild(divObj);
		divObj.style.visibility = "hidden";
	}
	imgWidth = imgHeight = 0;//reset
}
