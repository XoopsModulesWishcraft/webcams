<?php
include('../../mainfile.php');
include('include/forms.php');
include('include/functions.php');

if (!is_object($GLOBALS['xoopsUser'])) {
	redirect_header('index.php', 10, _NOPERM);
	exit();
}

$pivot_handler =& xoops_getmodulehandler('pivot', 'webcams');
$criteria = $pivot_handler->getPivotCriteria();
$criteria->add(new Criteria('`type`', $_REQUEST['op']));
$criteria->add(new Criteria('`id`', $_REQUEST['id']));

if ($pivot_handler->getCount($criteria)==0) {
	redirect_header('index.php', 10, _NOPERM);
	exit();
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
		if ($_REQUEST['id']!=0)
			$object = $handler->get($_REQUEST['id']);
		else { 
			$object = $handler->create();
			$object->setVars($GLOBALS['xoopsModuleConfig']);
		}
		$object->setVars($_POST);
		if (!$handler->insert($object, true))
			redirect_header('edit.php?op='.$_REQUEST['fct'].'&id='.$_REQUEST['id'], 10 , $object->getHtmlErrors());
		else 
			redirect_header('index.php', 10 , _wbc_mn_msg_createdokey);
		break;
}
	
?>