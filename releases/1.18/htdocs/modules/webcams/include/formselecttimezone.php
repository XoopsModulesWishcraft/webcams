<?php
/**
 * select form element
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code 
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         kernel
 * @subpackage      form
 * @since           2.0.0
 * @author          Kazumi Ono (AKA onokazu) http://www.myweb.ne.jp/, http://jp.xoops.org/
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id$
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

xoops_load('XoopsFormElement');

/**
 * A select field
 *
 * @author 		Kazumi Ono <onokazu@xoops.org>
 * @author 		Taiwen Jiang <phppp@users.sourceforge.net>
 * @author 		John Neill <catzwolf@xoops.org>
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/
 * @package 	kernel
 * @subpackage 	form
 * @access 		public
 */
class WebcamsFormSelectTimezone extends XoopsFormElement
{
    /**
     * Options
     *
     * @var array
     * @access private
     */
    var $_options = array();

    /**
     * Allow multiple selections?
     *
     * @var bool
     * @access private
     */
    var $_multiple = false;

    /**
     * Number of rows. "1" makes a dropdown list.
     *
     * @var int
     * @access private
     */
    var $_size;

    /**
     * Pre-selcted values
     *
     * @var array
     * @access private
     */
    var $_value = array();

    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name "name" attribute
     * @param mixed $value Pre-selected value (or array of them).
     * @param int $size Number or rows. "1" makes a drop-down-list
     * @param bool $multiple Allow multiple selections?
     */
    function WebcamsFormSelectTimezone($caption, $name, $value = null, $size = 1, $multiple = false)
    {
        $this->setCaption($caption);
        $this->setName($name);
        $this->_multiple = $multiple;
        $this->_size = intval($size);
        if (isset($value)) {
            $this->setValue($value);
        } 
        $tz[] = 'Africa/Abidjan';
		$tz[] = 'Africa/Accra';
		$tz[] = 'Africa/Addis_Ababa';
		$tz[] = 'Africa/Algiers';
		$tz[] = 'Africa/Asmera';
		$tz[] = 'Africa/Bamako';
		$tz[] = 'Africa/Bangui';
		$tz[] = 'Africa/Banjul';
		$tz[] = 'Africa/Bissau';
		$tz[] = 'Africa/Blantyre';
		$tz[] = 'Africa/Brazzaville';
		$tz[] = 'Africa/Bujumbura';
		$tz[] = 'Africa/Cairo';
		$tz[] = 'Africa/Casablanca';
		$tz[] = 'Africa/Ceuta';
		$tz[] = 'Africa/Conakry';
		$tz[] = 'Africa/Dakar';
		$tz[] = 'Africa/Dar_es_Salaam';
		$tz[] = 'Africa/Djibouti';
		$tz[] = 'Africa/Douala';
		$tz[] = 'Africa/El_Aaiun';
		$tz[] = 'Africa/Freetown';
		$tz[] = 'Africa/Gaborone';
		$tz[] = 'Africa/Harare';
		$tz[] = 'Africa/Johannesburg';
		$tz[] = 'Africa/Kampala';
		$tz[] = 'Africa/Khartoum';
		$tz[] = 'Africa/Kigali';
		$tz[] = 'Africa/Kinshasa';
		$tz[] = 'Africa/Lagos';
		$tz[] = 'Africa/Libreville';
		$tz[] = 'Africa/Lome';
		$tz[] = 'Africa/Luanda';
		$tz[] = 'Africa/Lubumbashi';
		$tz[] = 'Africa/Lusaka';
		$tz[] = 'Africa/Malabo';
		$tz[] = 'Africa/Maputo';
		$tz[] = 'Africa/Maseru';
		$tz[] = 'Africa/Mbabane';
		$tz[] = 'Africa/Mogadishu';
		$tz[] = 'Africa/Monrovia';
		$tz[] = 'Africa/Nairobi';
		$tz[] = 'Africa/Ndjamena';
		$tz[] = 'Africa/Niamey';
		$tz[] = 'Africa/Nouakchott';
		$tz[] = 'Africa/Ouagadougou';
		$tz[] = 'Africa/Porto-Novo';
		$tz[] = 'Africa/Sao_Tome';
		$tz[] = 'Africa/Timbuktu';
		$tz[] = 'Africa/Tripoli';
		$tz[] = 'Africa/Tunis';
		$tz[] = 'Africa/Windhoek';
		$tz[] = 'America/Adak';
		$tz[] = 'America/Anchorage';
		$tz[] = 'America/Anguilla';
		$tz[] = 'America/Antigua';
		$tz[] = 'America/Araguaina';
		$tz[] = 'America/Aruba';
		$tz[] = 'America/Asuncion';
		$tz[] = 'America/Bahia';
		$tz[] = 'America/Barbados';
		$tz[] = 'America/Belem';
		$tz[] = 'America/Belize';
		$tz[] = 'America/Boa_Vista';
		$tz[] = 'America/Bogota';
		$tz[] = 'America/Boise';
		$tz[] = 'America/Buenos_Aires';
		$tz[] = 'America/Cambridge_Bay';
		$tz[] = 'America/Campo_Grande';
		$tz[] = 'America/Cancun';
		$tz[] = 'America/Caracas';
		$tz[] = 'America/Catamarca';
		$tz[] = 'America/Cayenne';
		$tz[] = 'America/Cayman';
		$tz[] = 'America/Chicago';
		$tz[] = 'America/Chihuahua';
		$tz[] = 'America/Cordoba';
		$tz[] = 'America/Costa_Rica';
		$tz[] = 'America/Cuiaba';
		$tz[] = 'America/Curacao';
		$tz[] = 'America/Danmarkshavn';
		$tz[] = 'America/Dawson';
		$tz[] = 'America/Dawson_Creek';
		$tz[] = 'America/Denver';
		$tz[] = 'America/Detroit';
		$tz[] = 'America/Dominica';
		$tz[] = 'America/Edmonton';
		$tz[] = 'America/Eirunepe';
		$tz[] = 'America/El_Salvador';
		$tz[] = 'America/Fortaleza';
		$tz[] = 'America/Glace_Bay';
		$tz[] = 'America/Godthab';
		$tz[] = 'America/Goose_Bay';
		$tz[] = 'America/Grand_Turk';
		$tz[] = 'America/Grenada';
		$tz[] = 'America/Guadeloupe';
		$tz[] = 'America/Guatemala';
		$tz[] = 'America/Guayaquil';
		$tz[] = 'America/Guyana';
		$tz[] = 'America/Halifax';
		$tz[] = 'America/Havana';
		$tz[] = 'America/Hermosillo';
		$tz[] = 'America/Indiana/Knox';
		$tz[] = 'America/Indiana/Marengo';
		$tz[] = 'America/Indiana/Vevay';
		$tz[] = 'America/Indianapolis';
		$tz[] = 'America/Inuvik';
		$tz[] = 'America/Iqaluit';
		$tz[] = 'America/Jamaica';
		$tz[] = 'America/Jujuy';
		$tz[] = 'America/Juneau';
		$tz[] = 'America/Kentucky/Monticello';
		$tz[] = 'America/La_Paz';
		$tz[] = 'America/Lima';
		$tz[] = 'America/Los_Angeles';
		$tz[] = 'America/Louisville';
		$tz[] = 'America/Maceio';
		$tz[] = 'America/Managua';
		$tz[] = 'America/Manaus';
		$tz[] = 'America/Martinique';
		$tz[] = 'America/Mazatlan';
		$tz[] = 'America/Mendoza';
		$tz[] = 'America/Menominee';
		$tz[] = 'America/Merida';
		$tz[] = 'America/Mexico_City';
		$tz[] = 'America/Miquelon';
		$tz[] = 'America/Monterrey';
		$tz[] = 'America/Montevideo';
		$tz[] = 'America/Montreal';
		$tz[] = 'America/Montserrat';
		$tz[] = 'America/Nassau';
		$tz[] = 'America/New_York';
		$tz[] = 'America/Nipigon';
		$tz[] = 'America/Nome';
		$tz[] = 'America/Noronha';
		$tz[] = 'America/North_Dakota/Center';
		$tz[] = 'America/Panama';
		$tz[] = 'America/Pangnirtung';
		$tz[] = 'America/Paramaribo';
		$tz[] = 'America/Phoenix';
		$tz[] = 'America/Port-au-Prince';
		$tz[] = 'America/Port_of_Spain';
		$tz[] = 'America/Porto_Velho';
		$tz[] = 'America/Puerto_Rico';
		$tz[] = 'America/Rainy_River';
		$tz[] = 'America/Rankin_Inlet';
		$tz[] = 'America/Recife';
		$tz[] = 'America/Regina';
		$tz[] = 'America/Rio_Branco';
		$tz[] = 'America/Santiago';
		$tz[] = 'America/Santo_Domingo';
		$tz[] = 'America/Sao_Paulo';
		$tz[] = 'America/Scoresbysund';
		$tz[] = 'America/St_Johns';
		$tz[] = 'America/St_Kitts';
		$tz[] = 'America/St_Lucia';
		$tz[] = 'America/St_Thomas';
		$tz[] = 'America/St_Vincent';
		$tz[] = 'America/Swift_Current';
		$tz[] = 'America/Tegucigalpa';
		$tz[] = 'America/Thule';
		$tz[] = 'America/Thunder_Bay';
		$tz[] = 'America/Tijuana';
		$tz[] = 'America/Toronto';
		$tz[] = 'America/Tortola';
		$tz[] = 'America/Vancouver';
		$tz[] = 'America/Whitehorse';
		$tz[] = 'America/Winnipeg';
		$tz[] = 'America/Yakutat';
		$tz[] = 'America/Yellowknife';
		$tz[] = 'Antarctica/Casey';
		$tz[] = 'Antarctica/Davis';
		$tz[] = 'Antarctica/DumontDUrville';
		$tz[] = 'Antarctica/Mawson';
		$tz[] = 'Antarctica/McMurdo';
		$tz[] = 'Antarctica/Palmer';
		$tz[] = 'Antarctica/Rothera';
		$tz[] = 'Antarctica/Syowa';
		$tz[] = 'Antarctica/Vostok';
		$tz[] = 'Asia/Aden';
		$tz[] = 'Asia/Almaty';
		$tz[] = 'Asia/Amman';
		$tz[] = 'Asia/Anadyr';
		$tz[] = 'Asia/Aqtau';
		$tz[] = 'Asia/Aqtobe';
		$tz[] = 'Asia/Ashgabat';
		$tz[] = 'Asia/Baghdad';
		$tz[] = 'Asia/Bahrain';
		$tz[] = 'Asia/Baku';
		$tz[] = 'Asia/Bangkok';
		$tz[] = 'Asia/Beirut';
		$tz[] = 'Asia/Bishkek';
		$tz[] = 'Asia/Brunei';
		$tz[] = 'Asia/Calcutta';
		$tz[] = 'Asia/Choibalsan';
		$tz[] = 'Asia/Chongqing';
		$tz[] = 'Asia/Colombo';
		$tz[] = 'Asia/Damascus';
		$tz[] = 'Asia/Dhaka';
		$tz[] = 'Asia/Dili';
		$tz[] = 'Asia/Dubai';
		$tz[] = 'Asia/Dushanbe';
		$tz[] = 'Asia/Gaza';
		$tz[] = 'Asia/Harbin';
		$tz[] = 'Asia/Hong_Kong';
		$tz[] = 'Asia/Hovd';
		$tz[] = 'Asia/Irkutsk';
		$tz[] = 'Asia/Jakarta';
		$tz[] = 'Asia/Jayapura';
		$tz[] = 'Asia/Jerusalem';
		$tz[] = 'Asia/Kabul';
		$tz[] = 'Asia/Kamchatka';
		$tz[] = 'Asia/Karachi';
		$tz[] = 'Asia/Kashgar';
		$tz[] = 'Asia/Katmandu';
		$tz[] = 'Asia/Krasnoyarsk';
		$tz[] = 'Asia/Kuala_Lumpur';
		$tz[] = 'Asia/Kuching';
		$tz[] = 'Asia/Kuwait';
		$tz[] = 'Asia/Macau';
		$tz[] = 'Asia/Magadan';
		$tz[] = 'Asia/Makassar';
		$tz[] = 'Asia/Manila';
		$tz[] = 'Asia/Muscat';
		$tz[] = 'Asia/Nicosia';
		$tz[] = 'Asia/Novosibirsk';
		$tz[] = 'Asia/Omsk';
		$tz[] = 'Asia/Oral';
		$tz[] = 'Asia/Phnom_Penh';
		$tz[] = 'Asia/Pontianak';
		$tz[] = 'Asia/Pyongyang';
		$tz[] = 'Asia/Qatar';
		$tz[] = 'Asia/Qyzylorda';
		$tz[] = 'Asia/Rangoon';
		$tz[] = 'Asia/Riyadh';
		$tz[] = 'Asia/Saigon';
		$tz[] = 'Asia/Sakhalin';
		$tz[] = 'Asia/Samarkand';
		$tz[] = 'Asia/Seoul';
		$tz[] = 'Asia/Shanghai';
		$tz[] = 'Asia/Singapore';
		$tz[] = 'Asia/Taipei';
		$tz[] = 'Asia/Tashkent';
		$tz[] = 'Asia/Tbilisi';
		$tz[] = 'Asia/Tehran';
		$tz[] = 'Asia/Thimphu';
		$tz[] = 'Asia/Tokyo';
		$tz[] = 'Asia/Ulaanbaatar';
		$tz[] = 'Asia/Urumqi';
		$tz[] = 'Asia/Vientiane';
		$tz[] = 'Asia/Vladivostok';
		$tz[] = 'Asia/Yakutsk';
		$tz[] = 'Asia/Yekaterinburg';
		$tz[] = 'Asia/Yerevan';
		$tz[] = 'Atlantic/Azores';
		$tz[] = 'Atlantic/Bermuda';
		$tz[] = 'Atlantic/Canary';
		$tz[] = 'Atlantic/Cape_Verde';
		$tz[] = 'Atlantic/Faeroe';
		$tz[] = 'Atlantic/Madeira';
		$tz[] = 'Atlantic/Reykjavik';
		$tz[] = 'Atlantic/South_Georgia';
		$tz[] = 'Atlantic/St_Helena';
		$tz[] = 'Atlantic/Stanley';
		$tz[] = 'Australia/Adelaide';
		$tz[] = 'Australia/Brisbane';
		$tz[] = 'Australia/Broken_Hill';
		$tz[] = 'Australia/Darwin';
		$tz[] = 'Australia/Hobart';
		$tz[] = 'Australia/Lindeman';
		$tz[] = 'Australia/Lord_Howe';
		$tz[] = 'Australia/Melbourne';
		$tz[] = 'Australia/Perth';
		$tz[] = 'Australia/Sydney';
		$tz[] = 'Europe/Amsterdam';
		$tz[] = 'Europe/Andorra';
		$tz[] = 'Europe/Athens';
		$tz[] = 'Europe/Belfast';
		$tz[] = 'Europe/Belgrade';
		$tz[] = 'Europe/Berlin';
		$tz[] = 'Europe/Brussels';
		$tz[] = 'Europe/Bucharest';
		$tz[] = 'Europe/Budapest';
		$tz[] = 'Europe/Chisinau';
		$tz[] = 'Europe/Copenhagen';
		$tz[] = 'Europe/Dublin';
		$tz[] = 'Europe/Gibraltar';
		$tz[] = 'Europe/Helsinki';
		$tz[] = 'Europe/Istanbul';
		$tz[] = 'Europe/Kaliningrad';
		$tz[] = 'Europe/Kiev';
		$tz[] = 'Europe/Lisbon';
		$tz[] = 'Europe/London';
		$tz[] = 'Europe/Luxembourg';
		$tz[] = 'Europe/Madrid';
		$tz[] = 'Europe/Malta';
		$tz[] = 'Europe/Minsk';
		$tz[] = 'Europe/Monaco';
		$tz[] = 'Europe/Moscow';
		$tz[] = 'Europe/Oslo';
		$tz[] = 'Europe/Paris';
		$tz[] = 'Europe/Prague';
		$tz[] = 'Europe/Riga';
		$tz[] = 'Europe/Rome';
		$tz[] = 'Europe/Samara';
		$tz[] = 'Europe/Simferopol';
		$tz[] = 'Europe/Sofia';
		$tz[] = 'Europe/Stockholm';
		$tz[] = 'Europe/Tallinn';
		$tz[] = 'Europe/Tirane';
		$tz[] = 'Europe/Uzhgorod';
		$tz[] = 'Europe/Vaduz';
		$tz[] = 'Europe/Vienna';
		$tz[] = 'Europe/Vilnius';
		$tz[] = 'Europe/Warsaw';
		$tz[] = 'Europe/Zaporozhye';
		$tz[] = 'Europe/Zurich';
		$tz[] = 'Indian/Antananarivo';
		$tz[] = 'Indian/Chagos';
		$tz[] = 'Indian/Christmas';
		$tz[] = 'Indian/Cocos';
		$tz[] = 'Indian/Comoro';
		$tz[] = 'Indian/Kerguelen';
		$tz[] = 'Indian/Mahe';
		$tz[] = 'Indian/Maldives';
		$tz[] = 'Indian/Mauritius';
		$tz[] = 'Indian/Mayotte';
		$tz[] = 'Indian/Reunion';
		$tz[] = 'Pacific/Apia';
		$tz[] = 'Pacific/Auckland';
		$tz[] = 'Pacific/Chatham';
		$tz[] = 'Pacific/Easter';
		$tz[] = 'Pacific/Efate';
		$tz[] = 'Pacific/Enderbury';
		$tz[] = 'Pacific/Fakaofo';
		$tz[] = 'Pacific/Fiji';
		$tz[] = 'Pacific/Funafuti';
		$tz[] = 'Pacific/Galapagos';
		$tz[] = 'Pacific/Gambier';
		$tz[] = 'Pacific/Guadalcanal';
		$tz[] = 'Pacific/Guam';
		$tz[] = 'Pacific/Honolulu';
		$tz[] = 'Pacific/Johnston';
		$tz[] = 'Pacific/Kiritimati';
		$tz[] = 'Pacific/Kosrae';
		$tz[] = 'Pacific/Kwajalein';
		$tz[] = 'Pacific/Majuro';
		$tz[] = 'Pacific/Marquesas';
		$tz[] = 'Pacific/Midway';
		$tz[] = 'Pacific/Nauru';
		$tz[] = 'Pacific/Niue';
		$tz[] = 'Pacific/Norfolk';
		$tz[] = 'Pacific/Noumea';
		$tz[] = 'Pacific/Pago_Pago';
		$tz[] = 'Pacific/Palau';
		$tz[] = 'Pacific/Pitcairn';
		$tz[] = 'Pacific/Ponape';
		$tz[] = 'Pacific/Port_Moresby';
		$tz[] = 'Pacific/Rarotonga';
		$tz[] = 'Pacific/Saipan';
		$tz[] = 'Pacific/Tahiti';
		$tz[] = 'Pacific/Tarawa';
		$tz[] = 'Pacific/Tongatapu';
		$tz[] = 'Pacific/Truk';
		$tz[] = 'Pacific/Wake';
		$tz[] = 'Pacific/Wallis';
		$tz[] = 'Pacific/Yap';
		
		foreach($tz as $id => $timezone)
        	$this->addOption($timezone, $timezone);
        
    }
    

    /**
     * Are multiple selections allowed?
     *
     * @return bool
     */
    function isMultiple()
    {
        return $this->_multiple;
    }

    /**
     * Get the size
     *
     * @return int
     */
    function getSize()
    {
        return $this->_size;
    }

    /**
     * Get an array of pre-selected values
     *
     * @param bool $encode To sanitizer the text?
     * @return array
     */
    function getValue($encode = false)
    {
        if (! $encode) {
            return $this->_value;
        }
        $value = array();
        foreach($this->_value as $val) {
            $value[] = $val ? htmlspecialchars($val, ENT_QUOTES) : $val;
        }
        return $value;
    }

    /**
     * Set pre-selected values
     *
     * @param  $value mixed
     */
    function setValue($value)
    {
        if (is_array($value)) {
            foreach($value as $v) {
                $this->_value[] = $v;
            }
        } elseif (isset($value)) {
            $this->_value[] = $value;
        }
    }

    /**
     * Add an option
     *
     * @param string $value "value" attribute
     * @param string $name "name" attribute
     */
    function addOption($value, $name = '')
    {
        if ($name != '') {
            $this->_options[$value] = $name;
        } else {
            $this->_options[$value] = $value;
        }
    }

    /**
     * Add multiple options
     *
     * @param array $options Associative array of value->name pairs
     */
    function addOptionArray($options)
    {
        if (is_array($options)) {
            foreach($options as $k => $v) {
                $this->addOption($k, $v);
            }
        }
    }

    /**
     * Get an array with all the options
     *
     * Note: both name and value should be sanitized. However for backward compatibility, only value is sanitized for now.
     *
     * @param int $encode To sanitizer the text? potential values: 0 - skip; 1 - only for value; 2 - for both value and name
     * @return array Associative array of value->name pairs
     */
    function getOptions($encode = false)
    {
        if (! $encode) {
            return $this->_options;
        }
        $value = array();
        foreach($this->_options as $val => $name) {
            $value[$encode ? htmlspecialchars($val, ENT_QUOTES) : $val] = ($encode > 1) ? htmlspecialchars($name, ENT_QUOTES) : $name;
        }
        return $value;
    }

    /**
     * Prepare HTML for output
     *
     * @return string HTML
     */
    function render()
    {
        $ele_name = $this->getName();
		$ele_title = $this->getTitle();
        $ele_value = $this->getValue();
        $ele_options = $this->getOptions();
        $ret = '<select size="' . $this->getSize() . '"' . $this->getExtra();
        if ($this->isMultiple() != false) {
            $ret .= ' name="' . $ele_name . '[]" id="' . $ele_name . '" title="'. $ele_title. '" multiple="multiple">' ;
        } else {
            $ret .= ' name="' . $ele_name . '" id="' . $ele_name . '" title="'. $ele_title. '">' ;
        }
        foreach($ele_options as $value => $name) {
            $ret .= '<option value="' . htmlspecialchars($value, ENT_QUOTES) . '"';
            if (count($ele_value) > 0 && in_array($value, $ele_value)) {
                $ret .= ' selected="selected"';
            }
            $ret .= '>' . $name . '</option>' ;
        }
        $ret .= '</select>';
        return $ret;
    }

    /**
     * Render custom javascript validation code
     *
     * @seealso XoopsForm::renderValidationJS
     */
    function renderValidationJS()
    {
        // render custom validation code if any
        if (! empty($this->customValidationCode)) {
            return implode("\n", $this->customValidationCode);
            // generate validation code if required
        } elseif ($this->isRequired()) {
            $eltname = $this->getName();
            $eltcaption = $this->getCaption();
            $eltmsg = empty($eltcaption) ? sprintf(_FORM_ENTER, $eltname) : sprintf(_FORM_ENTER, $eltcaption);
            $eltmsg = str_replace('"', '\"', stripslashes($eltmsg));
            return "\nvar hasSelected = false; var selectBox = myform.{$eltname};" . "for (i = 0; i < selectBox.options.length; i++ ) { if (selectBox.options[i].selected == true) { hasSelected = true; break; } }" . "if (!hasSelected) { window.alert(\"{$eltmsg}\"); selectBox.focus(); return false; }";
        }
        return '';
    }
}

?>