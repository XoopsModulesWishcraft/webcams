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
class WebcamsUser extends XoopsObject
{

    function WebcamsUser($fid = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('user_id', XOBJ_DTYPE_INT, 0, false);
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
        $this->initVar('created', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('updated', XOBJ_DTYPE_INT, 0, false);
    }


}


/**
* XOOPS Webcam handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@xoops.org>
* @package kernel
*/
class WebcamsUserHandler extends XoopsPersistableObjectHandler
{
    var $_mod;
	var $_modConfig;
	
	function __construct(&$db) 
    {
        parent::__construct($db, "webcams_user", 'WebcamsUser', "id", "user_id");
        
        $module_handler =& xoops_gethandler( 'module' );
		$config_handler =& xoops_gethandler( 'config' );
		$this->_mod =& $module_handler->getByDirname('webcams');
		$this->_modConfig = $config_handler->getConfigList($this->_mod->getVar('mid')); 
    }
    
    
    function insert($object, $force=true) {
    	
    	$param=array();
    	$param[] = "account_id=".$this->_modConfig['account_id'];
    	$param[] = "gateway_pass=".$this->_modConfig['gateway_pass'];
    	
    	if ($object->isNew()) {
	    	$params = '&action=user_info_request';
			$params .= '&account_id='.$this->_modConfig['account_id'];
			$params .= '&gateway_pass='.$this->_modConfig['gateway_pass'];
			$params .= '&user='.$object->getVar('user');
			$result = sendPost($this->_modConfig['gateway_ip'],$params,true);//use ssl	
	
			if(stristr($result['message'],'error:Username Not Found')){
	    		$object->setVar('created', time());
	    		$action='user_create';
	    		$param[] = "user=".$object->getVar('user');
	    		$param[] = "pass=".$object->getVar('pass');
			} else {
				if ($object->getVar('pass')==$result['pass']) {
					foreach($this->apifields() as $apifield=>$field)
						$object->setVar($field, $result[$apifield]);
					return parent::insert($object, $force);
				} else {
					$object->setErrors('API Error: User Exists');
					return false;
				}
			}
    	} else { 
    		$object->setVar('updated', time());
    		$action='user_update';
    		$param[] = "user_id=".$object->getVar('user_id');
    		if ($object->vars['user']['changed']==true)
    			$param[] = "new_username=".$object->getVar('user');

    		if ($object->vars['pass']['changed']==true)
    			$param[] = "pass=".$object->getVar('pass');
    		
    	}
    	  	   		
   		foreach($this->apifields($action) as $apifield=>$field)
    		if (is_array($object->getVar($field)))
    			$param[] = "$apifield=".implode(',',$object->getVar($field));
    		else
    			$param[] = "$apifield=".$object->getVar($field);
    			    		
    	$result = sendPost($this->_modConfig['gateway_ip'],'action='.$action.'&'.implode('&', $param),true);

    	if(stristr($result['message'],'ok:User Created')||stristr($result['message'],'ok:User Updated'))
    	{
    		if ($action=='user_create')
				$object->setVar('user_id', $result['user_id']);
							
			$id = parent::insert($object, $force);
			if ($action=='user_create') {
				$pivot_handler =& xoops_getmodulehandler('pivot', 'webcams');
				$pivot = $pivot_handler->create();
				$pivot->setVar('type', 'user');
				$pivot->setVar('id', $id);
				$pivot->setUserInfo();
				$pivot_handler->insert($pivot);
			}
			return $id;
		} else if(stristr($result['message'],'error:'))	{
			$object->setErrors('API '.$result['message']);
			return false;
		}
    }
        
    private function apifields($action='user_create')
    {
    	switch ($action) {
    		case "user_create":    		
    		case "user_update":
		    	return array(	'email'=>'email', 'first_name'=>'firstname', 'last_name'=>'lastname', 'address1'=>'address1', 'address2'=>'address2', 'city'=>'city', 
		    					'state'=>'state', 'zip'=>'postcode'
		    				);	    			
    			break;
    	}
    }
}
?>