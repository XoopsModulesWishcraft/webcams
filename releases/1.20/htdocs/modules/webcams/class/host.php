<?php
if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

include_once('global.php');

/**
 * Class for Webcams
 * @author Simon Roberts (simon@xoops.org)
 * @copyright copyright (c) 2000-2009 XOOPS.org
 * @package kernel
 */
class WebcamsHost extends XoopsObject
{

    function WebcamsHost($fid = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('status', XOBJ_DTYPE_ENUM, 'waiting', false, false, false, array('approved','waiting','closed'));
        $this->initVar('host_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('user', XOBJ_DTYPE_TXTBOX, null, false, 20);
        $this->initVar('pass', XOBJ_DTYPE_TXTBOX, null, false, 20);
        $this->initVar('firstname', XOBJ_DTYPE_TXTBOX, null, false, 64);
        $this->initVar('lastname', XOBJ_DTYPE_TXTBOX, null, false, 64);
        $this->initVar('address1', XOBJ_DTYPE_TXTBOX, null, false, 128);
        $this->initVar('address2', XOBJ_DTYPE_TXTBOX, null, false, 128);
        $this->initVar('city', XOBJ_DTYPE_TXTBOX, null, false, 64);
        $this->initVar('state', XOBJ_DTYPE_TXTBOX, null, false, 10);
        $this->initVar('postcode', XOBJ_DTYPE_TXTBOX, null, false, 10);
        $this->initVar('country', XOBJ_DTYPE_TXTBOX, null, false, 3);
        $this->initVar('phone', XOBJ_DTYPE_TXTBOX, null, false, 32);
        $this->initVar('age', XOBJ_DTYPE_INT, 0, false);
    	$this->initVar('pref', XOBJ_DTYPE_TXTBOX, null, false, 64);
    	$this->initVar('local', XOBJ_DTYPE_TXTBOX, null, false, 128);
    	$this->initVar('likes', XOBJ_DTYPE_TXTBOX, null, false, 100);
    	$this->initVar('dislikes', XOBJ_DTYPE_TXTBOX, null, false, 100);
    	$this->initVar('bio', XOBJ_DTYPE_TXTBOX, null, false, 2048);
    	$this->initVar('chat', XOBJ_DTYPE_TXTBOX, null, false, 256);
    	$this->initVar('languages', XOBJ_DTYPE_ARRAY, null, false);
    	$this->initVar('category', XOBJ_DTYPE_ARRAY, null, false);
    	$this->initVar('schedule', XOBJ_DTYPE_TXTBOX, $this->_modConfig['schedule'], false, 1000);
    	$this->initVar('timezone', XOBJ_DTYPE_TXTBOX, $this->_modConfig['timezone'], false, 128);
    	$this->initVar('email', XOBJ_DTYPE_TXTBOX, null, false, 255);
    	$this->initVar('max_time', XOBJ_DTYPE_INT, $this->_modConfig['max_time'], false);
    	$this->initVar('max_time_total', XOBJ_DTYPE_INT, $this->_modConfig['max_time_total'], false);
    	$this->initVar('max_time_total_period', XOBJ_DTYPE_INT, $this->_modConfig['max_time_total_period'], false);
    	$this->initVar('mode1', XOBJ_DTYPE_INT, $this->_modConfig['mode1'], false);
    	$this->initVar('mode2', XOBJ_DTYPE_INT, $this->_modConfig['mode2'], false);
    	$this->initVar('mode3', XOBJ_DTYPE_INT, $this->_modConfig['mode3'], false);
    	$this->initVar('allow_guest', XOBJ_DTYPE_INT, $this->_modConfig['allow_guest'], false);
    	$this->initVar('pay2', XOBJ_DTYPE_INT, $this->_modConfig['pay2'], false);
    	$this->initVar('pay3', XOBJ_DTYPE_INT, $this->_modConfig['pay3'], false);
    	$this->initVar('com2', XOBJ_DTYPE_INT, $this->_modConfig['com2'], false);
    	$this->initVar('com3', XOBJ_DTYPE_INT, $this->_modConfig['com3'], false);
    	$this->initVar('tip_com2', XOBJ_DTYPE_INT, $this->_modConfig['tip_com2'], false);
    	$this->initVar('tip_com3', XOBJ_DTYPE_INT, $this->_modConfig['tip_com3'], false);
    	$this->initVar('max_streams', XOBJ_DTYPE_INT, $this->_modConfig['max_streams'], false);
    	$this->initVar('view_user_bal', XOBJ_DTYPE_INT, $this->_modConfig['view_user_bal'], false);
    	$this->initVar('profile', XOBJ_DTYPE_INT, $this->_modConfig['profile'], false);
    	$this->initVar('media', XOBJ_DTYPE_INT, $this->_modConfig['media'], false);
    	$this->initVar('stats', XOBJ_DTYPE_INT, $this->_modConfig['stats'], false);
    	$this->initVar('aim_user', XOBJ_DTYPE_TXTBOX, null, false, 255);
    	$this->initVar('aim_pass', XOBJ_DTYPE_TXTBOX, null, false, 255);
    	$this->initVar('pos_bias', XOBJ_DTYPE_INT, $this->_modConfig['pos_bias'], false);
    	$this->initVar('allow_ban', XOBJ_DTYPE_INT, $this->_modConfig['allow_ban'], false);
    	$this->initVar('aux_link1_url', XOBJ_DTYPE_TXTBOX, null, false, 255);
    	$this->initVar('aux_link1_txt', XOBJ_DTYPE_TXTBOX, null, false, 255);
    	$this->initVar('aux_link2_url', XOBJ_DTYPE_TXTBOX, null, false, 255);
    	$this->initVar('aux_link2_txt', XOBJ_DTYPE_TXTBOX, null, false, 255);
    	$this->initVar('aux_link3_url', XOBJ_DTYPE_TXTBOX, null, false, 255);
    	$this->initVar('aux_link3_txt', XOBJ_DTYPE_TXTBOX, null, false, 255);
    	$this->initVar('studio_id', XOBJ_DTYPE_INT, $this->_modConfig['studio_id'], false);
    	$this->initVar('chat_only', XOBJ_DTYPE_INT, $this->_modConfig['chat_only'], false);
        $this->initVar('created', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('updated', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('actioned', XOBJ_DTYPE_INT, 0, false);
    }

	function runPlugin() {

		include_once($GLOBALS['xoops']->path('/modules/webcams/plugin/'.$invoice->getVar('status').'.php'));
		
		switch ($invoice->getVar('status')) {
			case 'waiting':
			case 'approved';
			case 'closed':
				$func = ucfirst($this->getVar('status')).'HostHook';
				break;
			default:
				return false;
				break;
		}
		
		if (function_exists($func))  {
			return @$func($this);
		}

		return true;
	}
}


/**
* XOOPS Webcams handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@xoops.org>
* @package kernel
*/
class WebcamsHostHandler extends XoopsPersistableObjectHandler
{
	var $_mod;
	var $_modConfig;
	
    function __construct(&$db) 
    {
        parent::__construct($db, "webcams_host", 'WebcamsHost', "id", "host_id");
       	
        $module_handler =& xoops_gethandler( 'module' );
		$config_handler =& xoops_gethandler( 'config' );
		$this->_mod =& $module_handler->getByDirname('webcams');
		$this->_modConfig = $config_handler->getConfigList($this->_mod->getVar('mid')); 
    }

    function delete($object, $force=true) {

    	if (!is_a($object, 'WebcamsHost'))
    		return false;
    	
    	$param=array();
    	$param[] = "action=host_delete";
    	$param[] = "account_id=".$this->_modConfig['account_id'];
    	$param[] = "gateway_pass=".$this->_modConfig['gateway_pass'];
    	$param[] = "host_id=".$object->getVar('host_id');
    	
    	$result = sendPost($this->_modConfig['gateway_ip'],implode('&', $param),true);
	
		if(stristr($result['message'],'ok:Host deleted')){	// Host has been completely deleted 
			parent::delete($object, $force);
		}else if(stristr($result['message'],'error:')){// // error, handle it somehow, all errors start with "error:"
			$object->setErrors('API '.$result['message']);
			return false;		
		}
    }
    
    function insert($object, $force=true) {
    	
    	$param=array();
    	$param[] = "account_id=".$this->_modConfig['account_id'];
    	$param[] = "gateway_pass=".$this->_modConfig['gateway_pass'];
    	
    	if ($object->isNew()) {
    		$object->setVar('created', time());
    		$action='host_create';
    		$param[] = "user=".$object->getVar('user');
    		$param[] = "pass=".$object->getVar('pass');
    	} else { 
    		$object->setVar('updated', time());
    		$action='host_update';
    		$param[] = "host_id=".$object->getVar('host_id');
    		if ($object->vars['user']['changed']==true)
    			$param[] = "new_username=".$object->getVar('user');

    		if ($object->vars['pass']['changed']==true)
    			$param[] = "pass=".$object->getVar('pass');
    		
    	}
    	
    	switch ($object->getVars('status')) {
    		case 'approved':
    			$param[] = "enabled=1";
    			break;
    		default:
    			$param[] = "enabled=0";
    			break;
    	}
    	
    	$runplugin=false;
    	if ($object->vars['status']['changed']==true) {
    		$object->setVar('actioned', time());
    		$runplugin=true;
    	}
    	
   		foreach($this->apifields($action) as $apifield=>$field)
    		if (is_array($object->getVar($field)))
    			$param[] = "$apifield=".implode(',',$object->getVar($field));
    		else
    			$param[] = "$apifield=".$object->getVar($field);
    			    		
    	$result = sendPost($this->_modConfig['gateway_ip'],'action='.$action.'&'.implode('&', $param),true);
    	if(stristr($result['message'],'ok:Host created')||stristr($result['message'],'ok:Host updated'))
    	{
    		if ($action=='host_create')
				$object->setVar('host_id', $result['host_id']);
				
			$this->hostProfileUpdate($object);
			
			$id = parent::insert($object, $force);
			if ($action=='host_create') {
				$pivot_handler =& xoops_getmodulehandler('pivot', 'webcams');
				$pivot = $pivot_handler->create();
				$pivot->setVar('type', 'host');
				$pivot->setVar('id', $id);
				$pivot->setUserInfo();
				$pivot_handler->insert($pivot);
			}
			if ($runplugin==true)
				$object->runPlugin();
			return $id;
		} else if(stristr($result['message'],'error:'))	{
			$object->setErrors('API '.$result['message']);
			return false;
		}
    }
    
    private function hostProfileUpdate($object) {
		$param=array();
    	$param[] = "account_id=".$this->_modConfig['account_id'];
    	$param[] = "gateway_pass=".$this->_modConfig['gateway_pass'];
    	
   		$action='host_profile_update';
   		$param[] = "host_id=".$object->getVar('host_id');

   		foreach($this->apifields($action) as $apifield=>$field)
    		if (is_array($object->getVar($field)))
    			$param[] = "$apifield=".implode(',',$object->getVar($field));
    		else
    			$param[] = "$apifield=".$object->getVar($field);
    		
    	$result = sendPost($this->_modConfig['gateway_ip'],'action='.$action.'&'.implode('&', $param),true);

    	if(stristr($result['message'],'ok:Update OK'))
    	{
			return true;
		} else if(stristr($result['message'],'error:'))	{
			$object->setErrors('API '.$result['message']);
			return false;
		}
    	
    	
    }
    
    private function apifields($action='host_create')
    {
    	switch ($action) {
    		case "host_profile_update":
		    	return array(	'email'=>'email', 'first_name'=>'firstname', 'last_name'=>'lastname', 'address1'=>'address1', 'address2'=>'address2', 'city'=>'city', 
		    					'state'=>'state', 'zip'=>'postcode', 'country'=>'country', 'phone'=>'phone', 'age'=>'age', 'pref'=>'pref',
		    					'local'=>'local', 'likes'=>'likes', 'dislikes'=>'dislikes', 'bio_blurb'=>'bio', 'chat_blurb'=>'chat', 
		    					'languages_list'=>'languages', 'category_list'=>'category', 'schedule_list'=>'schedule', 'timezone'=>'timezone'
		    				);	    			
    			break;
    		case "host_update":
    		case "host_create":
		    	return array(	'max_time'=>'max_time','max_time_total'=>'max_time_total', 'max_time_total_period'=>'max_time_total_period', 
		    					'mode1'=>'mode1', 'mode2'=>'mode2', 'mode3'=>'mode3', 'allow_guest'=>'allow_guest', 'pay2'=>'pay2', 'pay3'=>'pay3', 
		    					'com2'=>'com2', 'com3'=>'com3', 'tip_com2'=>'tip_com2', 'tip_com3'=>'tip_com3', 'max_streams'=>'max_streams',  
		    					'view_user_bal'=>'view_user_bal','profile'=>'profile', 'media'=>'media', 'stats'=>'stats', 'aim_user'=>'aim_user', 
		    					'aim_pass'=>'aim_pass', 'pos_bias'=>'pos_bias', 'allow_ban'=>'allow_ban', 'aux_link1_url'=>'aux_link1_url', 
		    					'aux_link1_txt'=>'aux_link1_txt', 'aux_link2_url'=>'aux_link2_url', 'aux_link2_txt'=>'aux_link2_txt',  
		    					'aux_link3_url'=>'aux_link3_url', 'aux_link3_txt'=>'aux_link3_txt', 'studio_id'=>'studio_id','chat_only'=>'chat_only'
		    				);	    			
    			break;
    	}
    }
    
    function getByHostID($host_id) {
    	$criteria = new Criteria('host_id', $host_id);
    	if (!parent::getCount($criteria))
    		return false;
    	$objs = parent::getObjects($criteria, false);
    	if (is_object($objs[0]))
    		return $objs[0];
    	return false;
    }
}
?>