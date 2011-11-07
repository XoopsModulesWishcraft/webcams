<?php
	
	include ('../../mainfile.php');
	
	$op = (!empty($_REQUEST['op']))?$_REQUEST['op']:'camlist';
	switch ($op){
		case 'show':
			if ($_REQUEST['token']!=md5(XOOPS_LICENSE_KEY.date('Ymdh'))&&$_REQUEST['token']!=md5(XOOPS_LICENSE_KEY.date('Ymdh', time()-3600))) {
				redirect_header(XOOPS_URL, 10, _NOPERM);
				exit;
			}
			$url = XOOPS_URL."/".$GLOBALS['xoopsModuleConfig']['baseofurl']."/index,".$op.",".$_REQUEST['hostname'].",".$_REQUEST['token'].$GLOBALS['xoopsModuleConfig']['endofurl'];
			if (!strpos($url, $_SERVER['REQUEST_URI'])&&$GLOBALS['xoopsModuleConfig']['htaccess']) {
				header( "HTTP/1.1 301 Moved Permanently" ); 
				header( "Location: ".$url);
				exit;
			}
			include ('../../header.php');
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/common.js', array('type'=>'text/javascript'));
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/themes.js', array('type'=>'text/javascript'));
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/camlist.js', array('type'=>'text/javascript'));
			$GLOBALS['xoopsTpl']->assign('xoConfig',$GLOBALS['xoopsModuleConfig']);
			$GLOBALS['xoTheme']->addScript('', array('type'=>'text/javascript'), 'openVideoChat(2,'.$_REQUEST['hostname'].');');
			include ('../../footer.php');
			break;
		default:
		case 'index':
			$url = XOOPS_URL."/".$GLOBALS['xoopsModuleConfig']['baseofurl']."/index,".$op.$GLOBALS['xoopsModuleConfig']['endofurl'];
			if (!strpos($url, $_SERVER['REQUEST_URI'])&&$GLOBALS['xoopsModuleConfig']['htaccess']) {
				header( "HTTP/1.1 301 Moved Permanently" ); 
				header( "Location: ".$url);
				exit;
			}
			$xoopsOption['template_main'] = 'webcams_index.html';
			include ('../../header.php');
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/common.js', array('type'=>'text/javascript'));
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/Silverlight.js', array('type'=>'text/javascript'));
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/index.js', array('type'=>'text/javascript'));
			$GLOBALS['xoopsTpl']->assign('xoConfig',$GLOBALS['xoopsModuleConfig']);
			include ('../../footer.php');
			break;
		case 'example':
			$url = XOOPS_URL."/".$GLOBALS['xoopsModuleConfig']['baseofurl']."/index,".$op.$GLOBALS['xoopsModuleConfig']['endofurl'];
			if (!strpos($url, $_SERVER['REQUEST_URI'])&&$GLOBALS['xoopsModuleConfig']['htaccess']) {
				header( "HTTP/1.1 301 Moved Permanently" ); 
				header( "Location: ".$url);
				exit;
			}
			$xoopsOption['template_main'] = 'webcams_example.html';
			include ('../../header.php');
			$GLOBALS['xoopsTpl']->assign('xoConfig',$GLOBALS['xoopsModuleConfig']);
			include ('../../footer.php');
			break;
		case 'videochat':
			include_once XOOPS_ROOT_PATH.'/class/template.php';
			$GLOBALS['xoopsTpl'] = new XoopsTpl();
			$GLOBALS['xoopsTpl']->assign('xoConfig',$GLOBALS['xoopsModuleConfig']);
			echo $GLOBALS['xoopsTpl']->display('db:webcams_videochat.html');
			break;
		case 'camlist':
			$url = XOOPS_URL."/".$GLOBALS['xoopsModuleConfig']['baseofurl']."/index,".$op.$GLOBALS['xoopsModuleConfig']['endofurl'];
			if (!strpos($url, $_SERVER['REQUEST_URI'])&&$GLOBALS['xoopsModuleConfig']['htaccess']) {
				header( "HTTP/1.1 301 Moved Permanently" ); 
				header( "Location: ".$url);
				exit;
			}
			$xoopsOption['template_main'] = 'webcams_camlist.html';
			include ('../../header.php');
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/common.js', array('type'=>'text/javascript'));
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/themes.js', array('type'=>'text/javascript'));
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/camlist.js', array('type'=>'text/javascript'));
			$GLOBALS['xoopsTpl']->assign('xoConfig',$GLOBALS['xoopsModuleConfig']);
			include ('../../footer.php');
			break;
		case 'biopics':
			$url = XOOPS_URL."/".$GLOBALS['xoopsModuleConfig']['baseofurl']."/index,".$op.$GLOBALS['xoopsModuleConfig']['endofurl'];
			if (!strpos($url, $_SERVER['REQUEST_URI'])&&$GLOBALS['xoopsModuleConfig']['htaccess']) {
				header( "HTTP/1.1 301 Moved Permanently" ); 
				header( "Location: ".$url);
				exit;
			}
			$xoopsOption['template_main'] = 'webcams_biopics.html';
			include ('../../header.php');
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/common.js', array('type'=>'text/javascript'));
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/themes.js', array('type'=>'text/javascript'));
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/biopics.js', array('type'=>'text/javascript'));
			$GLOBALS['xoopsTpl']->assign('xoConfig',$GLOBALS['xoopsModuleConfig']);
			include ('../../footer.php');
			break;
			
	}
	
?>