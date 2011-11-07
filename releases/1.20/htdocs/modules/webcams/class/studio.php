<?php
if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}
/**
 * Class for Spiders
 * @author Simon Roberts (simon@xoops.org)
 * @copyright copyright (c) 2000-2009 XOOPS.org
 * @package kernel
 */
class WebcamsStudio extends XoopsObject
{

    function WebcamsStudio($fid = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('status', XOBJ_DTYPE_ENUM, 'waiting', false, false, false, array('approved','waiting','closed'));
        $this->initVar('studioname', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('firstname', XOBJ_DTYPE_TXTBOX, null, false, 64);
        $this->initVar('lastname', XOBJ_DTYPE_TXTBOX, null, false, 64);
        $this->initVar('address1', XOBJ_DTYPE_TXTBOX, null, false, 128);
        $this->initVar('address2', XOBJ_DTYPE_TXTBOX, null, false, 128);
        $this->initVar('city', XOBJ_DTYPE_TXTBOX, null, false, 64);
        $this->initVar('state', XOBJ_DTYPE_TXTBOX, null, false, 10);
        $this->initVar('postcode', XOBJ_DTYPE_TXTBOX, null, false, 10);
        $this->initVar('country', XOBJ_DTYPE_TXTBOX, null, false, 3);
    	$this->initVar('email', XOBJ_DTYPE_TXTBOX, null, false, 32);
    	$this->initVar('enabled', XOBJ_DTYPE_INT, 0, false);
    	$this->initVar('pos_bias', XOBJ_DTYPE_INT, 10, false);
    	$this->initVar('allow_create_host', XOBJ_DTYPE_INT, 0, false);
    	$this->initVar('com2', XOBJ_DTYPE_DECIMAL, $this->_modConfig['com2'], false);
    	$this->initVar('com3', XOBJ_DTYPE_DECIMAL, $this->_modConfig['com3'], false);
    	$this->initVar('tip2', XOBJ_DTYPE_DECIMAL, $this->_modConfig['tip2'], false);
    	$this->initVar('tip3', XOBJ_DTYPE_DECIMAL, $this->_modConfig['tip3'], false);
    	$this->initVar('created', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('updated', XOBJ_DTYPE_INT, 0, false);
    }

	function runPlugin() {

		include_once($GLOBALS['xoops']->path('/modules/webcams/plugin/'.$invoice->getVar('status').'.php'));
		
		switch ($invoice->getVar('status')) {
			case 'waiting':
			case 'approved';
			case 'closed':
				$func = ucfirst($this->getVar('status')).'StudioHook';
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
* XOOPS Spider handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@xoops.org>
* @package kernel
*/
class WebcamsStudioHandler extends XoopsPersistableObjectHandler
{
    var $_mod;
	var $_modConfig;
	
	function __construct(&$db) 
    {
        parent::__construct($db, "webcams_studio", 'WebcamsStudio', "id", "host_id");
        
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
    		$object->setVar('created', time());
    		$action='studio_create';
    	} else { 
    		$object->setVar('updated', time());
    		$action='studio_update';
    		$param[] = "studio_id=".$object->getVar('studio_id');
    	}
    	
   	   	$runplugin=false;
    	if ($object->vars['status']['changed']==true) {
    		$runplugin=true;
    	}
    	
   	    switch ($object->getVars('status')) {
    		case 'approved':
    			$param[] = "enabled=1";
    			break;
    		default:
    			$param[] = "enabled=0";
    			break;
    	}    	
    	  	   		
   		foreach($this->apifields($action) as $apifield=>$field)
    		if (is_array($object->getVar($field)))
    			$param[] = "$apifield=".implode(',',$object->getVar($field));
    		else
    			$param[] = "$apifield=".$object->getVar($field);
    			    		
    	$result = sendPost($this->_modConfig['gateway_ip'],'action='.$action.'&'.implode('&', $param),true);

    	if(stristr($result['message'],'ok:Studio created')||stristr($result['message'],'ok:Studio updated'))
    	{
    		if ($action=='studio_create')
				$object->setVar('studio_id', $result['studio_id']);
							
			$id = parent::insert($object, $force);
			if ($action=='studio_create') {
				$pivot_handler =& xoops_getmodulehandler('pivot', 'webcams');
				$pivot = $pivot_handler->create();
				$pivot->setVar('type', 'studio');
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
        
    private function apifields($action='studio_create')
    {
    	switch ($action) {
    		case "studio_create":    		
    		case "studio_update":
		    	return array(	'email'=>'email', 'first_name'=>'firstname', 'last_name'=>'lastname', 'address1'=>'address1', 'address2'=>'address2', 'city'=>'city', 
		    					'state'=>'state', 'zip'=>'postcode', 'studio_name'=>'studioname', 'pos_bias'=>'pos_bias', 'allow_create_host' => 'allow_create_host',
		    					'com2'=>'com2', 'com3'=>'com3','tip2'=>'tip2', 'tip3'=>'tip3'  
		    				);	    			
    			break;
    	}
    }
}
?>