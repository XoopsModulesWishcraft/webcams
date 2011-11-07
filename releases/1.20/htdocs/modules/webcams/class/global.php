<?php
///// YOU MUST SET YOUR ACCOUNT INFO BELOW //////////////////////////////////////////////////////////////
$account_id = '';					//your Account ID
$gateway_ip = '';		//from Admin->MyAccount page, gateway info section, Gateway URL
$gateway_pass = '';		//from Admin->MyAccount page, gateway info section, Gateway Password

///// Only change if you are using .htaccess to control user management /////////////////////////////
$use_htaccess = false;					//set this to true if you are using .htaccess to control user management (CCBill)
$htaccess_member_homepage = '../../camlist.html';	//page to bounce them to once user has been updated in our database


////// DO NOT CHANGE ANYTHING BELOW UNLESS YOU KNOW EXACTLY WHAT YOU ARE DOING ////////////////////////
/*****************************************************************************************************
* sendPost() 
* Main function used to connect to our gateway api
* Returns a key=>val array
*****************************************************************************************************/
function sendPost($posturl, $params, $use_ssl)
{
	$posturl = is_file('../../crossdomain.xml') ? 'http://127.0.0.1/gateway/':$posturl;//ignore this
	
	if(!strstr($posturl,'://'))
		$posturl = 'http://'.$posturl;
	if(!strstr($posturl,'/gateway'))
		$posturl .= '/gateway/';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
	curl_setopt($ch, CURLOPT_TIMEOUT,30);
	
	if($use_ssl)
		$posturl = str_replace('http:','https:',$posturl);
	
	curl_setopt($ch, CURLOPT_URL,$posturl);
	
	if($use_ssl){
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	}	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
	$result = curl_exec($ch);
	curl_close ($ch);
	$array = array();
	$pieces = explode('&',$result);
	foreach($pieces as $val){
		if($val){
			$temp = explode('=',$val);
			$array[$temp[0]]=$temp[1];	
		}
	}	
	return $array;
}
?>