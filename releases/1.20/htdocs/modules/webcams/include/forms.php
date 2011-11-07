<?php

	include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
	include_once ('formselectstatus.php');
	include_once ('formselecttimezone.php');
	include_once ('formselectcategory.php');
	include_once ('formselectlanguages.php');
	include_once ('functions.php');
	

	function webcams_admin_host_edit($id)
	{

		$host_handler =& xoops_getmodulehandler('host', 'webcams');

		if ($id<>0)
			$host = $host_handler->get($id, true);
		else
			$host = $host_handler->create();


		if ($id<>0)
			$form = new XoopsThemeForm(_wbc_am_frm_edit_host, "host", "", "post");
		else
			$form = new XoopsThemeForm(_wbc_am_frm_add_host, "host", "", "post");
		
		$formobjects['email'] = new XoopsFormText(_wbc_am_frm_email, ''.$id.'[email]', 40, 255, $host->getVar('email'));
		$formobjects['email']->setDescription(_wbc_am_frm_email_desc);		
		$formobjects['user'] = new XoopsFormText(_wbc_am_frm_user, ''.$id.'[user]', 20, 23, $host->getVar('user'));
		$formobjects['user']->setDescription(_wbc_am_frm_user_desc);
		$formobjects['pass'] = new XoopsFormText(_wbc_am_frm_pass, ''.$id.'[pass]', 20, 23, $host->getVar('pass'));
		$formobjects['pass']->setDescription(_wbc_am_frm_pass_desc);
		$formobjects['firstname'] = new XoopsFormText(_wbc_am_frm_firstname, ''.$id.'[firstname]', 30, 64, $host->getVar('firstname'));
		$formobjects['firstname']->setDescription(_wbc_am_frm_firstname_desc);
		$formobjects['lastname'] = new XoopsFormText(_wbc_am_frm_lastname, ''.$id.'[lastname]', 30, 64, $host->getVar('lastname'));
		$formobjects['lastname']->setDescription(_wbc_am_frm_lastname_desc);
		$formobjects['address1'] = new XoopsFormText(_wbc_am_frm_address1, ''.$id.'[address1]', 40, 128, $host->getVar('address1'));
		$formobjects['address1']->setDescription(_wbc_am_frm_address1_desc);
		$formobjects['address2'] = new XoopsFormText(_wbc_am_frm_address2, ''.$id.'[address2]', 40, 128, $host->getVar('address2'));
		$formobjects['address2']->setDescription(_wbc_am_frm_address2_desc);
		$formobjects['city'] = new XoopsFormText(_wbc_am_frm_city, ''.$id.'[city]', 30, 64, $host->getVar('city'));
		$formobjects['city']->setDescription(_wbc_am_frm_city_desc);
		$formobjects['state'] = new XoopsFormText(_wbc_am_frm_state, ''.$id.'[state]', 10, 10, $host->getVar('state'));
		$formobjects['state']->setDescription(_wbc_am_frm_state_desc);
		$formobjects['postcode'] = new XoopsFormText(_wbc_am_frm_postcode, ''.$id.'[postcode]', 10, 10, $host->getVar('postcode'));
		$formobjects['postcode']->setDescription(_wbc_am_frm_postcode_desc);
		$formobjects['country'] = new XoopsFormText(_wbc_am_frm_country, ''.$id.'[country]', 5, 3, $host->getVar('country'));
		$formobjects['country']->setDescription(_wbc_am_frm_country_desc);
		$formobjects['phone'] = new XoopsFormText(_wbc_am_frm_phone, ''.$id.'[phone]', 20, 32, $host->getVar('phone'));
		$formobjects['phone']->setDescription(_wbc_am_frm_phone_desc);
		$formobjects['age'] = new XoopsFormText(_wbc_am_frm_age, ''.$id.'[age]', 5, 8, $host->getVar('age'));
		$formobjects['age']->setDescription(_wbc_am_frm_age_desc);
		$formobjects['pref'] = new XoopsFormText(_wbc_am_frm_pref, ''.$id.'[pref]', 30, 64, $host->getVar('pref'));
		$formobjects['pref']->setDescription(_wbc_am_frm_pref_desc);
		$formobjects['local'] = new XoopsFormText(_wbc_am_frm_local, ''.$id.'[local]', 40, 128, $host->getVar('local'));
		$formobjects['local']->setDescription(_wbc_am_frm_local_desc);
		$formobjects['likes'] = new XoopsFormText(_wbc_am_frm_likes, ''.$id.'[likes]', 40, 100, $host->getVar('likes'));
		$formobjects['likes']->setDescription(_wbc_am_frm_likes_desc);
		$formobjects['dislikes'] = new XoopsFormText(_wbc_am_frm_dislikes, ''.$id.'[dislikes]', 40, 100, $host->getVar('dislikes'));
		$formobjects['dislikes']->setDescription(_wbc_am_frm_dislikes_desc);
		$formobjects['bio'] = new XoopsFormText(_wbc_am_frm_bio, ''.$id.'[bio]', 40, 2048, $host->getVar('bio'));
		$formobjects['bio']->setDescription(_wbc_am_frm_bio_desc);
		$formobjects['chat'] = new XoopsFormText(_wbc_am_frm_chat, ''.$id.'[chat]', 40, 256, $host->getVar('chat'));
		$formobjects['chat']->setDescription(_wbc_am_frm_chat_desc);
		$formobjects['languages'] = new WebcamsFormSelectLanguages(_wbc_mn_frm_languages, ''.$id.'[languages][]', $host->getVar('languages'), 7, true);
		$formobjects['languages']->setDescription(_wbc_mn_frm_languages_desc);
		$formobjects['category'] = new WebcamsFormSelectCategory(_wbc_mn_frm_category, ''.$id.'[category][]', $host->getVar('category'), 6, true);
		$formobjects['category']->setDescription(_wbc_mn_frm_category_desc);
		$formobjects['timezone'] = new WebcamsFormSelectTimezone(_wbc_am_frm_timezone, ''.$id.'[timezone]', $host->getVar('timezone'));
		$formobjects['timezone']->setDescription(_wbc_am_frm_timezone_desc);
		$formobjects['max_time'] = new XoopsFormText(_wbc_am_frm_max_time, ''.$id.'[max_time]', 5, 8, $host->getVar('max_time'));
		$formobjects['max_time']->setDescription(_wbc_am_frm_max_time_desc);
		$formobjects['max_time_total'] = new XoopsFormText(_wbc_am_frm_max_time_total, ''.$id.'[max_time_total]', 5, 8, $host->getVar('max_time_total'));
		$formobjects['max_time_total']->setDescription(_wbc_am_frm_max_time_total_desc);
		$formobjects['max_time_total_period'] = new XoopsFormText(_wbc_am_frm_max_time_total_period, ''.$id.'[max_time_total_period]', 5, 8, $host->getVar('max_time_total_period'));
		$formobjects['max_time_total_period']->setDescription(_wbc_am_frm_max_time_total_period_desc);
		$formobjects['mode1'] = new XoopsFormRadioYN(_wbc_am_frm_mode1, ''.$id.'[mode1]', $host->getVar('mode1'));
		$formobjects['mode1']->setDescription(_wbc_am_frm_mode1_desc);
		$formobjects['mode2'] = new XoopsFormRadioYN(_wbc_am_frm_mode2, ''.$id.'[mode2]', $host->getVar('mode2'));
		$formobjects['mode2']->setDescription(_wbc_am_frm_mode2_desc);
		$formobjects['mode3'] = new XoopsFormRadioYN(_wbc_am_frm_mode3, ''.$id.'[mode3]', $host->getVar('mode3'));
		$formobjects['mode3']->setDescription(_wbc_am_frm_mode3_desc);
		$formobjects['allow_guest'] = new XoopsFormRadioYN(_wbc_am_frm_allow_guest, ''.$id.'[allow_guest]', $host->getVar('allow_guest'));
		$formobjects['allow_guest']->setDescription(_wbc_am_frm_allow_guest_desc);
		$formobjects['pay2'] = new XoopsFormText(_wbc_am_frm_pay2, ''.$id.'[pay2]', 5, 8, $host->getVar('pay2'));
		$formobjects['pay2']->setDescription(_wbc_am_frm_pay2_desc);
		$formobjects['pay3'] = new XoopsFormText(_wbc_am_frm_pay3, ''.$id.'[pay3]', 5, 8, $host->getVar('pay3'));
		$formobjects['pay3']->setDescription(_wbc_am_frm_pay3_desc);
		$formobjects['com2'] = new XoopsFormText(_wbc_am_frm_com2, ''.$id.'[com2]', 5, 8, $host->getVar('com2'));
		$formobjects['com2']->setDescription(_wbc_am_frm_com2_desc);
		$formobjects['com3'] = new XoopsFormText(_wbc_am_frm_com3, ''.$id.'[com3]', 5, 8, $host->getVar('com3'));
		$formobjects['com3']->setDescription(_wbc_am_frm_com3_desc);
		$formobjects['tip_com2'] = new XoopsFormText(_wbc_am_frm_tip_com2, ''.$id.'[tip_com2]', 5, 8, $host->getVar('tip_com2'));
		$formobjects['tip_com2']->setDescription(_wbc_am_frm_tip_com2_desc);
		$formobjects['tip_com3'] = new XoopsFormText(_wbc_am_frm_tip_com3, ''.$id.'[tip_com3]', 5, 8, $host->getVar('tip_com3'));
		$formobjects['tip_com3']->setDescription(_wbc_am_frm_tip_com3_desc);
		$formobjects['max_streams'] = new XoopsFormText(_wbc_am_frm_max_streams, ''.$id.'[max_streams]', 5, 8, $host->getVar('max_streams'));
		$formobjects['max_streams']->setDescription(_wbc_am_frm_max_streams_desc);	
		$formobjects['view_user_bal'] = new XoopsFormRadioYN(_wbc_am_frm_view_user_bal, ''.$id.'[view_user_bal]', $host->getVar('view_user_bal'));
		$formobjects['view_user_bal']->setDescription(_wbc_am_frm_view_user_bal_desc);
		$formobjects['profile'] = new XoopsFormRadioYN(_wbc_am_frm_profile, ''.$id.'[profile]', $host->getVar('profile'));
		$formobjects['profile']->setDescription(_wbc_am_frm_profile_desc);
		$formobjects['media'] = new XoopsFormRadioYN(_wbc_am_frm_media, ''.$id.'[media]', $host->getVar('media'));
		$formobjects['media']->setDescription(_wbc_am_frm_media_desc);
		$formobjects['stats'] = new XoopsFormRadioYN(_wbc_am_frm_stats, ''.$id.'[stats]', $host->getVar('stats'));
		$formobjects['stats']->setDescription(_wbc_am_frm_stats_desc);
		$formobjects['aim_user'] = new XoopsFormText(_wbc_am_frm_aim_user, ''.$id.'[aim_user]', 40, 255, $host->getVar('aim_user'));
		$formobjects['aim_user']->setDescription(_wbc_am_frm_aim_user_desc);		
		$formobjects['aim_pass'] = new XoopsFormText(_wbc_am_frm_aim_pass, ''.$id.'[aim_pass]', 40, 255, $host->getVar('aim_pass'));
		$formobjects['aim_pass']->setDescription(_wbc_am_frm_aim_pass_desc);		
		$formobjects['pos_bias'] = new XoopsFormText(_wbc_am_frm_pos_bias, ''.$id.'[pos_bias]', 5, 8, $host->getVar('pos_bias'));
		$formobjects['pos_bias']->setDescription(_wbc_am_frm_pos_bias_desc);	
		$formobjects['allow_ban'] = new XoopsFormRadioYN(_wbc_am_frm_allow_ban, ''.$id.'[allow_ban]', $host->getVar('allow_ban'));
		$formobjects['allow_ban']->setDescription(_wbc_am_frm_allow_ban_desc);
		$formobjects['aux_link1_url'] = new XoopsFormText(_wbc_am_frm_aux_link1_url, ''.$id.'[aux_link1_url]', 40, 255, $host->getVar('aux_link1_url'));
		$formobjects['aux_link1_url']->setDescription(_wbc_am_frm_aux_link1_url_desc);		
		$formobjects['aux_link1_txt'] = new XoopsFormText(_wbc_am_frm_aux_link1_txt, ''.$id.'[aux_link1_txt]', 40, 255, $host->getVar('aux_link1_txt'));
		$formobjects['aux_link1_txt']->setDescription(_wbc_am_frm_aux_link1_txt_desc);		
		$formobjects['aux_link2_url'] = new XoopsFormText(_wbc_am_frm_aux_link2_url, ''.$id.'[aux_link2_url]', 40, 255, $host->getVar('aux_link2_url'));
		$formobjects['aux_link2_url']->setDescription(_wbc_am_frm_aux_link2_url_desc);		
		$formobjects['aux_link2_txt'] = new XoopsFormText(_wbc_am_frm_aux_link2_txt, ''.$id.'[aux_link2_txt]', 40, 255, $host->getVar('aux_link2_txt'));
		$formobjects['aux_link2_txt']->setDescription(_wbc_am_frm_aux_link2_txt_desc);	
		$formobjects['aux_link3_url'] = new XoopsFormText(_wbc_am_frm_aux_link3_url, ''.$id.'[aux_link3_url]', 40, 255, $host->getVar('aux_link3_url'));
		$formobjects['aux_link3_url']->setDescription(_wbc_am_frm_aux_link3_url_desc);		
		$formobjects['aux_link3_txt'] = new XoopsFormText(_wbc_am_frm_aux_link3_txt, ''.$id.'[aux_link3_txt]', 40, 255, $host->getVar('aux_link3_txt'));
		$formobjects['aux_link3_txt']->setDescription(_wbc_am_frm_aux_link3_txt_desc);		
		$formobjects['studio_id'] = new XoopsFormText(_wbc_am_frm_studio_id, ''.$id.'[studio_id]', 5, 8, $host->getVar('studio_id'));
		$formobjects['studio_id']->setDescription(_wbc_am_frm_studio_id_desc);	
		$formobjects['chat_only'] = new XoopsFormRadioYN(_wbc_am_frm_chat_only, ''.$id.'[chat_only]', $host->getVar('chat_only'));
		$formobjects['chat_only']->setDescription(_wbc_am_frm_chat_only_desc);
		

		$formobjects['id'] = new XoopsFormHidden('id', $id);
											
		$required = array('user', 'pass', 'email');
		
		foreach($formobjects as $id =>$formobject)
			if (!in_array($id, $required))
				$form->addElement($formobjects[$id], false);
			else
				$form->addElement($formobjects[$id], true);
	
		$form->addElement(new XoopsFormHidden("op", 'save'));
		$form->addElement(new XoopsFormHidden("fct", 'host'));
		$form->addElement(new XoopsFormButton('', 'save_list', _SUBMIT, "submit"));
		echo $form->render();
		
	}

	function webcams_user_host_edit($id)
	{

		$host_handler =& xoops_getmodulehandler('host', 'webcams');

		if ($id<>0)
			$host = $host_handler->get($id, true);
		else
			$host = $host_handler->create();


		if ($id<>0)
			$form = new XoopsThemeForm(_wbc_mn_frm_edit_host, "host", "", "post");
		else
			$form = new XoopsThemeForm(_wbc_mn_frm_add_host, "host", "", "post");
		
		$formobjects['email'] = new XoopsFormText(_wbc_mn_frm_email, ''.$id.'[email]', 40, 255, $host->getVar('email'));
		$formobjects['email']->setDescription(_wbc_mn_frm_email_desc);		
		$formobjects['user'] = new XoopsFormText(_wbc_mn_frm_user, ''.$id.'[user]', 20, 23, $host->getVar('user'));
		$formobjects['user']->setDescription(_wbc_mn_frm_user_desc);
		$formobjects['pass'] = new XoopsFormText(_wbc_mn_frm_pass, ''.$id.'[pass]', 20, 23, $host->getVar('pass'));
		$formobjects['pass']->setDescription(_wbc_mn_frm_pass_desc);
		$formobjects['firstname'] = new XoopsFormText(_wbc_mn_frm_firstname, ''.$id.'[firstname]', 30, 64, $host->getVar('firstname'));
		$formobjects['firstname']->setDescription(_wbc_mn_frm_firstname_desc);
		$formobjects['lastname'] = new XoopsFormText(_wbc_mn_frm_lastname, ''.$id.'[lastname]', 30, 64, $host->getVar('lastname'));
		$formobjects['lastname']->setDescription(_wbc_mn_frm_lastname_desc);
		$formobjects['address1'] = new XoopsFormText(_wbc_mn_frm_address1, ''.$id.'[address1]', 40, 128, $host->getVar('address1'));
		$formobjects['address1']->setDescription(_wbc_mn_frm_address1_desc);
		$formobjects['address2'] = new XoopsFormText(_wbc_mn_frm_address2, ''.$id.'[address2]', 40, 128, $host->getVar('address2'));
		$formobjects['address2']->setDescription(_wbc_mn_frm_address2_desc);
		$formobjects['city'] = new XoopsFormText(_wbc_mn_frm_city, ''.$id.'[city]', 30, 64, $host->getVar('city'));
		$formobjects['city']->setDescription(_wbc_mn_frm_city_desc);
		$formobjects['state'] = new XoopsFormText(_wbc_mn_frm_state, ''.$id.'[state]', 10, 10, $host->getVar('state'));
		$formobjects['state']->setDescription(_wbc_mn_frm_state_desc);
		$formobjects['postcode'] = new XoopsFormText(_wbc_mn_frm_postcode, ''.$id.'[postcode]', 10, 10, $host->getVar('postcode'));
		$formobjects['postcode']->setDescription(_wbc_mn_frm_postcode_desc);
		$formobjects['country'] = new XoopsFormText(_wbc_mn_frm_country, ''.$id.'[country]', 5, 3, $host->getVar('country'));
		$formobjects['country']->setDescription(_wbc_mn_frm_country_desc);
		$formobjects['phone'] = new XoopsFormText(_wbc_mn_frm_phone, ''.$id.'[phone]', 20, 32, $host->getVar('phone'));
		$formobjects['phone']->setDescription(_wbc_mn_frm_phone_desc);
		$formobjects['age'] = new XoopsFormText(_wbc_mn_frm_age, ''.$id.'[age]', 5, 8, $host->getVar('age'));
		$formobjects['age']->setDescription(_wbc_mn_frm_age_desc);
		$formobjects['pref'] = new XoopsFormText(_wbc_mn_frm_pref, ''.$id.'[pref]', 30, 64, $host->getVar('pref'));
		$formobjects['pref']->setDescription(_wbc_mn_frm_pref_desc);
		$formobjects['local'] = new XoopsFormText(_wbc_mn_frm_local, ''.$id.'[local]', 40, 128, $host->getVar('local'));
		$formobjects['local']->setDescription(_wbc_mn_frm_local_desc);
		$formobjects['likes'] = new XoopsFormText(_wbc_mn_frm_likes, ''.$id.'[likes]', 40, 100, $host->getVar('likes'));
		$formobjects['likes']->setDescription(_wbc_mn_frm_likes_desc);
		$formobjects['dislikes'] = new XoopsFormText(_wbc_mn_frm_dislikes, ''.$id.'[dislikes]', 40, 100, $host->getVar('dislikes'));
		$formobjects['dislikes']->setDescription(_wbc_mn_frm_dislikes_desc);
		$formobjects['bio'] = new XoopsFormText(_wbc_mn_frm_bio, ''.$id.'[bio]', 40, 2048, $host->getVar('bio'));
		$formobjects['bio']->setDescription(_wbc_mn_frm_bio_desc);
		$formobjects['chat'] = new XoopsFormText(_wbc_mn_frm_chat, ''.$id.'[chat]', 40, 256, $host->getVar('chat'));
		$formobjects['chat']->setDescription(_wbc_mn_frm_chat_desc);
		$formobjects['languages'] = new WebcamsFormSelectLanguages(_wbc_mn_frm_languages, ''.$id.'[languages][]', $host->getVar('languages'), 7, true);
		$formobjects['languages']->setDescription(_wbc_mn_frm_languages_desc);
		$formobjects['category'] = new WebcamsFormSelectCategory(_wbc_mn_frm_category, ''.$id.'[category][]', $host->getVar('category'), 6, true);
		$formobjects['category']->setDescription(_wbc_mn_frm_category_desc);
		$formobjects['timezone'] = new WebcamsFormSelectTimezone(_wbc_mn_frm_timezone, ''.$id.'[timezone]', $host->getVar('timezone'));
		$formobjects['timezone']->setDescription(_wbc_mn_frm_timezone_desc);
		

		$formobjects['id'] = new XoopsFormHidden('id', $id);
											
		$required = array('user', 'pass', 'email', 'category', 'languages');
		
		foreach($formobjects as $id =>$formobject)
			if (!in_array($id, $required))
				$form->addElement($formobjects[$id], false);
			else
				$form->addElement($formobjects[$id], true);
	
		$form->addElement(new XoopsFormHidden("op", 'save'));
		$form->addElement(new XoopsFormHidden("fct", 'host'));
		$form->addElement(new XoopsFormButton('', 'save_list', _SUBMIT, "submit"));
		echo $form->render();
		
	}

	function webcams_admin_user_edit($id)
	{

		$user_handler =& xoops_getmodulehandler('user', 'webcams');

		if ($id<>0)
			$user = $user_handler->get($id, true);
		else
			$user = $user_handler->create();


		if ($id<>0)
			$form = new XoopsThemeForm(_wbc_am_frm_edit_user, "user", "", "post");
		else
			$form = new XoopsThemeForm(_wbc_am_frm_add_user, "user", "", "post");
		
		$formobjects['email'] = new XoopsFormText(_wbc_am_frm_email, ''.$id.'[email]', 40, 255, $user->getVar('email'));
		$formobjects['email']->setDescription(_wbc_am_frm_email_desc);		
		$formobjects['user'] = new XoopsFormText(_wbc_am_frm_user, ''.$id.'[user]', 20, 23, $user->getVar('user'));
		$formobjects['user']->setDescription(_wbc_am_frm_user_desc);
		$formobjects['pass'] = new XoopsFormText(_wbc_am_frm_pass, ''.$id.'[pass]', 20, 23, $user->getVar('pass'));
		$formobjects['pass']->setDescription(_wbc_am_frm_pass_desc);
		$formobjects['firstname'] = new XoopsFormText(_wbc_am_frm_firstname, ''.$id.'[firstname]', 30, 64, $user->getVar('firstname'));
		$formobjects['firstname']->setDescription(_wbc_am_frm_firstname_desc);
		$formobjects['lastname'] = new XoopsFormText(_wbc_am_frm_lastname, ''.$id.'[lastname]', 30, 64, $user->getVar('lastname'));
		$formobjects['lastname']->setDescription(_wbc_am_frm_lastname_desc);
		$formobjects['address1'] = new XoopsFormText(_wbc_am_frm_address1, ''.$id.'[address1]', 40, 128, $user->getVar('address1'));
		$formobjects['address1']->setDescription(_wbc_am_frm_address1_desc);
		$formobjects['address2'] = new XoopsFormText(_wbc_am_frm_address2, ''.$id.'[address2]', 40, 128, $user->getVar('address2'));
		$formobjects['address2']->setDescription(_wbc_am_frm_address2_desc);
		$formobjects['city'] = new XoopsFormText(_wbc_am_frm_city, ''.$id.'[city]', 30, 64, $user->getVar('city'));
		$formobjects['city']->setDescription(_wbc_am_frm_city_desc);
		$formobjects['state'] = new XoopsFormText(_wbc_am_frm_state, ''.$id.'[state]', 10, 10, $user->getVar('state'));
		$formobjects['state']->setDescription(_wbc_am_frm_state_desc);
		$formobjects['postcode'] = new XoopsFormText(_wbc_am_frm_postcode, ''.$id.'[postcode]', 10, 10, $user->getVar('postcode'));
		$formobjects['postcode']->setDescription(_wbc_am_frm_postcode_desc);
		$formobjects['country'] = new XoopsFormText(_wbc_am_frm_country, ''.$id.'[country]', 5, 3, $user->getVar('country'));
		$formobjects['country']->setDescription(_wbc_am_frm_country_desc);
		

		$formobjects['id'] = new XoopsFormHidden('id', $id);
											
		$required = array('user', 'pass', 'email');
		
		foreach($formobjects as $id =>$formobject)
			if (!in_array($id, $required))
				$form->addElement($formobjects[$id], false);
			else
				$form->addElement($formobjects[$id], true);
	
		$form->addElement(new XoopsFormHidden("op", 'save'));
		$form->addElement(new XoopsFormHidden("fct", 'user'));
		$form->addElement(new XoopsFormButton('', 'save_list', _SUBMIT, "submit"));
		echo $form->render();
		
	}

	function webcams_user_user_edit($id)
	{

		$user_handler =& xoops_getmodulehandler('user', 'webcams');

		if ($id<>0)
			$user = $user_handler->get($id, true);
		else
			$user = $user_handler->create();


		if ($id<>0)
			$form = new XoopsThemeForm(_wbc_mn_frm_edit_user, "user", "", "post");
		else
			$form = new XoopsThemeForm(_wbc_mn_frm_add_user, "user", "", "post");
		
		$formobjects['email'] = new XoopsFormText(_wbc_mn_frm_email, ''.$id.'[email]', 40, 255, $user->getVar('email'));
		$formobjects['email']->setDescription(_wbc_mn_frm_email_desc);		
		$formobjects['user'] = new XoopsFormText(_wbc_mn_frm_user, ''.$id.'[user]', 20, 23, $user->getVar('user'));
		$formobjects['user']->setDescription(_wbc_mn_frm_user_desc);
		$formobjects['pass'] = new XoopsFormText(_wbc_mn_frm_pass, ''.$id.'[pass]', 20, 23, $user->getVar('pass'));
		$formobjects['pass']->setDescription(_wbc_mn_frm_pass_desc);
		$formobjects['firstname'] = new XoopsFormText(_wbc_mn_frm_firstname, ''.$id.'[firstname]', 30, 64, $user->getVar('firstname'));
		$formobjects['firstname']->setDescription(_wbc_mn_frm_firstname_desc);
		$formobjects['lastname'] = new XoopsFormText(_wbc_mn_frm_lastname, ''.$id.'[lastname]', 30, 64, $user->getVar('lastname'));
		$formobjects['lastname']->setDescription(_wbc_mn_frm_lastname_desc);
		$formobjects['address1'] = new XoopsFormText(_wbc_mn_frm_address1, ''.$id.'[address1]', 40, 128, $user->getVar('address1'));
		$formobjects['address1']->setDescription(_wbc_mn_frm_address1_desc);
		$formobjects['address2'] = new XoopsFormText(_wbc_mn_frm_address2, ''.$id.'[address2]', 40, 128, $user->getVar('address2'));
		$formobjects['address2']->setDescription(_wbc_mn_frm_address2_desc);
		$formobjects['city'] = new XoopsFormText(_wbc_mn_frm_city, ''.$id.'[city]', 30, 64, $user->getVar('city'));
		$formobjects['city']->setDescription(_wbc_mn_frm_city_desc);
		$formobjects['state'] = new XoopsFormText(_wbc_mn_frm_state, ''.$id.'[state]', 10, 10, $user->getVar('state'));
		$formobjects['state']->setDescription(_wbc_mn_frm_state_desc);
		$formobjects['postcode'] = new XoopsFormText(_wbc_mn_frm_postcode, ''.$id.'[postcode]', 10, 10, $user->getVar('postcode'));
		$formobjects['postcode']->setDescription(_wbc_mn_frm_postcode_desc);
		$formobjects['country'] = new XoopsFormText(_wbc_mn_frm_country, ''.$id.'[country]', 5, 3, $user->getVar('country'));
		$formobjects['country']->setDescription(_wbc_mn_frm_country_desc);
		

		$formobjects['id'] = new XoopsFormHidden('id', $id);
											
		$required = array('user', 'pass', 'email');
		
		foreach($formobjects as $id =>$formobject)
			if (!in_array($id, $required))
				$form->addElement($formobjects[$id], false);
			else
				$form->addElement($formobjects[$id], true);
	
		$form->addElement(new XoopsFormHidden("op", 'save'));
		$form->addElement(new XoopsFormHidden("fct", 'user'));
		$form->addElement(new XoopsFormButton('', 'save_list', _SUBMIT, "submit"));
		echo $form->render();
		
	}
	
	function webcams_admin_studio_edit($id)
	{

		$studio_handler =& xoops_getmodulehandler('studio', 'webcams');

		if ($id<>0)
			$studio = $studio_handler->get($id, true);
		else
			$studio = $studio_handler->create();


		if ($id<>0)
			$form = new XoopsThemeForm(_wbc_am_frm_edit_studio, "studio", "", "post");
		else
			$form = new XoopsThemeForm(_wbc_am_frm_add_studio, "studio", "", "post");
		
		$formobjects['email'] = new XoopsFormText(_wbc_am_frm_email, ''.$id.'[email]', 40, 255, $studio->getVar('email'));
		$formobjects['email']->setDescription(_wbc_am_frm_email_desc);		
		$formobjects['studioname'] = new XoopsFormText(_wbc_am_frm_studioname, ''.$id.'[studioname]', 40, 128, $studio->getVar('studioname'));
		$formobjects['studioname']->setDescription(_wbc_am_frm_studioname_desc);		
		$formobjects['firstname'] = new XoopsFormText(_wbc_am_frm_firstname, ''.$id.'[firstname]', 30, 64, $studio->getVar('firstname'));
		$formobjects['firstname']->setDescription(_wbc_am_frm_firstname_desc);
		$formobjects['lastname'] = new XoopsFormText(_wbc_am_frm_lastname, ''.$id.'[lastname]', 30, 64, $studio->getVar('lastname'));
		$formobjects['lastname']->setDescription(_wbc_am_frm_lastname_desc);
		$formobjects['address1'] = new XoopsFormText(_wbc_am_frm_address1, ''.$id.'[address1]', 40, 128, $studio->getVar('address1'));
		$formobjects['address1']->setDescription(_wbc_am_frm_address1_desc);
		$formobjects['address2'] = new XoopsFormText(_wbc_am_frm_address2, ''.$id.'[address2]', 40, 128, $studio->getVar('address2'));
		$formobjects['address2']->setDescription(_wbc_am_frm_address2_desc);
		$formobjects['city'] = new XoopsFormText(_wbc_am_frm_city, ''.$id.'[city]', 30, 64, $studio->getVar('city'));
		$formobjects['city']->setDescription(_wbc_am_frm_city_desc);
		$formobjects['state'] = new XoopsFormText(_wbc_am_frm_state, ''.$id.'[state]', 10, 10, $studio->getVar('state'));
		$formobjects['state']->setDescription(_wbc_am_frm_state_desc);
		$formobjects['postcode'] = new XoopsFormText(_wbc_am_frm_postcode, ''.$id.'[postcode]', 10, 10, $studio->getVar('postcode'));
		$formobjects['postcode']->setDescription(_wbc_am_frm_postcode_desc);
		$formobjects['country'] = new XoopsFormText(_wbc_am_frm_country, ''.$id.'[country]', 5, 3, $studio->getVar('country'));
		$formobjects['country']->setDescription(_wbc_am_frm_country_desc);
		$formobjects['pos_bias'] = new XoopsFormText(_wbc_am_frm_pos_bias, ''.$id.'[pos_bias]', 3, 8, $studio->getVar('pos_bias'));
		$formobjects['pos_bias']->setDescription(_wbc_am_frm_pos_bias_desc);
		$formobjects['allow_create_host'] = new XoopsFormRadioYN(_wbc_am_frm_allow_create_host, ''.$id.'[allow_create_host]', $studio->getVar('allow_create_host'));
		$formobjects['allow_create_host']->setDescription(_wbc_am_frm_allow_create_host_desc);
		$formobjects['com2'] = new XoopsFormText(_wbc_am_frm_com2, ''.$id.'[com2]', 10, 11, $studio->getVar('com2'));
		$formobjects['com2']->setDescription(_wbc_am_frm_com2_desc);
		$formobjects['com3'] = new XoopsFormText(_wbc_am_frm_com3, ''.$id.'[com3]', 10, 11, $studio->getVar('com3'));
		$formobjects['com3']->setDescription(_wbc_am_frm_com3_desc);
		$formobjects['tip2'] = new XoopsFormText(_wbc_am_frm_tip2, ''.$id.'[tip2]', 10, 11, $studio->getVar('tip2'));
		$formobjects['tip2']->setDescription(_wbc_am_frm_tip2_desc);
		$formobjects['com3'] = new XoopsFormText(_wbc_am_frm_tip3, ''.$id.'[tip3]', 10, 11, $studio->getVar('tip3'));
		$formobjects['com3']->setDescription(_wbc_am_frm_tip3_desc);
				
		$formobjects['id'] = new XoopsFormHidden('id', $id);
											
		$required = array('user', 'pass', 'email');
		
		foreach($formobjects as $id =>$formobject)
			if (!in_array($id, $required))
				$form->addElement($formobjects[$id], false);
			else
				$form->addElement($formobjects[$id], true);
	
		$form->addElement(new XoopsFormHidden("op", 'save'));
		$form->addElement(new XoopsFormHidden("fct", 'studio'));
		$form->addElement(new XoopsFormButton('', 'save_list', _SUBMIT, "submit"));
		echo $form->render();
		
	}

	function webcams_user_studio_edit($id)
	{

		$studio_handler =& xoops_getmodulehandler('studio', 'webcams');

		if ($id<>0)
			$studio = $studio_handler->get($id, true);
		else
			$studio = $studio_handler->create();


		if ($id<>0)
			$form = new XoopsThemeForm(_wbc_mn_frm_edit_studio, "studio", "", "post");
		else
			$form = new XoopsThemeForm(_wbc_mn_frm_add_studio, "studio", "", "post");
		
		$formobjects['email'] = new XoopsFormText(_wbc_mn_frm_email, ''.$id.'[email]', 40, 255, $studio->getVar('email'));
		$formobjects['email']->setDescription(_wbc_mn_frm_email_desc);		
		$formobjects['studioname'] = new XoopsFormText(_wbc_mn_frm_studioname, ''.$id.'[studioname]', 40, 128, $studio->getVar('studioname'));
		$formobjects['studioname']->setDescription(_wbc_mn_frm_studioname_desc);		
		$formobjects['firstname'] = new XoopsFormText(_wbc_mn_frm_firstname, ''.$id.'[firstname]', 30, 64, $studio->getVar('firstname'));
		$formobjects['firstname']->setDescription(_wbc_mn_frm_firstname_desc);
		$formobjects['lastname'] = new XoopsFormText(_wbc_mn_frm_lastname, ''.$id.'[lastname]', 30, 64, $studio->getVar('lastname'));
		$formobjects['lastname']->setDescription(_wbc_mn_frm_lastname_desc);
		$formobjects['address1'] = new XoopsFormText(_wbc_mn_frm_address1, ''.$id.'[address1]', 40, 128, $studio->getVar('address1'));
		$formobjects['address1']->setDescription(_wbc_mn_frm_address1_desc);
		$formobjects['address2'] = new XoopsFormText(_wbc_mn_frm_address2, ''.$id.'[address2]', 40, 128, $studio->getVar('address2'));
		$formobjects['address2']->setDescription(_wbc_mn_frm_address2_desc);
		$formobjects['city'] = new XoopsFormText(_wbc_mn_frm_city, ''.$id.'[city]', 30, 64, $studio->getVar('city'));
		$formobjects['city']->setDescription(_wbc_mn_frm_city_desc);
		$formobjects['state'] = new XoopsFormText(_wbc_mn_frm_state, ''.$id.'[state]', 10, 10, $studio->getVar('state'));
		$formobjects['state']->setDescription(_wbc_mn_frm_state_desc);
		$formobjects['postcode'] = new XoopsFormText(_wbc_mn_frm_postcode, ''.$id.'[postcode]', 10, 10, $studio->getVar('postcode'));
		$formobjects['postcode']->setDescription(_wbc_mn_frm_postcode_desc);
		$formobjects['country'] = new XoopsFormText(_wbc_mn_frm_country, ''.$id.'[country]', 5, 3, $studio->getVar('country'));
		$formobjects['country']->setDescription(_wbc_mn_frm_country_desc);
				

		$formobjects['id'] = new XoopsFormHidden('id', $id);
											
		$required = array('studioname', 'email');
		
		foreach($formobjects as $id =>$formobject)
			if (!in_array($id, $required))
				$form->addElement($formobjects[$id], false);
			else
				$form->addElement($formobjects[$id], true);
	
		$form->addElement(new XoopsFormHidden("op", 'save'));
		$form->addElement(new XoopsFormHidden("fct", 'studio'));
		$form->addElement(new XoopsFormButton('', 'save_list', _SUBMIT, "submit"));
		echo $form->render();
		
	}
	
?>