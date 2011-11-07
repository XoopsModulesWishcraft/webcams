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
class WebcamsPivot extends XoopsObject
{

    function WebcamsPivot($fid = null)
    {
        $this->initVar('pid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('type', XOBJ_DTYPE_ENUM, null, false, false, false, array('user','host','studio'));
        $this->initVar('id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('ip', XOBJ_DTYPE_TXTBOX, null, false, 128);
        $this->initVar('netaddr', XOBJ_DTYPE_TXTBOX, null, false, 255);
    }

    function setUserInfo() {
    	if (is_object($GLOBALS['xoopsUser']))
    		$this->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
    	else
    		$this->setVar('uid', 0);
    	
    	$ipdata = $this->getIPData();
    	$this->setVar('ip', $ipdata['ip']);
    	$this->setVar('netaddr', $ipdata['network-addy']);
    }

	private function getIPData($ip=false){
		$ret = array();
		if (is_object($GLOBALS['xoopsUser'])) {
			$ret['uid'] = $GLOBALS['xoopsUser']->getVar('uid');
			$ret['uname'] = $GLOBALS['xoopsUser']->getVar('uname');
		} else {
			$ret['uid'] = 0;
			$ret['uname'] = '';
		}
		if (!$ip) {
			if ($_SERVER["HTTP_X_FORWARDED_FOR"] != ""){ 
				$ip = (string)$_SERVER["HTTP_X_FORWARDED_FOR"]; 
				$ret['is_proxied'] = true;
				$proxy_ip = $_SERVER["REMOTE_ADDR"]; 
				$ret['network-addy'] = @gethostbyaddr($ip); 
				$ret['long'] = @ip2long($ip);
				if ($this->is_ipv6($ip)) {
					$ret['ip6'] = $ip;
					$ret['proxy-ip6'] = $proxy_ip;
				} else {
					$ret['ip4'] = $ip;
					$ret['proxy-ip4'] = $proxy_ip;
				}
				$ret['ip'] = $ip;
			}else{ 
				$ret['is_proxied'] = false;
				$ip = (string)$_SERVER["REMOTE_ADDR"]; 
				$ret['network-addy'] = @gethostbyaddr($ip); 
				$ret['long'] = @ip2long($ip);
				if ($this->is_ipv6($ip)) {
					$ret['ip6'] = $ip;
				} else {
					$ret['ip4'] = $ip;
				}
				$ret['ip'] = $ip;
			} 
		} else {
			$ret['is_proxied'] = false;
			$ret['network-addy'] = @gethostbyaddr($ip); 
			$ret['long'] = @ip2long($ip);
			if ($this->is_ipv6($ip)) {
				$ret['ip6'] = $ip;
			} else {
				$ret['ip4'] = $ip;
			}
			$ret['ip'] = $ip;
		}
		$ret['made'] = time();				
		return $ret;
	}

	private function is_ipv6($ip = "") 
	{ 
		if ($ip == "") 
			return false;
			
		if (substr_count($ip,":") > 0){ 
			return true; 
		} else { 
			return false; 
		} 
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
class WebcamsPivotHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
        parent::__construct($db, "webcams_pivot", 'WebcamsPivot', "pid", "type");
    }
    
    function insert($object, $force = true) {
    	$ipdata = $this->getIPData();
    	if ($GLOBALS['xoopsUser'])
    		$object->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
    	$object->setVar('ip', $ipdata['ip']);
    	$object->setVar('netaddr', $ipdata['network-addy']);
    	return parent::insert($object, $force);
    }
    
    function getPivotCriteria()
    {
    	$criteria = new CriteriaCompo();
    	if (is_object($GLOBALS['xoopsUser']))
    		$criteria->add(new Criteria('uid', $GLOBALS['xoopsUser']->getVar('uid')));
    	else {
    		$ipdata = $this->getIPData();
    		$criteria->add(new Criteria('ip', $ipdata['ip']));
    		$criteria->add(new Criteria('netaddr', $ipdata['network-addy']));
    	}
    	return $criteria;
    }

	private function getIPData($ip=false){
		$ret = array();
		if (is_object($GLOBALS['xoopsUser'])) {
			$ret['uid'] = $GLOBALS['xoopsUser']->getVar('uid');
			$ret['uname'] = $GLOBALS['xoopsUser']->getVar('uname');
		} else {
			$ret['uid'] = 0;
			$ret['uname'] = '';
		}
		if (!$ip) {
			if ($_SERVER["HTTP_X_FORWARDED_FOR"] != ""){ 
				$ip = (string)$_SERVER["HTTP_X_FORWARDED_FOR"]; 
				$ret['is_proxied'] = true;
				$proxy_ip = $_SERVER["REMOTE_ADDR"]; 
				$ret['network-addy'] = @gethostbyaddr($ip); 
				$ret['long'] = @ip2long($ip);
				if ($this->is_ipv6($ip)) {
					$ret['ip6'] = $ip;
					$ret['proxy-ip6'] = $proxy_ip;
				} else {
					$ret['ip4'] = $ip;
					$ret['proxy-ip4'] = $proxy_ip;
				}
				$ret['ip'] = $ip;
			}else{ 
				$ret['is_proxied'] = false;
				$ip = (string)$_SERVER["REMOTE_ADDR"]; 
				$ret['network-addy'] = @gethostbyaddr($ip); 
				$ret['long'] = @ip2long($ip);
				if ($this->is_ipv6($ip)) {
					$ret['ip6'] = $ip;
				} else {
					$ret['ip4'] = $ip;
				}
				$ret['ip'] = $ip;
			} 
		} else {
			$ret['is_proxied'] = false;
			$ret['network-addy'] = @gethostbyaddr($ip); 
			$ret['long'] = @ip2long($ip);
			if ($this->is_ipv6($ip)) {
				$ret['ip6'] = $ip;
			} else {
				$ret['ip4'] = $ip;
			}
			$ret['ip'] = $ip;
		}
		$ret['made'] = time();				
		return $ret;
	}

	private function is_ipv6($ip = "") 
	{ 
		if ($ip == "") 
			return false;
			
		if (substr_count($ip,":") > 0){ 
			return true; 
		} else { 
			return false; 
		} 
	} 
    
}
?>