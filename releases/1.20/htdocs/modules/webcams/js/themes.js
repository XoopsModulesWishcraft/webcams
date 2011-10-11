var sessionTheme = new SessionVar("sessionTheme","");

function loadTheme()
{
	if(!sessionTheme.get()){ 
		loadXML("config/configuration.xml",themeCallBack,false);//non-async as we need this before going any further
	}else{
		document.write('<link href="themes/'+ sessionTheme.get() +'/'+ sessionTheme.get() +'.css" rel="stylesheet" type="text/css">');
	}
	
	function themeCallBack(xmlDoc)
	{
		var theme = getXMLvalue(xmlDoc,"theme","value");	
		if(!theme)
			theme = "default";
		sessionTheme.set(theme);
		document.write('<link href="themes/'+ theme +'/'+ theme +'.css" rel="stylesheet" type="text/css">');
	}		
}
loadTheme();