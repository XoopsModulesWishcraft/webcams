try { document.execCommand("BackgroundImageCache",false,true); } catch(e) {}//ie background image flicker fix

function showHide(el) 
{	
	if($(el).style.display == "none"){
		$(el).style.display = "block";
	}else{
		$(el).style.display = "none";			
	}	
}


var scriptID = 0;
var scriptArray = new Array();

function sendAjax(url_, params, callback)
{
	var date = new Date();
	var url = url_ + "?nocache=" + date.getMilliseconds() + "&json=1";
	if(callback)
		url += "&callback=" + callback;
		
	var pieces = params.split("&");
	for(var x=0; x<pieces.length; x++){
		if(pieces[x]){
			var subpieces = pieces[x].split("=");
			if(subpieces.length){
				url += "&" + encodeURIComponent(subpieces[0]) + "=" + encodeURIComponent(subpieces[1]);
			}
		}
	}
	try{
		document.getElementsByTagName('head')[0].removeChild(scriptArray[scriptID]);	//remove old scripts
	}catch(e){}
	scriptArray[scriptID] = document.createElement('script');
	scriptArray[scriptID].type = 'text/javascript';
	scriptArray[scriptID].src = url;
		
	document.getElementsByTagName('head')[0].appendChild(scriptArray[scriptID]);
	scriptID++;
	if(scriptID >= 10)//circular script array
		scriptID = 0;	
}
///////////////////////////////////////////////////////////////////////////////////////
function setCookie(name, value, expires, path, domain, secure) 
{
	var curCookie = name + "=" + escape(value) + ((expires) ? "; expires=" + expires.toGMTString() : "") +
	((path) ? "; path=" + path : "") + ((domain) ? "; domain=" + domain : "") +	((secure) ? "; secure" : "");
	document.cookie = curCookie;
}
function getCookie(name) 
{
	var dc = document.cookie;
	var prefix = name + "=";
	var begin = dc.indexOf("; " + prefix);
	if (begin == -1) {
		begin = dc.indexOf(prefix);
		if (begin != 0) return null;
	} else
		begin += 2;
	var end = document.cookie.indexOf(";", begin);
	if (end == -1)
		end = dc.length;
	return unescape(dc.substring(begin + prefix.length, end));
}
function deleteCookie(name, path, domain) 
{
	if (getCookie(name)) {
    	document.cookie = name + "=" + ((path) ? "; path=" + path : "") + ((domain) ? "; domain=" + domain : "") + "; expires=Thu, 01-Jan-70 00:00:01 GMT";
  	}
}
// class to add persistance to variables
function SessionVar(name,default_val)
{	
	this.name = name;
	this.val = getCookie(this.name) ? getCookie(this.name):default_val;
	this.set=function(val){
		this.val = val;
		setCookie(this.name,this.val,null,"/");
	};
	this.get=function(){
		return this.val; 
	};
	this.geti=function(){
		return parseInt(this.val);
	};
}

function parseResponse(data)
{
    var assocArray = new Array();
    var pieces = data.split("&");
    
    for(var x=0;x<pieces.length;x++){
      var subpieces = pieces[x].split("=");
      if(subpieces[0] && subpieces[1]){
        assocArray[subpieces[0]] = subpieces[1];
      }
    }
	return assocArray;
}

function $() 
{
	var elements = new Array();
	for (var i = 0; i < arguments.length; i++) {
		var element = arguments[i];
		if (typeof element == 'string')
			element = document.getElementById(element);
		if (arguments.length == 1)
			return element;
		elements.push(element);
	}
	return elements;
}

function catchKey(event,func,pattern)
{
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	if(keyCode == 0 || keyCode == 8 || keyCode == 37 || keyCode == 39 || keyCode == 9)
		return true;

	if(func && keyCode == 13){
		func();
		return false;	
	}
	var testStr = String.fromCharCode(keyCode);

	if(pattern && testStr.match(pattern) == null){
		return false;
	}	
	return true;
}

function exists(var_)
{
	if(window[var_] != undefined)
		return true;
	else
		return false;
}

function loadXML(url,callback,async)
{
	var xmlhttp=null;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	
	}else if (window.ActiveXObject){
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	if (xmlhttp!=null){
		if(async)
			xmlhttp.onreadystatechange=stateChange;
		xmlhttp.open("GET",url,async);
		xmlhttp.send(null);
		if(!async){
			if (xmlhttp.status==200){
				callback(xmlhttp.responseXML);
			}else{
				alert("Problem retrieving XML data:" + xmlhttp.statusText);
			}
		}
	}else{
		alert("Your browser does not support XMLHTTP");
	}
	
	function stateChange()
	{
		if (xmlhttp.readyState==4){
			if (xmlhttp.status==200){
				callback(xmlhttp.responseXML);
			}else{
				alert("Problem retrieving XML data:" + xmlhttp.statusText);
			}
		}
	}	
}

function getXMLvalue(xml_doc, tagName, attribute)
{
	var xmlObj = xml_doc.documentElement;
	var nodeCnt = xmlObj.childNodes.length;
	for(var x=0; x< nodeCnt; x++){
		if(xmlObj.childNodes[x].tagName == tagName){
			return xmlObj.childNodes[x].getAttribute(attribute);
		}	
	}
}

function getXMLObj(xml_doc)
{
	var xmlDocObj = xml_doc.documentElement;		
	var nodeCnt = xmlDocObj.childNodes.length;
	var obj = {};

	for(var x=0; x< nodeCnt; x++){
		try{obj[xmlDocObj.childNodes[x].tagName] = xmlDocObj.childNodes[x].getAttribute("value");}catch(e){}
	}
	return obj;
}

function getStyle(el, style)
{
	var retValue = 0;
	var windowRef = arguments[2] ? arguments[2] : window;//catch parent overload
	try{		
		if(windowRef.document.defaultView && windowRef.document.defaultView.getComputedStyle){
			retValue = windowRef.document.defaultView.getComputedStyle(windowRef.document.getElementById(el), "").getPropertyValue(style);
		}else if(windowRef.document.getElementById(el).currentStyle){
			style = style.replace(/\-(\w)/g, function (str, p1){return p1.toUpperCase();});
			retValue = windowRef.document.getElementById(el).currentStyle[style];
		}
	}catch(e){}
	
	return retValue;
}

function getPaddingBorderMargin(cssName,direction)
{
	var parentRef = null;
	if(arguments[2]){//check for parent overload
		parentRef = arguments[2];		
	}
	
	var returnValue = 0;
	var styles;
	
	if(direction == "w"){//width direction
		styles = Array("margin-left","border-left-width","padding-left","padding-right","border-right-width","margin-right");
	}else{//height direction
		styles = Array("margin-top","border-top-width","padding-top","padding-bottom","border-bottom-width","margin-bottom");
	}
	
	for(var x=0; x<styles.length;x++){ 
		if(!parentRef){
			if((val = parseInt(getStyle(cssName,styles[x]))) > 0)
				returnValue += val;
		}else{
			if((val = parseInt(getStyle(cssName,styles[x],parentRef))) > 0)
				returnValue += val;
		}
	}		
	return returnValue;
}
