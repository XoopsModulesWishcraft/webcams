<?php
	
	include ('../../mainfile.php');
	
	$op = (!empty($_REQUEST['op']))?$_REQUEST['op']:'camlist';
	switch ($op){
		default:
		case 'index':
			$xoopsOption['template_main'] = 'webcams_index.html';
			include ('../../header.php');
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/common.js', array('type'=>'text/javascript'));
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/Silverlight.js', array('type'=>'text/javascript'));
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/index.js', array('type'=>'text/javascript'));
			$GLOBALS['xoopsTpl']->assign('xoConfig',$GLOBALS['xoopsModuleConfig']);
			include ('../../footer.php');
			break;
		case 'example':
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
			$xoopsOption['template_main'] = 'webcams_camlist.html';
			include ('../../header.php');
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/common.js', array('type'=>'text/javascript'));
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/themes.js', array('type'=>'text/javascript'));
			$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/webcams/js/camlist.js', array('type'=>'text/javascript'));
			$GLOBALS['xoopsTpl']->assign('xoConfig',$GLOBALS['xoopsModuleConfig']);
			include ('../../footer.php');
			break;
		case 'biopics':
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