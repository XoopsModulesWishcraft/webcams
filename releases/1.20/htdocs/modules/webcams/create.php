<?php
include('../../mainfile.php');
include('include/forms.php');
include('include/functions.php');
	
if (is_object($GLOBALS['xoopsUser']))
	$groups = $GLOBALS['xoopsUser']->getGroups();
else 
	$groups = XOOPS_GROUP_ANONYMOUS;
$groupperm_handler = xoops_gethandler('groupperm');

//Menu
switch($_REQUEST['op']){
case 'host':
	if (!$groupperm_handler->checkRight(_wbc_mi_perm_access_name, _wbc_mi_perm_host, $groups, $GLOBALS['xoopsModule']->getVar('mid'))) {
		redirect_header('index.php', 10, _NOPERM);
		exit(0);
	}
	break;
default:
case 'user':
	if (!$groupperm_handler->checkRight(_wbc_mi_perm_access_name, _wbc_mi_perm_user, $groups, $GLOBALS['xoopsModule']->getVar('mid'))) {
		redirect_header('index.php', 10, _NOPERM);
		exit(0);
	}
	break;
//case 'studio';
//if (!$groupperm_handler->checkRight(_wbc_mi_perm_access_name, _wbc_mi_perm_studio, $groups, $GLOBALS['xoopsModule']->getVar('mid'))) {
//	redirect_header('index.php', 10, _NOPERM);
//	exit(0);
//}
//break;
}


switch ($_REQUEST['op'])
{
	case 'host':
		$xoopsOption['template_main'] = 'webcams_create_host.html';
		include('../../header.php');
		$GLOBALS['xoopsTpl']->assign('form', webcams_user_host_edit($_REQUEST['id']));
		$GLOBALS['xoopsTpl']->assign('id', $_REQUEST['id']);
		include('../../footer.php');
		break;
//	case 'studio':
//		$xoopsOption['template_main'] = 'webcams_create_studio.html';
//		include('../../header.php');
//		$GLOBALS['xoopsTpl']->assign('form', webcams_user_studio_edit($_REQUEST['id']));
//		$GLOBALS['xoopsTpl']->assign('id', $_REQUEST['id']);
//		include('../../footer.php');
//		break;
	default:
	case 'user':
		$xoopsOption['template_main'] = 'webcams_create_user.html';
		include('../../header.php');
		$GLOBALS['xoopsTpl']->assign('form', webcams_user_user_edit($_REQUEST['id']));
		$GLOBALS['xoopsTpl']->assign('id', $_REQUEST['id']);
		include('../../footer.php');
		break;
	case 'save':
		$handler =& xoops_getmodulehandler($_REQUEST['fct'], 'webcams');
		$object = $handler->create();
		$object->setVars($GLOBALS['xoopsModuleConfig']);
		$object->setVars($_POST);
		if (!$handler->insert($object, true))
			redirect_header('create.php?op='.$_REQUEST['fct'], 10 , $object->getHtmlErrors());
		else {
			xoops_load('xoopsmailer');
			xoops_loadLanguage('main','xpayment');
			
			switch($_REQUEST['fct']) {
			case 'host':
				$xoopsMailer =& getMailer();
				$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/webcams/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
				$xoopsMailer->setTemplate('webcams_host.tpl');
				$xoopsMailer->setSubject(_wbc_email_host_subject, $object->getVar('user'), $GLOBALS['xoopsConfig']['sitename']);
				$xoopsMailer->setToEmails($GLOBALS['xoopsUser']->getVar('email'));
				$xoopsMailer->setToEmails($GLOBALS['xoopsConfig']['siteemail']);
				$xoopsMailer->assign('GATEWAY_IP', $GLOBALS['xoopsModuleConfig']['gateway_ip']);
				$xoopsMailer->assign('ACCOUNT_ID', $GLOBALS['xoopsModuleConfig']['account_id']);
				$xoopsMailer->assign('USERNAME', $object->getVar('user'));
				$xoopsMailer->assign('PASSWORD', $object->getVar('pass'));
				$xoopsMailer->assign('X_SITENAME', $GLOBALS['xoopsConfig']['sitename']);
				$xoopsMailer->assign('X_SITEURL', XOOPS_URL);			
				@$xoopsMailer->send();
				break;
			}
			redirect_header('index.php', 10 , _wbc_mn_msg_createdokey);
		}
		break;
}
	
?>