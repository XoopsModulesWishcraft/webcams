<?php

error_reporting(E_ALL);
$modversion['name'] = _wbc_mi_name;
$modversion['version'] = 1.20;
$modversion['description'] = _wbc_mi_desc;
$modversion['credits'] = "David Matthews from iStreaming - http://www.istreaming.com/";
$modversion['author'] = "Simon Roberts (wishcraft)";
$modversion['license'] = "GNU General Public License (GPL) see LICENSE";
$modversion['image'] = "images/webcams_slogo.png";
$modversion['dirname'] = "webcams";
$modversion['releasedate'] = "Mon: 26 September 2011";
$modversion['status'] = "Stable";

$modversion['author_realname'] = "Simon A. Roberts";
$modversion['author_website_url'] = "http://www.chronolabs.coop";
$modversion['author_website_name'] = "Chronolabs";
$modversion['author_email'] = "simon@chronolabs.coop";
$modversion['status_version'] = "1.13";

$modversion['warning'] = "For XOOPS 2.4, 2.5 & 3.0";

// Sql file
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = "webcams_host";
$modversion['tables'][1] = "webcams_user";
$modversion['tables'][2] = "webcams_studio";
$modversion['tables'][3] = "webcams_pivot";

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/admin.php";
$modversion['adminmenu'] = "admin/menu.php";

// Install, Upgrade & Uninstall
//$modversion['onInstall'] = "include/install.php";
//$modversion['onUninstall'] = "include/uninstall.php";
//$modversion['onUpdate'] = "include/update.php";

// Menu
$modversion['hasMain'] = 1;

if (is_object($GLOBALS['xoopsUser']))
	$groups = $GLOBALS['xoopsUser']->getGroups();
else 
	$groups = XOOPS_GROUP_ANONYMOUS;
$groupperm_handler = xoops_gethandler('groupperm');

$module_handler =& xoops_gethandler('module');
$xoMod = $module_handler->getByDirname('webcams');
	
$pivot_handler =& xoops_getmodulehandler('pivot', 'webcams');
$i=1;
if ($pivot_handler->getCount($pivot_handler->getPivotCriteria())==0) {
		
	//Menu
	$modversion['sub'][$i]['name'] = _wbc_mi_camlist;
	$modversion['sub'][$i]['url'] = "index.php?op=camlist";
	$i++;
	
	/*if (is_object($xoMod))
		if ($groupperm_handler->checkRight(_wbc_mi_perm_access_name, _wbc_mi_perm_host, $groups, $xoMod->getVar('mid'))) {
			$modversion['sub'][$i]['name'] = _wbc_mi_makehost;
			$modversion['sub'][$i]['url'] = "create.php?op=host";
			$i++;
		}
	if (is_object($xoMod))
		if ($groupperm_handler->checkRight(_wbc_mi_perm_access_name, _wbc_mi_perm_user, $groups, $xoMod->getVar('mid'))) {
			$modversion['sub'][$i]['name'] = _wbc_mi_makeuser;
			$modversion['sub'][$i]['url'] = "create.php?op=user";
			$i++;
		}*/
	//if ($groupperm_handler->checkRight(_wbc_mi_perm_access_name, _wbc_mi_perm_studio, $groups, $xoMod->getVar('mid'))) {
	//	$modversion['sub'][$i]['name'] = _wbc_mi_makestudio;
	//	$modversion['sub'][$i]['url'] = "create.php?op=studio";
	//	$i++;
	//}
} else {
	
	$pivot = $pivot_handler->getObjects($pivot_handler->getPivotCriteria(), false);
	if (is_object($GLOBALS['xoopsUser'])) {
		$modversion['sub'][$i]['name'] = _wbc_mi_editmysettings;
		$modversion['sub'][$i]['url'] = "edit.php?op=".$pivot[0]->getVar('type')."&id=".$pivot[0]->getVar('id');
		$i++;
	}
	$modversion['sub'][$i]['name'] = _wbc_mi_camlist;
	$modversion['sub'][$i]['url'] = "index.php?op=camlist";
	$i++;

	switch($pivot[0]->getVar('type')) {
		case "host":		
			break;
		case "user":
			break;
//		case 'studio':
//			if ($groupperm_handler->checkRight(_wbc_mi_perm_access_name, _wbc_mi_perm_host, $groups, $xoMod->getVar('mid'))) {
//				$modversion['sub'][$i]['name'] = _wbc_mi_makehost;
//				$modversion['sub'][$i]['url'] = "create.php?op=host";
//				$i++;
//			}
//			break;
	}
}

$i=0;
$modversion['blocks'][$i]['file'] = "webcams_xpayment.php";
$modversion['blocks'][$i]['name'] = 'Purchase more Cam Credit';
$modversion['blocks'][$i]['description'] = "Shows a block which payment for credit on the webcam service can happen.";
$modversion['blocks'][$i]['show_func'] = "webcams_xpayment_show";
$modversion['blocks'][$i]['edit_func'] = "webcams_xpayment_edit";
$modversion['blocks'][$i]['options'] = "AUD|10,20,30,40,50,60,70,80,90|$";
$modversion['blocks'][$i]['template'] = 'webcams_purchase_credit.html';

// Templates
$modversion['templates'][0]['file'] = 'webcams_biopics.html';
$modversion['templates'][0]['description'] = 'Biographic Pictures';
$modversion['templates'][1]['file'] = 'webcams_camlist.html';
$modversion['templates'][1]['description'] = 'Camera List';
$modversion['templates'][2]['file'] = 'webcams_config_xml.html';
$modversion['templates'][2]['description'] = 'XML File for configuration';
$modversion['templates'][3]['file'] = 'webcams_index.html';
$modversion['templates'][3]['description'] = 'Index of Module';
$modversion['templates'][4]['file'] = 'webcams_videochat.html';
$modversion['templates'][4]['description'] = 'Video Chat for module';
$modversion['templates'][5]['file'] = 'webcams_create_user.html';
$modversion['templates'][5]['description'] = 'Video User Creation';
$modversion['templates'][6]['file'] = 'webcams_cpanel_users.html';
$modversion['templates'][6]['description'] = 'Control Panel Users List';
$modversion['templates'][7]['file'] = 'webcams_cpanel_hosts.html';
$modversion['templates'][7]['description'] = 'Control Panel Webcam Hosts List';
$modversion['templates'][8]['file'] = 'webcams_cpanel_studio.html';
$modversion['templates'][8]['description'] = 'Control Panel Studio List';
$modversion['templates'][9]['file'] = 'webcams_cpanel_create_user.html';
$modversion['templates'][9]['description'] = 'Control Panel User Create and Edit';
$modversion['templates'][10]['file'] = 'webcams_cpanel_create_host.html';
$modversion['templates'][10]['description'] = 'Control Panel Host Create and Edit';
$modversion['templates'][11]['file'] = 'webcams_cpanel_create_studio.html';
$modversion['templates'][11]['description'] = 'Control Panel Studio Create and Edit';
$modversion['templates'][11]['file'] = 'webcams_example.html';
$modversion['templates'][11]['description'] = 'Webcams Example';
$modversion['templates'][12]['file'] = 'webcams_create_host.html';
$modversion['templates'][12]['description'] = 'Video Webcam Host Creation';
$modversion['templates'][13]['file'] = 'webcams_create_studio.html';
$modversion['templates'][13]['description'] = 'Video Webcam Studio Host Creation';

// Search
$modversion['hasSearch'] = 0;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "forum_search";

// Smarty
$modversion['use_smarty'] = 1;

/*
$modversion['config'][] = array(
	'name' => 'htaccess',
	'title' => '_MI_HTACCESS',
	'description' => '_MI_HTACCESS_DESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 0);

$modversion['config'][] = array(
	'name' => 'baseurl',
	'title' => '_MI_BASEURL',
	'description' => '_MI_BASEURL_DESC',
	'formtype' => 'text',
	'valuetype' => 'text',
	'default' => 'webcams');

$modversion['config'][] = array(
	'name' => 'endofurl',
	'title' => '_MI_ENDOFURL',
	'description' => '_MI_ENDOFURL_DESC',
	'formtype' => 'text',
	'valuetype' => 'text',
	'default' => '.html');
*/

xoops_load('XoopsLists');
$themes = XoopsLists::getDirListAsArray($GLOBALS['xoops']->path('/modules/webcams/themes/'));
foreach($themes as $theme)
	$options[$theme] = $theme;

$modversion["config"][] = array(
	"name" => "theme",
	"title" => "_wbc_mi_theme",
	"description" => "_wbc_mi_theme_desc",
	"formtype"=> "select",
	"valuetype" => "text",
	"options"=> $options,
	"default" => "default");

$modversion['config'][] = array(
	'name' 			=> 'account_id',
	'title' 		=> '_wbc_mi_account_id',
	'description' 	=> '_wbc_mi_account_id_desc',
	'formtype' 		=> 'text',
	'valuetype' 	=> 'text',
	'default' 		=> '221234');

$modversion['config'][] = array(
	'name' => 'gateway_ip',
	'title' => '_wbc_mi_gateway_ip',
	'description' => '_wbc_mi_gateway_ip_desc',
	'formtype' => 'text',
	'valuetype' => 'text',
	'default' => "205.134.229.222");

$modversion['config'][] = array(
	'name' => 'gateway_pass',
	'title' => '_wbc_mi_gateway_pass',
	'description' => '_wbc_mi_gateway_pass_desc',
	'formtype' => 'password',
	'valuetype' => 'text',
	'default' => "kei874hf63Fle99d");

$modversion["config"][] = array(
	"name" => "status",
	"title" => "_wbc_mi_status",
	"description" => "_wbc_mi_status_desc",
	"formtype"=> "select",
	"valuetype" => "text",
	"options"=> array(	_mbc_mi_approved=>'approved',
						_mbc_mi_waiting=>'waiting',
						_mbc_mi_closed=>'closed'
					),
	"default" => "waiting");
					

$modversion['config'][] = array(
	'name' => 'categories',
	'title' => '_wbc_mi_categories',
	'description' => '_wbc_mi_categories_desc',
	'formtype' => 'textarea',
	'valuetype' => 'text',
	'default' => "Blondes|Teen|Latin|Psychics");

$modversion['config'][] = array(
	'name' => 'languages',
	'title' => '_wbc_mi_languages',
	'description' => '_wbc_mi_languages_desc',
	'formtype' => 'textarea',
	'valuetype' => 'text',
	'default' => "Czech|Dutch|English|French|German|Italian|Japanese|Mandarin|Portuguese|Romanian|Russian|Spanish|Swedish|Vietnamese");

$modversion['config'][] = array(
	'name' => 'max_time',
	'title' => '_wbc_mi_max_time',
	'description' => '_wbc_mi_max_time_desc',
	'formtype' => 'text',
	'valuetype' => 'int',
	'default' => "3");

$modversion['config'][] = array(
	'name' => 'max_time_total',
	'title' => '_wbc_mi_max_time_total',
	'description' => '_wbc_mi_max_time_total_desc',
	'formtype' => 'text',
	'valuetype' => 'int',
	'default' => "15");

$modversion['config'][] = array(
	'name' => 'max_time_total_period',
	'title' => '_wbc_mi_max_time_total_period',
	'description' => '_wbc_mi_max_time_total_period_desc',
	'formtype' => 'text',
	'valuetype' => 'int',
	'default' => "1440");

$modversion['config'][] = array(
	'name' => 'mode1',
	'title' => '_wbc_mi_mode1',
	'description' => '_wbc_mi_mode1_desc',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => "1");

$modversion['config'][] = array(
	'name' => 'mode2',
	'title' => '_wbc_mi_mode2',
	'description' => '_wbc_mi_mode2_desc',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => "1");

$modversion['config'][] = array(
	'name' => 'mode3',
	'title' => '_wbc_mi_mode3',
	'description' => '_wbc_mi_mode3_desc',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => "1");

$modversion['config'][] = array(
	'name' => 'allow_guest',
	'title' => '_wbc_mi_allow_guest',
	'description' => '_wbc_mi_allow_guest_desc',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => "1");

$modversion['config'][] = array(
	'name' => 'pay2',
	'title' => '_wbc_mi_pay2',
	'description' => '_wbc_mi_pay2_desc',
	'formtype' => 'text',
	'valuetype' => 'int',
	'default' => "199");

$modversion['config'][] = array(
	'name' => 'pay3',
	'title' => '_wbc_mi_pay3',
	'description' => '_wbc_mi_pay3_desc',
	'formtype' => 'text',
	'valuetype' => 'int',
	'default' => "299");

$modversion['config'][] = array(
	'name' => 'com2',
	'title' => '_wbc_mi_com2',
	'description' => '_wbc_mi_com2_desc',
	'formtype' => 'text',
	'valuetype' => 'int',
	'default' => "50");

$modversion['config'][] = array(
	'name' => 'com3',
	'title' => '_wbc_mi_com3',
	'description' => '_wbc_mi_com3_desc',
	'formtype' => 'text',
	'valuetype' => 'int',
	'default' => "60");

$modversion['config'][] = array(
	'name' => 'tip_com2',
	'title' => '_wbc_mi_tip_com2',
	'description' => '_wbc_mi_tip_com2_desc',
	'formtype' => 'text',
	'valuetype' => 'int',
	'default' => "35");

$modversion['config'][] = array(
	'name' => 'tip_com3',
	'title' => '_wbc_mi_tip_com3',
	'description' => '_wbc_mi_tip_com3_desc',
	'formtype' => 'text',
	'valuetype' => 'int',
	'default' => "55");

$modversion['config'][] = array(
	'name' => 'max_streams',
	'title' => '_wbc_mi_max_streams',
	'description' => '_wbc_mi_max_streams_desc',
	'formtype' => 'text',
	'valuetype' => 'int',
	'default' => "5");

$modversion['config'][] = array(
	'name' => 'view_user_bal',
	'title' => '_wbc_mi_view_user_bal',
	'description' => '_wbc_mi_view_user_bal_desc',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => "1");

$modversion['config'][] = array(
	'name' => 'profile',
	'title' => '_wbc_mi_profile',
	'description' => '_wbc_mi_profile_desc',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => "1");

$modversion['config'][] = array(
	'name' => 'media',
	'title' => '_wbc_mi_media',
	'description' => '_wbc_mi_media_desc',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => "1");

$modversion['config'][] = array(
	'name' => 'stats',
	'title' => '_wbc_mi_stats',
	'description' => '_wbc_mi_stats_desc',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => "1");

$modversion['config'][] = array(
	'name' => 'pos_bias',
	'title' => '_wbc_mi_pos_bias',
	'description' => '_wbc_mi_pos_bias_desc',
	'formtype' => 'text',
	'valuetype' => 'int',
	'default' => "5");


$modversion['config'][] = array(
	'name' => 'allow_ban',
	'title' => '_wbc_mi_allow_ban',
	'description' => '_wbc_mi_allow_ban_desc',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => "0");

$modversion['config'][] = array(
	'name' => 'studio_id',
	'title' => '_wbc_mi_studio_id',
	'description' => '_wbc_mi_studio_id_desc',
	'formtype' => 'text',
	'valuetype' => 'int',
	'default' => "1000");

$modversion['config'][] = array(
	'name' => 'chat_only',
	'title' => '_wbc_mi_chat_only',
	'description' => '_wbc_mi_chat_only_desc',
	'formtype' => 'yesno',
	'valuetype' => 'text',
	'default' => "0");

$modversion['config'][] = array(
	'name' => 'profile_field',
	'title' => '_wbc_mi_profile_field',
	'description' => '_wbc_mi_profile_field_desc',
	'formtype' => 'text',
	'valuetype' => 'text',
	'default' => "");

$modversion['config'][] = array(
	'name' => 'profile_host_value',
	'title' => '_wbc_mi_profile_host_value',
	'description' => '_wbc_mi_profile_host_value_desc',
	'formtype' => 'text',
	'valuetype' => 'text',
	'default' => "host");

$modversion['config'][] = array(
	'name' => 'profile_punter_value',
	'title' => '_wbc_mi_profile_punter_value',
	'description' => '_wbc_mi_profile_punter_value_desc',
	'formtype' => 'text',
	'valuetype' => 'text',
	'default' => "punter");

$modversion['config'][] = array(
	'name' => 'profile_host_group',
	'title' => '_wbc_mi_profile_host_group',
	'description' => '_wbc_mi_profile_host_group_desc',
	'formtype' => 'group',
	'valuetype' => 'int',
	'default' => XOOPS_GROUP_USERS);

$modversion['config'][] = array(
	'name' => 'profile_punter_group',
	'title' => '_wbc_mi_profile_punter_group',
	'description' => '_wbc_mi_profile_punter_group_desc',
	'formtype' => 'group',
	'valuetype' => 'int',
	'default' => XOOPS_GROUP_USERS);

$modversion['config'][] = array(
	'name' => 'support_sexy',
	'title' => '_wbc_mi_support_sexy',
	'description' => '_wbc_mi_support_sexy_desc',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => false);

$modversion['config'][] = array(
	'name' => 'htaccess',
	'title' => '_wbc_mi_htaccess',
	'description' => '_wbc_mi_htaccess_desc',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => false);

$modversion['config'][] = array(
	'name' => 'baseofurl',
	'title' => '_wbc_mi_baseofurl',
	'description' => '_wbc_mi_baseofurl_desc',
	'formtype' => 'text',
	'valuetype' => 'text',
	'default' => 'webcams');

$modversion['config'][] = array(
	'name' => 'endofurl',
	'title' => '_wbc_mi_endofurl',
	'description' => '_wbc_mi_endofurl_desc',
	'formtype' => 'text',
	'valuetype' => 'text',
	'default' => '.html');

?>