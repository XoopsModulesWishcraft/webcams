<?php

	// status text
	define('_wbc_mi_approved','Approved Webcam');
	define('_wbc_mi_waiting','Waiting Application');
	define('_wbc_mi_closed','Closed Application');

	// Menus
	define('_wbc_mi_makehost','Make Webcam Host Application');
	define('_wbc_mi_makeuser','Open a User Account');
	define('_wbc_mi_makestudio','Create a studio account');
	define('_wbc_mi_editmysettings','Edit My Settings');
	define('_wbc_mi_camlist','Webcam List');
	

	// xoops version
	define('_wbc_mi_name','Webcams');
	define('_wbc_mi_desc','Client for iStreaming Networks Webcam Service');
	
	// preferences
	define('_mbc_mi_approved','Approved Account');
	define('_mbc_mi_waiting','Waiting Account');
	define('_mbc_mi_closed','Closed Account');
	define('_wbc_mi_theme','Webcam Theme');
	define('_wbc_mi_theme_desc','This is the display theme for the webcam consoles <em>(Update module to display new themes)</em>!');
	define('_wbc_mi_account_id','Account ID');
	define('_wbc_mi_account_id_desc','This is the account identification number provided by iStreaming Networks <em>(<a href="http://www.esensualnetworks.com/testaccount.php">click here to get one</a>)</em>! [Your Account ID]');
	define('_wbc_mi_gateway_ip','Gateway IP Address');
	define('_wbc_mi_gateway_ip_desc','This is the gateway IP Address provided by iStreaming Networks <em>(<a href="http://www.esensualnetworks.com/testaccount.php">click here to get one</a>)</em>! [Admin->MyAccount page, gateway info section]');
	define('_wbc_mi_gateway_pass','Gateway Password');
	define('_wbc_mi_gateway_pass_desc','This is the gateway password provided by iStreaming Networks <em>(<a href="http://www.esensualnetworks.com/testaccount.php">click here to get one</a>)</em>! [Admin->MyAccount page, gateway info section]');
	define('_wbc_mi_status','Default Status');
	define('_wbc_mi_status_desc','This is the default status of new applications!');
	define('_wbc_mi_categories','Webcam Host Categories');
	define('_wbc_mi_categories_desc','These are the categories the webcam hosts will have to select from, please list them in the order you want to appear in and seperate with a pipe \'|\'');
	define('_wbc_mi_languages','Webcam Host Languages');
	define('_wbc_mi_languages_desc','These are the languages the webcam hosts will have to select from, please list them in the order you want to appear in and seperate with a pipe \'|\'');
	define('_wbc_mi_max_time','Webcam Host Default: Minutes in free room.');
	define('_wbc_mi_max_time_desc','This is the amount of minutes in a free room a user is allowed!');
	define('_wbc_mi_max_time_total','Webcam Host Default: Minutes per period (below)');
	define('_wbc_mi_max_time_total_desc','This is the total amount of minutes allowed for a user period allowed for guests in free rooms in the period listed.');
	define('_wbc_mi_max_time_total_period','Webcam Host Default: Minutes of period allowed for guests in free rooms');
	define('_wbc_mi_max_time_total_period_desc','Total amount of minutes measured in a period of allocated time. (1440 = 24 Hours)');
	define('_wbc_mi_mode1','Webcam Host Default: Free chat');
	define('_wbc_mi_mode1_desc','Allow Free Chat!');
	define('_wbc_mi_mode2','Webcam Host Default: Group chat');
	define('_wbc_mi_mode2_desc','Allow Group Chat!');
	define('_wbc_mi_mode3','Webcam Host Default: Private chat');
	define('_wbc_mi_mode3_desc','Allow Private Chat!');
	define('_wbc_mi_allow_guest','Webcam Host Default: Enable guest chat!');
	define('_wbc_mi_allow_guest_desc','Allow users to enter free chat with guestpass enabled on your account.');
	define('_wbc_mi_pay2','Webcam Host Default: Group pay per minute ');
	define('_wbc_mi_pay2_desc','Group pay per minute rate. (1.99 per minute = 199)');
	define('_wbc_mi_pay3','Webcam Host Default: Private pay per minute');
	define('_wbc_mi_pay3_desc','Private pay per minute rate (2.99 per minute = 299)');
	define('_wbc_mi_com2','Webcam Host Default: Group chat commission rate');
	define('_wbc_mi_com2_desc','This is the commission rate for group chat (Number represents a percentage ie. 50 = 50%)');
	define('_wbc_mi_com3','Webcam Host Default: Private chat commission rate');
	define('_wbc_mi_com3_desc','This is the commission rate for private chat (Number represents a percentage ie. 50 = 50%)');
	define('_wbc_mi_tip_com2','Webcam Host Default: Group chat tip commission rate');
	define('_wbc_mi_tip_com2_desc','This is the group chat tip commission rate the number represents a percentage (35 = 35%)');
	define('_wbc_mi_tip_com3','Webcam Host Default: Private chat tip commission rate');
	define('_wbc_mi_tip_com3_desc','This is the private chat tip commission rate the number represents a percentage (35 = 35%)');
	define('_wbc_mi_max_streams','Webcam Host Default: Max number of simultaneous free room viewers');
	define('_wbc_mi_max_streams_desc','This is the max number of simultaneous free room viewers');
	define('_wbc_mi_view_user_bal','Webcam Host Default: Allow host to view member\'s balance');
	define('_wbc_mi_view_user_bal_desc','Allow host to view member\'s balance (via JustCamIt)');
	define('_wbc_mi_profile','Webcam Host Default: Allow host to update their profile');
	define('_wbc_mi_profile_desc','Allow host to update their profile? (via JustCamIt)');
	define('_wbc_mi_media','Webcam Host Default: Allow host to update, upload images');
	define('_wbc_mi_media_desc','Allow host to update, upload images? (via JustCamIt)');
	define('_wbc_mi_stats','Webcam Host Default: Allow host to view her stats');
	define('_wbc_mi_stats_desc','Allow host to view her stats? (via JustCamIt)');
	define('_wbc_mi_pos_bias','Webcam Host Default: Camlist position bias');
	define('_wbc_mi_pos_bias_desc','Camlist position bias (0-100 with 0 being first in list)');
	define('_wbc_mi_allow_ban','Webcam Host Default: Allow to ban (disable)');
	define('_wbc_mi_allow_ban_desc','Allow host to ban (disable) user account via JustCamIt, (not recommended)');
	define('_wbc_mi_studio_id','Webcam Host Default: Default Studio ID');
	define('_wbc_mi_studio_id_desc','Main account=1000, or enter full Studio ID to assign new Hosts to a Studio');
	define('_wbc_mi_chat_only','Webcam Host Default: Chat Only');
	define('_wbc_mi_chat_only_desc','Text chat only no video, requires JustCamIt 1.1 and higher');
	
	// Admin Menus
	define('_wbc_mi_adminmenu1','Webcam Hosts');
	define('_wbc_mi_adminmenu2','User Hosts');
	define('_wbc_mi_adminmenu3','Webcam Studios');
	define('_wbc_mi_adminmenu4','Add a Host');
	define('_wbc_mi_adminmenu5','Add a User');
	define('_wbc_mi_adminmenu6','Add a Studio');	
	define('_wbc_mi_adminmenu7','Permissions');
	
	// Admin Menu Icons
	define('_wbc_mi_adminmenu1_icon','images/icons/host.png');
	define('_wbc_mi_adminmenu2_icon','images/icons/user.png');
	define('_wbc_mi_adminmenu3_icon','images/icons/studio.png');
	define('_wbc_mi_adminmenu4_icon','images/icons/add.host.png');
	define('_wbc_mi_adminmenu5_icon','images/icons/add.user.png');
	define('_wbc_mi_adminmenu6_icon','images/icons/add.studio.png');
	define('_wbc_mi_adminmenu7_icon','images/icons/permissions.png');

	// Permissions - do not change
	define('_wbc_mi_perm_host', 1);
	define('_wbc_mi_perm_user', 2);
	define('_wbc_mi_perm_studio', 3);
	define('_wbc_mi_perm_access_name','access');
	
	// Functional Actions
	define('_wbc_mi_action_approve','<img src="'.XOOPS_URL.'/modules/webcams/images/icons/approve.png" />');
	define('_wbc_mi_action_cancel','<img src="'.XOOPS_URL.'/modules/webcams/images/icons/cancel.png" />');
	define('_wbc_mi_action_edit','<img src="'.XOOPS_URL.'/modules/webcams/images/icons/edit.png" />');
	define('_wbc_mi_action_delete','<img src="'.XOOPS_URL.'/modules/webcams/images/icons/delete.png" />');
	
	
	//	Version 1.17
	// Preferences
	define('_wbc_mi_profile_field','Profile field to check for mode');
	define('_wbc_mi_profile_field_desc','This is the profile field to check the mode of the account being used.');
	define('_wbc_mi_profile_host_value','Profile field value for Webcam Host');
	define('_wbc_mi_profile_host_value_desc','This is the profile field value for the mode of webcam host.');
	define('_wbc_mi_profile_punter_value','Profile field value for User Host');
	define('_wbc_mi_profile_punter_value_desc','This is the profile field value for the mode of punter/user of webcam hosts.');
	define('_wbc_mi_profile_host_group','Group for Webcam Host');
	define('_wbc_mi_profile_host_group_desc','This is the group for the mode of webcam host.');
	define('_wbc_mi_profile_punter_group','Group for User Host');
	define('_wbc_mi_profile_punter_group_desc','This is the group for the mode of punter/user of webcam hosts.');
	define('_wbc_mi_support_sexy','Support Sexy Profile Module 1.33 or later');
	define('_wbc_mi_support_sexy_desc','Support Sexy Profile Module 1.33 or later for webcams module profiles!');
	
	// Version 1.19
	// Preferences
	define('_wbc_mi_htaccess','HTAccess SEO');
	define('_wbc_mi_htaccess_desc','You need to have the htaccess in the root of xoops for this SEO.');
	define('_wbc_mi_baseofurl','Base of URL (SEO .htaccess)');
	define('_wbc_mi_baseofurl_desc','You need to modify your htaccess to change this setting.');
	define('_wbc_mi_endofurl','End of URL (SEO .htaccess)');
	define('_wbc_mi_endofurl_desc','You need to modify your htaccess to change this setting.');	
?>