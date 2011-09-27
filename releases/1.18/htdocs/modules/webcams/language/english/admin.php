<?php

	// Table headers
	define('_wbc_am_th_userid', 'User ID');
	define('_wbc_am_th_studioname', 'Studio Name');
	define('_wbc_am_th_hostid', 'Host ID');
	define('_wbc_am_th_firstname', 'First name');
	define('_wbc_am_th_lastname', 'Last name');
	define('_wbc_am_th_postcode', 'Postcode');
	define('_wbc_am_th_country', 'Country');
	define('_wbc_am_th_email', 'Email Address');
	define('_wbc_am_th_phone', 'Phone');
	define('_wbc_am_th_actions', 'Actions');
	
	// Form Headers
	define('_wbc_am_new', 'Create New -');
	define('_wbc_am_host_h1', 'Webcam Host');
	define('_wbc_am_host_p', 'From here you can edit or create a new host. It is a standard form to save the webcam host.');
	define('_wbc_am_user_h1', 'Webcam User');
	define('_wbc_am_user_p', 'From here you can edit or create a new webcam user.');
	define('_wbc_am_studio_h1', 'Webcam Studio');
	define('_wbc_am_studio_p', 'From here we make a studio for webcams you can create or edit one with this form.');

	// Permissions
	define('_wbc_am_perm_host', 'Webcam Hosts');
	define('_wbc_am_perm_user', 'Webcam Users');
	define('_wbc_am_perm_studio', 'Webcam Studio');
	define('_wbc_am_perm_access_title', 'Objectivity Access');
	define('_wbc_am_perm_access_name', 'access');
	define('_wbc_am_perm_access_desc', 'This is the way the objects are accessable and whom to.');
	
	//Tables
	define('_wbc_am_hosts_h1', 'Webcam Hosts');
	define('_wbc_am_hosts_p', 'This is a paginated sortable list of webcam hosts you have subscribed on your system. You can approve them and delete them as well as edit them from here!');
	define('_wbc_am_users_h1', 'End Member Users');
	define('_wbc_am_users_p', 'This is a paginated sortable list of webcam users you have subscribed on your system. You can edit them from here!');
	define('_wbc_am_studios_h1', 'Webcam Studios');
	define('_wbc_am_studios_p', 'This is a paginated sortable list of webcam studios you have subscribed on your system. You can approve them and delete them as well as edit them from here!');
	
	//Forms
	define('_wbc_am_frm_email', 'Your Email Address');
	define('_wbc_am_frm_email_desc', '');
	define('_wbc_am_frm_user', 'Your username');
	define('_wbc_am_frm_user_desc', '[a-zA-Z0-9] max 20 chars');
	define('_wbc_am_frm_pass', 'Your password');
	define('_wbc_am_frm_pass_desc', '[a-zA-Z0-9] max 20 chars');
	define('_wbc_am_frm_firstname', 'Firstname');
	define('_wbc_am_frm_firstname_desc', '');
	define('_wbc_am_frm_lastname', 'Lastname');
	define('_wbc_am_frm_lastname_desc', '');
	define('_wbc_am_frm_address1', 'Address line 1');
	define('_wbc_am_frm_address1_desc', '');
	define('_wbc_am_frm_address2', 'Address line 2');
	define('_wbc_am_frm_address2_desc', '');
	define('_wbc_am_frm_city', 'City/Town/Suburb');
	define('_wbc_am_frm_city_desc', '');
	define('_wbc_am_frm_state', 'State code');
	define('_wbc_am_frm_state_desc', '');
	define('_wbc_am_frm_postcode', 'Postcode/ZIP');
	define('_wbc_am_frm_postcode_desc', '');
	define('_wbc_am_frm_country', 'Country Code');
	define('_wbc_am_frm_country_desc', '');
	define('_wbc_am_frm_phone', 'Your Phone Number');
	define('_wbc_am_frm_phone_desc', '(Mobile)');
	define('_wbc_am_frm_age', 'Your age');
	define('_wbc_am_frm_age_desc', '');
	define('_wbc_am_frm_pref', 'Preference/Orintation');
	define('_wbc_am_frm_pref_desc', '');
	define('_wbc_am_frm_local', 'Your local area is called!');
	define('_wbc_am_frm_local_desc', '');
	define('_wbc_am_frm_likes', 'Likes');
	define('_wbc_am_frm_likes_desc', 'Seperatewith a comma');
	define('_wbc_am_frm_dislikes', 'Dislikes');
	define('_wbc_am_frm_dislikes_desc', 'Seperate with a comma \',\'');
	define('_wbc_am_frm_bio', 'Chat Bio');
	define('_wbc_am_frm_bio_desc', '');
	define('_wbc_am_frm_chat', 'Chat Signature');
	define('_wbc_am_frm_chat_desc', '');
	define('_wbc_mn_frm_languages', 'Supported languages');
	define('_wbc_mn_frm_languages_desc', '');
	define('_wbc_mn_frm_category', 'Category');
	define('_wbc_mn_frm_category_desc', '');
	define('_wbc_am_frm_timezone', 'Timezone');
	define('_wbc_am_frm_timezone_desc', '');
	define('_wbc_am_frm_studioname', 'Studio Name');
	define('_wbc_am_frm_studioname_desc', '');
	define('_wbc_am_frm_allow_create_host', 'Allow studio to create host!');
	define('_wbc_am_frm_allow_create_host_desc', '');
	define('_wbc_am_frm_tip2', 'Group chat tip percentile');
	define('_wbc_am_frm_tip2_desc', '');
	define('_wbc_am_frm_tip3', 'Private chat tip percentile');
	define('_wbc_am_frm_tip3_desc', '');
	define('_wbc_am_frm_max_time', 'Maximum time allowed!');
	define('_wbc_am_frm_max_time_desc', '');
	define('_wbc_am_frm_max_time_total', 'Total time per session allowed!');
	define('_wbc_am_frm_max_time_total_desc', '');
	define('_wbc_am_frm_max_time_total_period', 'Time period in minutes for sessions.');
	define('_wbc_am_frm_max_time_total_period_desc', '');
	define('_wbc_am_frm_mode1', 'Allow free chat?');
	define('_wbc_am_frm_mode1_desc', '');
	define('_wbc_am_frm_mode2', 'Allow group chat?');
	define('_wbc_am_frm_mode2_desc', '');
	define('_wbc_am_frm_mode3', 'Allow Private Chat?');
	define('_wbc_am_frm_mode3_desc', '');
	define('_wbc_am_frm_allow_guest', 'Allow Guests');
	define('_wbc_am_frm_allow_guest_desc', '');
	define('_wbc_am_frm_pay2', 'Group chat per minute cost');
	define('_wbc_am_frm_pay2_desc', '299 = $2.99');
	define('_wbc_am_frm_pay3', 'Private chat per minute cost');
	define('_wbc_am_frm_pay3_desc', '299 = $2.99');
	define('_wbc_am_frm_com2', 'Group chat commission percentile');
	define('_wbc_am_frm_com2_desc', '');
	define('_wbc_am_frm_com3', 'Private chat commission percentile');
	define('_wbc_am_frm_com3_desc', '');
	define('_wbc_am_frm_tip_com2', 'Group chat tip percentile');
	define('_wbc_am_frm_tip_com2_desc', '');
	define('_wbc_am_frm_tip_com3', 'Private chat tip percentile');
	define('_wbc_am_frm_tip_com3_desc', '');
	define('_wbc_am_frm_max_streams', 'Maximum number of guest streams.');
	define('_wbc_am_frm_max_streams_desc', '');
	define('_wbc_am_frm_view_user_bal', 'Allow to see user balance');
	define('_wbc_am_frm_view_user_bal_desc', '');
	define('_wbc_am_frm_profile', 'Display Profile');
	define('_wbc_am_frm_profile_desc', '');
	define('_wbc_am_frm_media', 'Display Media');
	define('_wbc_am_frm_media_desc', '');
	define('_wbc_am_frm_stats', 'Display Stats');
	define('_wbc_am_frm_stats_desc', '');
	define('_wbc_am_frm_aim_user', 'AIM Username');
	define('_wbc_am_frm_aim_user_desc', '');
	define('_wbc_am_frm_aim_pass', 'AIM Password');
	define('_wbc_am_frm_aim_pass_desc', '');
	define('_wbc_am_frm_pos_bias', 'Position Bias');
	define('_wbc_am_frm_pos_bias_desc', '0-100');
	define('_wbc_am_frm_allow_ban', 'Allow Banning of Guest and Users');
	define('_wbc_am_frm_allow_ban_desc', '(not recommended)');
	define('_wbc_am_frm_aux_link1_url', 'Aux URL 1');
	define('_wbc_am_frm_aux_link1_url_desc', '');
	define('_wbc_am_frm_aux_link1_txt', 'Aux Link Text 1');
	define('_wbc_am_frm_aux_link1_txt_desc', '');
	define('_wbc_am_frm_aux_link2_url', 'Aux URL 2');
	define('_wbc_am_frm_aux_link2_url_desc', '');
	define('_wbc_am_frm_aux_link2_txt', 'Aux Link Text 2');
	define('_wbc_am_frm_aux_link2_txt_desc', '');
	define('_wbc_am_frm_aux_link3_url', 'Aux URL 3');
	define('_wbc_am_frm_aux_link3_url_desc', '');
	define('_wbc_am_frm_aux_link3_txt', 'Aux Link Text 3');
	define('_wbc_am_frm_aux_link3_txt_desc', '');
	define('_wbc_am_frm_studio_id', 'Studio ID');
	define('_wbc_am_frm_studio_id_desc', '');
	define('_wbc_am_frm_chat_only', 'Chat only?');
	define('_wbc_am_frm_chat_only_desc', '');

	// Form Titles
	define('_wbc_am_frm_add_host', 'Add new webcam host');
	define('_wbc_am_frm_edit_host', 'Edit existing webcam host');
	define('_wbc_am_frm_add_user', 'Add new member user');
	define('_wbc_am_frm_edit_user', 'Edit existing member');
	define('_wbc_am_frm_edit_studio', 'Add new studio');
	define('_wbc_am_frm_add_studio', 'Edit existing studio');
	
	?>	