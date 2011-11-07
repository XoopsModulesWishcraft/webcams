<?php

	
	require('../../../mainfile.php');
	require('../../../include/cp_header.php');
	require_once $GLOBALS['xoops']->path('/modules/webcams/include/forms.php');
	
	xoops_load('pagenav');	
	xoops_load('xoopsmailer');
	
	$myts = MyTextSanitizer::getInstance();
	
	$op = (!empty($_REQUEST['op'])?$_REQUEST['op']:'list');
	$fct = (!empty($_REQUEST['fct'])?$_REQUEST['fct']:'host');
?>