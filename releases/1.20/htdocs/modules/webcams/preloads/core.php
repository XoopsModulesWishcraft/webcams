<?php
/**
 * Webcams
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Webcams
 * @since           2.4.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: core.php 3333 2009-08-27 10:46:15Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * Webcams core preloads
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author          trabis <lusopoemas@gmail.com>
 */
class WebcamsCorePreload extends XoopsPreloadItem
{
    function eventCoreIncludeCommonEnd($args)
    {
    	if (WebcamsCorePreload::isActive()) {
    		if (is_object($GLOBALS['xoopsUser'])) {
    			$pivot_handler =& xoops_getmodulehandler('pivot', 'webcams');
    			$sexy_profile_handler =& xoops_getmodulehandler('profile', 'sexy');
				$pivot = $pivot_handler->getObjects($pivot_handler->getPivotCriteria(), false);
				if (is_object($pivot[0])) {
					switch ($pivot[0]->getVar('type')) {
						case 'host':
							$criteria = new Criteria('uid', $GLOBALS['xoopsUser']->getVar('uid'));
							if ($sexy_profile_handler->getCount($criteria)==0) {
								$host_handler = xoops_getmodulehandler('host', 'webcams');
								$criteria = new Criteria('user', $GLOBALS['xoopsUser']->getVar('uname'));
								$hosts = $host_handler->getObjects($criteria, false);
								if (is_object($hosts[0])) {
									if (!strpos($_SERVER['PHP_SELF'], 'create.php')) {
										$_SESSION['host_id'] = $hosts[0]->getVar('host_id');
										xoops_loadLanguage('main', 'sexy');
										redirect_header(XOOPS_URL.'/modules/sexy/create.php?op=profile&host_id='.$hosts[0]->getVar('host_id'), 9, _SXY_MSG_CREATEPROFILE);
									}
								}
							}
					}
				} else {
		        	$module_handler =& xoops_gethandler( 'module' );
					$config_handler =& xoops_gethandler( 'config' );
					$xoModule =& $module_handler->getByDirname('webcams');
					$xoModuleConfig = $config_handler->getConfigList($xoModule->getVar('mid')); 
					$profile_handler =& xoops_getmodulehandler('profile', 'profile');
					$profile = $profile_handler->get($GLOBALS['xoopsUser']->getVar('uid'));
					if (is_object($profile)&&!$GLOBALS['xoopsUser']->isAdmin()) {
						switch($profile->getVar($xoModuleConfig['profile_field'])) {
							case $xoModuleConfig['profile_host_value']:
								$members_handler = xoops_gethandler('member');
								$members_handler->addUserToGroup($xoModuleConfig['profile_host_group'], $GLOBALS['xoopsUser']->getVar('uid'));
								if ($xoModuleConfig['support_sexy']) {
									$host_handler = xoops_getmodulehandler('host', 'webcams');
									$host = $host_handler->create();
									$host->setVar('user', $GLOBALS['xoopsUser']->getVar('uname'));
									$host->setVar('pass', substr($GLOBALS['xoopsUser']->getVar('pass'),0,20));
									$host->setVars($xoModuleConfig);
									$host->setVars($profile->toArray());
									$host_id = $host_handler->insert($host, true);
									if (!strpos($_SERVER['PHP_SELF'], 'create.php')) {
										$criteria = new Criteria('user', $GLOBALS['xoopsUser']->getVar('uname'));
										$hosts = $host_handler->getObjects($criteria, false);
										if (is_object($hosts[0])) {
											$_SESSION['host_id'] = $hosts[0]->getVar('host_id');
											xoops_loadLanguage('main', 'sexy');
											redirect_header(XOOPS_URL.'/modules/sexy/create.php?op=profile&host_id='.$hosts[0]->getVar('host_id'), 9, _SXY_MSG_CREATEPROFILE);
										} else {
											
										}
										exit(0);
									}
								}
								break;
							case $xoModuleConfig['profile_punter_value']:
								$members_handler = xoops_gethandler('member');
								$members_handler->addUserToGroup($xoModuleConfig['profile_punter_group'], $GLOBALS['xoopsUser']->getVar('uid'));
								if ($xoModuleConfig['support_sexy']) {
									$user_handler = xoops_getmodulehandler('user', 'webcams');
									$user = $user_handler->create();
									$user->setVar('user', $GLOBALS['xoopsUser']->getVar('uname'));
									$user->setVar('pass', substr($GLOBALS['xoopsUser']->getVar('pass'),0,20));
									$user->setVars($profile->toArray());
									$user_handler->insert($user, true);
									xoops_loadLanguage('main', 'sexy');
									redirect_header(XOOPS_URL.'', 9, _SXY_MSG_CLIENTACCOUNTCREATED);
								}
								break;
							default:
						}
					}
				}
    		}
    	}
    }

    function eventCoreIncludeCommonLanguage($args)
    {
        if (WebcamsCorePreload::isActive()) {
        	$module_handler =& xoops_gethandler( 'module' );
			$config_handler =& xoops_gethandler( 'config' );
			$xoModule =& $module_handler->getByDirname('webcams');
			$xoModuleConfig = $config_handler->getConfigsByCat(0, $xoModule->getVar('mid')); 
			
			setcookie('account_id', $xoModuleConfig['account_id'], time()+3600*24*(2), '/');
			setcookie('gateway_ip', $xoModuleConfig['gateway_ip'], time()+3600*24*(2), '/');
			setcookie('sessionTheme', $xoModuleConfig['theme'], time()+3600*24*(2), '/');
			//setcookie('host_name', $_SERVER['HTTP_HOST'], time()+3600*24*(2), '/');
			setcookie('modulePath', XOOPS_URL.'/modules/webcams/', time()+3600*24*(2), '/');
			
			$pivot_handler =& xoops_getmodulehandler('pivot', 'webcams');
			$pivot = $pivot_handler->getObjects($pivot_handler->getPivotCriteria(), false);
			
			if (is_object($pivot[0])) {
				$handler = xoops_getmodulehandler($pivot[0]->getVar('type'), 'webcams');
				$object = $handler->get($pivot[0]->getVar('id')); 	
				setcookie('member_user', $object->getVar('user'), time()+3600*24*(2), '/');
				setcookie('member_pass', $object->getVar('pass'), time()+3600*24*(2), '/');		
			} elseif (empty($_COOKIE['member_user'])) {
				setcookie('member_user', 'guest'.mt_rand(1,65335), time()+3600*24*(2), '/');
				setcookie('member_pass', 'guestpass', time()+3600*24*(2), '/');
			}
        }
    }

    function isActive()
    {
        $module_handler =& xoops_getHandler('module');
        $module = $module_handler->getByDirname('webcams');
        return ($module && $module->getVar('isactive')) ? true : false;
    }

}
?>