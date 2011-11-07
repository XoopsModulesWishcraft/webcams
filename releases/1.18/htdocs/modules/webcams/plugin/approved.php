<?php

	function ApprovedHostHook($host) {
		xoops_load('xoopsmailer');
		xoops_loadLanguage('main','webcams');
		
		$xoopsMailer =& getMailer();
		//$xoopsMailer->setHTML(true);
		$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/webcams/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
		$xoopsMailer->setTemplate('webcams_host_approved.tpl');
		$xoopsMailer->setSubject(_wbc_email_host_subject_approved);
		
		$xoopsMailer->setToEmails($host->getVar('email'));
		$xoopsMailer->setToEmails($GLOBALS['xoopsConfig']['adminemail']);
		
		$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $host);
				
		if (!$xoopsMailer->send())
			return false;
		else 
			return true;
	}
	
	function ApprovedStudioHook($studio) {

		xoops_load('xoopsmailer');
		xoops_loadLanguage('main','webcams');
		
		$xoopsMailer =& getMailer();
		//$xoopsMailer->setHTML(true);
		$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/webcams/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
		$xoopsMailer->setTemplate('webcams_studio_approved.tpl');
		$xoopsMailer->setSubject(_wbc_email_studio_subject_approved);
		
		$xoopsMailer->setToEmails($host->getVar('email'));
		$xoopsMailer->setToEmails($GLOBALS['xoopsConfig']['adminemail']);
		
		$xoopsMailer = setEmailXpaymentTags($xoopsMailer, $studio);
				
		if (!$xoopsMailer->send())
			return false;
		else 
			return true;
	}
		
	if (!function_exists('setEmailXpaymentTags')) {
		function setEmailXpaymentTags($xoopsMailer, $object) {
			
			$xoopsMailer->assign("SITEURL", XOOPS_URL);
			$xoopsMailer->assign("SITENAME", $GLOBALS['xoopsConfig']['sitename']);
			$xoopsMailer->assign("SITEEMAIL", $GLOBALS['xoopsConfig']['adminemail']);
			$xoopsMailer->assign('GATEWAY_IP', $GLOBALS['xoopsModuleConfig']['gateway_ip']);
			$xoopsMailer->assign('ACCOUNT_ID', $GLOBALS['xoopsModuleConfig']['account_id']);
			
			foreach($object->toArray() as $key => $value)
				$xoopsMailer->assign("OBJ_".strtoupper($key), $value);
			
			$user_handler =& xoops_gethandler('user');
			$module_handler =& xoops_gethandler('module');
						
			$profile = $module_handler->getByDirname('profile');
			if (is_object($profile))
				$profile_handler =& xoops_getmodulehandler('profile', 'profile');
		
			if (is_object($GLOBALS['xoopsUser'])) {
				$i++;
				foreach($GLOBALS['xoopsUser']->toArray() as $key=>$value)
					$xoopsMailer->assign("USER_".strtoupper($key), $value);
				
				if (is_object($profile)) {
					$userprofile = $profile_handler->get($GLOBALS['xoopsUser']->getVar('uid'));
					if (is_object($userprofile)) {	
						foreach($userprofile->toArray() as $key=>$value)
							$xoopsMailer->assign("USER_".strtoupper($key), $value);
					}	
				}		
			}
				
			return $xoopsMailer;
		}
	}
?>