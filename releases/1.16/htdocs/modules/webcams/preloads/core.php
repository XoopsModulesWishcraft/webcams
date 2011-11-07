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
 * @version         $Id$
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
    function eventCoreIncludeCommonStart($args)
    {

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