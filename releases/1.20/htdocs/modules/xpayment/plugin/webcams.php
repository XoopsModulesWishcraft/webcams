<?php

	
	function PaidWebcamsHook($invoice) {

		include_once $GLOBALS['xoops']->path('/modules/webcams/class/global.php');

		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$xoMod = $module_handler->getByDirname('webcams');
		$xoConfig = $config_handler->getConfigList($xoMod->getVar('mid'));
		
		$params = '&action=user_update';
		$params .= '&account_id='.$xoConfig['account_id'];
		$params .= '&gateway_pass='.$xoConfig['gateway_pass'];
		$params .= '&user_id='.$invoice->getVar('key');
		
		// optional data
		$params .= '&add_amount='.$invoice->getVar('grand')+$invoice->getVar('discount_amount');
		
		$result = sendPost($xoConfig['gateway_ip'],$params,true);		//use ssl	
		
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');		
		return PaidXPaymentHook($invoice);
	
	}
	
	function UnpaidWebcamsHook($invoice) {
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');
		return UnpaidXPaymentHook($invoice);		
	}
	
	function CancelWebcamsHook($invoice) {
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');
		return CancelXPaymentHook($invoice);
	}
	
?>