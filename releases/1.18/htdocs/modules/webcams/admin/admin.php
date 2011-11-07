<?php
	
	include('header.php');
	error_reporting(E_ALL);  
	
	include_once $GLOBALS['xoops']->path( "/class/template.php" );
	$GLOBALS['wbcTpl'] = new XoopsTpl();
	$GLOBALS['wbcTpl']->assign('php_self', $_SERVER['PHP_SELF']);
	
	xoops_cp_header();
	xoops_loadLanguage('admin', 'webcams');
	
	switch($op) {
	case "permissions":
		$module_id = $GLOBALS['xoopsModule']->getVar('mid');
		include_once $GLOBALS['xoops']->path( '/class/xoopsform/grouppermform.php' );
		$form = new XoopsGroupPermForm(_wbc_am_perm_access_title, $module_id, _wbc_am_perm_access_name, _wbc_am_perm_access_desc, 'admin/admin.php', true);

        $form->addItem(_wbc_mi_perm_host, _wbc_am_perm_host);
        //$form->addItem(_wbc_mi_perm_studio, _wbc_am_perm_studio);
        $form->addItem(_wbc_mi_perm_user, _wbc_am_perm_user);

        echo $form->render();
        break;
    case "delete":	
		$handler =& xoops_getmodulehandler($fct, 'webcams');
		if ($handler->delete($_REQUEST['id'])) {
			redirect_header($_SERVER['PHP_SELF'].'?op=edit&fct='.$fct.'&id='.$_REQUEST['id'], 10, _wbc_am_msg_deleteok);
		} else {
			redirect_header($_SERVER['PHP_SELF'].'?op=edit&fct='.$fct.'&id='.$_REQUEST['id'], 10, _wbc_am_msg_apierror);
		}
		break;
	case "create":	
		switch ($fct)
		{
			case 'host':
				$GLOBALS['wbcTpl']->assign('form', webcams_admin_host_edit(0));
				$GLOBALS['wbcTpl']->assign('id', 0);
				$GLOBALS['wbcTpl']->display('db:webcams_cpanel_create_host.html');
				break;
			case 'studio':
				$GLOBALS['wbcTpl']->assign('form', webcams_admin_studio_edit(0));
				$GLOBALS['wbcTpl']->assign('id', 0);
				$GLOBALS['wbcTpl']->display('db:webcams_cpanel_create_studio.html');
				break;
			case 'user':
				$GLOBALS['wbcTpl']->assign('form', webcams_admin_user_edit(0));
				$GLOBALS['wbcTpl']->assign('id', 0);
				$GLOBALS['wbcTpl']->display('db:webcams_cpanel_create_user.html');
				break;
		}
		
		break;	
	case "edit":	
	
		switch ($fct)
		{
			case 'host':
				$GLOBALS['wbcTpl']->assign('form', webcams_admin_host_edit($_REQUEST['id']));
				$GLOBALS['wbcTpl']->assign('id', $_REQUEST['id']);
				$GLOBALS['wbcTpl']->display('db:webcams_cpanel_create_host.html');
				break;
			case 'studio':
				$GLOBALS['wbcTpl']->assign('form', webcams_admin_studio_edit($_REQUEST['id']));
				$GLOBALS['wbcTpl']->assign('id', $_REQUEST['id']);
				$GLOBALS['wbcTpl']->display('db:webcams_cpanel_create_studio.html');
				break;
			case 'user':
				$GLOBALS['wbcTpl']->assign('form', webcams_admin_user_edit($_REQUEST['id']));
				$GLOBALS['wbcTpl']->assign('id', $_REQUEST['id']);
				$GLOBALS['wbcTpl']->display('db:webcams_cpanel_create_user.html');
				break;		
		}	
		break;	
	case 'approve':
		$handler =& xoops_getmodulehandler($fct, 'webcams');
		$object = $handler->get($_REQUEST['id']);
		$object->setVar('status', 'approved');
		if ($handler->insert($object)) {
			redirect_header($_SERVER['PHP_SELF'].'?op=edit&fct='.$fct.'&id='.$_REQUEST['id'], 10, _wbc_am_msg_approved);
		} else {
			redirect_header($_SERVER['PHP_SELF'].'?op=edit&fct='.$fct.'&id='.$_REQUEST['id'], 10, _wbc_am_msg_apierror);
		}
		exit(0);
		break;

	case 'save':
		$handler =& xoops_getmodulehandler($fct, 'webcams');
		if ($_REQUEST['id']!=0)
			$object = $handler->get($_REQUEST['id']);
		else { 
			$object = $handler->create();
			$object->setVars($GLOBALS['xoopsModuleConfig']);
		}
		$object->setVars($_POST[$_POST['id']]);
		if ($handler->insert($object)) {
			redirect_header($_SERVER['PHP_SELF'].'?op=edit&fct='.$fct.'&id='.$_REQUEST['id'], 10, _wbc_am_msg_saveokey);
		} else {
			redirect_header($_SERVER['PHP_SELF'].'?op=edit&fct='.$fct.'&id='.$_REQUEST['id'], 10, _wbc_am_msg_apierror);
		}
		exit(0);
		break;
	default:		
	case 'list':

		$handler =& xoops_getmodulehandler($fct, 'webcams');
		$ttl = $handler->getCount(NULL);
		$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
		$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
		$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
		$sort = !empty($_REQUEST['sort'])?$_REQUEST['sort']:'name';
		
		$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct);
		$GLOBALS['wbcTpl']->assign('pagenav', $pagenav->renderNav());

		foreach (array(	'userid','studioname','hostid','firstname', 'lastname', 'postcode', 'country', 'email', 'phone') as $id => $key) {
			$GLOBALS['wbcTpl']->assign(strtolower($key.'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='ASC'?'DESC':'ASC'):$order).'&op='.$op.'&fct='.$fct.'">'.constant('_wcb_am_th_'.strtolower($key)).'</a>');
		}
		
		$criteria = new Criteria('1','1');
		$criteria->setStart($start);
		$criteria->setLimit($limit);
		$criteria->setSort($sort);
		$criteria->setOrder($order);
		
		$objects = $handler->getObjects($criteria, true);
		foreach($objects as $id => $object) {
			$GLOBALS['wbcTpl']->append($fct.'s', $object->toArray());
		}
		switch ($fct)
		{
			case 'host':
				$GLOBALS['wbcTpl']->display('db:webcams_cpanel_hosts.html');
				break;
			case 'studio':
				$GLOBALS['wbcTpl']->display('db:webcams_cpanel_studios.html');
				break;
			case 'user':
				$GLOBALS['wbcTpl']->display('db:webcams_cpanel_users.html');
				break;
				
		}
		break;
		
	}
	
	xoops_cp_footer();
?>