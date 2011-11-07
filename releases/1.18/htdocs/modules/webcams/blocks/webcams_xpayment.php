<?php

	function webcams_xpayment_show($options) {
		xoops_loadLanguage('blocks', 'webcams');
		$ret= array();
		$ret['currency'] = $options[0];
		foreach(explode(',', $options[1]) as $id=> $amount) {
			$ret['amounts'][$id]['value'] = number_format($amount, 2);
			$ret['amounts'][$id]['text'] = $options[2].number_format($amount, 2);
		}	
		
		$user_handler =& xoops_getmodulehandler('user', 'webcams');
		$pivot_handler =& xoops_getmodulehandler('pivot', 'webcams');
		$pivot = $pivot_handler->getObjects($pivot_handler->getPivotCriteria(), false);
	
		if (is_object($pivot[0])) 
			if ($pivot[0]->getVar('type')=='user') {
				$user = $user_handler->get($pivot[0]->getVar('id'));
				$ret['key'] = $user->getVar('user_id'); 	
			} else {
				return false;
			}
		else 
			return false;
			
		return $ret;
	}
	
	function webcams_xpayment_edit($options) {
		xoops_loadLanguage('blocks', 'webcams');
		$form = _wbc_block_isocurreny." <input type='text' name='options[]' value='".$options[0]."' size='4' maxlen='3' /><br/>";
		$form .= _wbc_block_amounts." <input type='text' name='options[]' value='".$options[1]."' size='35' maxlen='128' /><br/>";
		$form .= _wbc_block_symbol." <input type='text' name='options[]' value='".$options[2]."' size='2' maxlen='1' />";
		return $form;
	}
	
?>