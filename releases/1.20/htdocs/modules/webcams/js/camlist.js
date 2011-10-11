var category = new SessionVar("category","NONE");
var page = new SessionVar("page",1);
var account_id = new SessionVar("account_id","");
var gateway_ip = new SessionVar("gateway_ip","");
var member_user = new SessionVar("member_user","");
var member_pass = new SessionVar("member_pass","");
var mode_request = new SessionVar("mode_request","");
var host_name = new SessionVar("host_name","");
var sessionTheme = new SessionVar("sessionTheme","");
var chatWindowMode = new SessionVar("chatWindowMode",-1);
var modulePath = new SessionVar("modulePath",'');

var perPage;
var balance;
var noCamsMessage;
var offline;
var freeChat;
var groupChat;
var privateChat;
var bioPics;
var newHostImage;
var windowRef = null;
var lightBoxOpacity;
var autoRefresh;
var timerID = null;
var autoRefreshTime = 0;
var searchTxt = "";

/////////////////////////////////////////////////////////
function loadConfig()
{
	loadXML(modulePath.get()+"config/configuration.xml",configCallBack,true);
	function configCallBack(xmlDoc)
	{
		if(category.get() == "NONE")
			category.set(getXMLvalue(xmlDoc,"defaultCategory","value"));
		perPage = parseInt(getXMLvalue(xmlDoc,"perPage","value"));
		balance = getXMLvalue(xmlDoc,"yourBalanceTxt","value");
		noCamsMessage = getXMLvalue(xmlDoc,"noCamsMessage","value");
		offline = getXMLvalue(xmlDoc,"offline","value");
		freeChat = getXMLvalue(xmlDoc,"freeChat","value");
		groupChat = getXMLvalue(xmlDoc,"groupChat","value");
		privateChat = getXMLvalue(xmlDoc,"privateChat","value");
		bioPics = getXMLvalue(xmlDoc,"bioPics","value");
		newHostImage = "themes/" + sessionTheme.get() + "/images/" + getXMLvalue(xmlDoc,"newHostImage","value");
		if(chatWindowMode.geti() == -1)
			chatWindowMode.set(getXMLvalue(xmlDoc,"chatWindowMode","value"));//1=lightbox, 2=tabbed browser & popup
		lightBoxOpacity = parseInt(getXMLvalue(xmlDoc,"lightBoxOpacity","value"));
		autoRefresh = parseInt(getXMLvalue(xmlDoc,"autoCamlistRefresh","value"));
		autoRefresh = autoRefresh < 15 ? 0:autoRefresh;//misconfigure so turn it off
		timerID = setInterval("timerEvents()",1000);//every second check things
		initPlayer();
	}
}

function initPlayer()
{
	doAjax("player_init");
	doAjax("cam_list_request");	
	if(member_pass.get() != "guestpass")
		doAjax("user_balance_request");
}

function setCategory()
{
	var obj = $("categorySel");
	category.set(obj.options[obj.selectedIndex].text);
	page.set(1);
	searchTxt = "";
	doAjax("cam_list_request");
}

function doSearch(obj,event)
{
	var c = event.which ? event.which : event.keyCode;
	if(c == 13){
		searchTxt = obj.value;
		page.set(1);
		doAjax("cam_list_request");
		obj.value = "";
	}
	return true;
}

function ajaxCallback(obj)
{
	if(obj.action == "player_init"){//player init cb
		initCategories(obj.category_list, $("categorySel"));
	
	}else if(obj.action == "cam_list_request"){//cam_list_request cb
		$("camlistDiv").innerHTML = initCamlist(obj);
		$("pagingDiv").innerHTML = initPaging(obj);
	
	}else if(obj.action == "user_balance_request" && balance){//user_balance_request cb
		var balSpan = $("balanceSpan");
		if(balSpan && obj.balance){
			balSpan.innerHTML = balance + obj.balance;
		}
	}
}

function doAjax(action)
{
	var params = '';
	if(action == "player_init"){
		params = "&action=player_init&account_id=" + account_id.get();
    
	}else if(action == "cam_list_request"){
		params = "&action=cam_list_request&account_id="+ account_id.get();
		params+= "&page="+ (page.geti()-1) +"&page_size="+ perPage;
		var srch = $("search").value;
		if(!srch && searchTxt)//keeps search result during auto refreshes
			srch = searchTxt;
		params+= "&user="+ member_user.get() +"&pass="+ member_pass.get() +"&category="+ category.get() + "&host_name=" + srch;
			
	}else if(action == "user_balance_request"){
		params = "&action=user_balance_request&account_id="+ account_id.get();
		params += "&user=" + member_user.get() +"&pass=" + member_pass.get();
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

function initCategories(cats, obj)
{
	for(x=0;x<cats.length; x++){
		var selected = false;
		if(category.get() == cats[x])
			selected = true;     
		obj.options[x] = new Option(cats[x],'');
		obj.options[x].selected = selected;
	}
}

function initPaging(obj)
{
	var pages = Math.ceil(obj.host_cnt / perPage);
	var lowerCnt = 1;
	if(pages < 6)
		var upperCnt = pages;
	else	
		var upperCnt = 5;

	if(page.geti() > 5){
		lowerCnt = page.geti() - 4;
		upperCnt = page.geti();
	}

	//next button
	var temp = "";
	if(page.geti() < pages){
		temp += '<div class="pagingNext paging" onClick="page.set('+(page.geti()+1)+');doAjax(\'cam_list_request\')" ';
		temp += 'onmouseover="this.className=\'pagingNextOver paging\';" onmouseout="this.className=\'pagingNext paging\';">&raquo;</div>';
	}else{
		temp += '<div class="pagingNext paging" >&raquo;</div>';  
	}
			
	//button
	for(x=upperCnt;x>=lowerCnt;x--){
		if(x == page.geti()){
			temp += '<div class="pagingNumberOver paging">'+ x +'</div>';
		}else{			
			temp += '<div class="pagingNumber paging" onClick="page.set('+x+');doAjax(\'cam_list_request\')" ';
			temp += 'onmouseover="this.className=\'pagingNumberOver paging\';" onmouseout="this.className=\'pagingNumber paging\';">'+ x +'</div>';
		}
	}
			  
  //previous button
	if(page.geti() > 1){
		temp += '<div class="pagingPrev paging" onClick="page.set('+(page.geti()-1)+');doAjax(\'cam_list_request\')" ';
		temp += 'onmouseover="this.className=\'pagingPrevOver paging\';" onmouseout="this.className=\'pagingPrev paging\';">&laquo;</div>';
	}else{
		temp += '<div class="pagingPrev paging">&laquo;</div>';	
	}
	return temp;
}

function initCamlist(obj)
{
	autoRefreshTime = 0;// signal we refreshed	
	
	if(obj.host_cnt == 0){
		return '<div id="nocamsDiv">'+ noCamsMessage +'</div>';
	}else{
		var camlist = '';
		for(x=0;x<perPage;x++){
			var h = obj['host'+x];		
			if(!h)//no more in the list
				break;		
		
			var links = '';
			var imgSrc = '';
			var mouseOvers = 'onMouseOver="this.className=\'camlistButtonOver\';" onMouseOut="this.className=\'camlistButton\';" ';

			if(h.online == '0'){
				links += '<div class="camlistButton">' + offline + '</div>';
			}else{
				if(h.mode1 > 0){
					links += '<div class="camlistButton" ' + mouseOvers + 'onClick="openVideoChat(1,\''+h.host_name+'\')">' + freeChat + '</div>';
				}
				if(h.mode2 > 0){
					links += '<div class="camlistButton" ' + mouseOvers + 'onClick="openVideoChat(2,\''+h.host_name+'\')">' + groupChat + '</div>';
				}
				if(h.mode3 > 0){
					links += '<div class="camlistButton" ' + mouseOvers + 'onClick="openVideoChat(3,\''+h.host_name+'\')">' + privateChat + '</div>';
				}
			}	
			if(bioPics){
				links += '<div class="camlistButton" ' + mouseOvers + 'onClick="openBioPics(\''+h.host_name+'\')">' + bioPics + '</div>';
			}		
					
			var img = h.pic;
			if(img && img.indexOf('newhost')!= -1){
				imgSrc = '<img class="hostPic" src="'+newHostImage+'_b.jpg">';	
			}else{
				imgSrc = '<img class="hostPic" src="'+img+'_b.jpg">';	
			}	

			//////// begin host box *********
			camlist += '<div class="camlistBox" style="display:inline;">';
			/// name div
			camlist += '<div class="hostName">'+h.host_name+'</div>';
			/// thumb image
			camlist += imgSrc;
			/// button div
			camlist += '<div style="float:left;position:relative;">'+links+'</div>';
			////end host box *****************
			camlist += '</div>';

		}
		return camlist;
	}
}
function timerEvents()
{
	var current = new Date();
	var millSecs = current.getTime();
	
	if(autoRefresh > 0){
		if(autoRefreshTime == 0){
			autoRefreshTime = millSecs + (autoRefresh*1000);//next refresh time			
		}else if(millSecs > autoRefreshTime){
			if(parent.document.getElementById("playerDiv") || (windowRef && !windowRef.closed)){
				return;//don't update while streaming video
			}			
			doAjax("cam_list_request");			
		}
	}	
}
////////////////////////////////////////////////////////////////////////////////////////
///////////// Pop Up Window / Floating Div Section /////////////////////////////////////
function openVideoChat(mode,hostName)
{
	mode_request.set(mode);
	host_name.set(hostName);
	
	if(chatWindowMode.geti() == 1){//lightbox
		showFloatingDiv(parent.document);
	
	}else{//tabbed / popup
		if(!windowRef || windowRef.closed){
			var optStr = "";//if you add options, you must also use scrollbars=1, otherwise ff new plugin might not resize video window
			windowRef = window.open(modulePath.get()+"index.php?op=videochat","",optStr);		
		}
		if(windowRef.focus)
			windowRef.focus();
	}
}

function showFloatingDiv(doc)
{
	var playerObj = doc.getElementById("playerDiv");
	if(!playerObj){
		var dabody = doc.getElementsByTagName('body')[0];
		playerObj = doc.createElement("div");
		playerObj.id = "playerDiv";
		playerObj.style.position = "absolute";
		playerObj.style.top = "0px";
		playerObj.style.left = "0px";
		playerObj.style.zIndex = "100";
		playerObj.style.visibility = "hidden";
		playerObj.style.overflow = "visible";
		dabody.appendChild(playerObj);
		
		if(parent != window){//we are in an iframe so need css proxy since player div is dynamically created in parent and our css won't directly apply
			var dabody = document.getElementsByTagName('body')[0];
			var proxyDivObj = document.createElement("div");
			proxyDivObj.id = "playerDiv";
			proxyDivObj.style.visibility = "hidden";
			proxyDivObj.style.position = "absolute";		
			dabody.appendChild(proxyDivObj);
			var stylesArray = Array("border-left-width","border-left-style","border-left-color","border-right-width","border-right-style","border-right-color");
			stylesArray.push("border-top-width","border-top-style","border-top-color","border-bottom-width","border-bottom-style","border-bottom-color");
			
			for(var x=0;x<stylesArray.length;x++){//transfer css styles from proxy div to floatingdiv in parent
				var style = stylesArray[x];
				playerObj.style[style.replace(/\-(\w)/g, function (str, p1){return p1.toUpperCase();})] = getStyle("playerDiv",style);
			}
			dabody.removeChild(proxyDivObj);//discard css proxy div
		}	
	}
	var scrolling = navigator.userAgent.toLowerCase().indexOf("firefox")!=-1 ? "yes":"no";//outer container needs scrolling on for ff to allow zoom in windowlessvideo mode
	playerObj.innerHTML = '<iframe id="playerFrame" name="playerFrame" src="'+modulePath.get()+'index.php?op=videochat" allowtransparency="true" frameborder="0" scrolling="'+scrolling+'" vspace="0" hspace="0" marginwidth="0" marginheight="0" style="background-color:transparent;border:0px;"></iframe>';
}
////////////////////////////////////////////////////////
function openBioPics(hostName)
{
	host_name.set(hostName);
	document.location = modulePath.get()+"index.php?op=biopics";
}
