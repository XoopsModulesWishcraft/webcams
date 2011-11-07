<?php

$adminmenu = array();
$i=1;
$adminmenu[$i]['icon'] = _wbc_mi_adminmenu1_icon;
$adminmenu[$i]['image'] = _wbc_mi_adminmenu1_icon;
$adminmenu[$i]['title'] = _wbc_mi_adminmenu1;
$adminmenu[$i]['link']  = "admin/admin.php?op=list&fct=host";
$i++;
$adminmenu[$i]['icon'] = _wbc_mi_adminmenu2_icon;
$adminmenu[$i]['image'] = _wbc_mi_adminmenu2_icon;
$adminmenu[$i]['title'] = _wbc_mi_adminmenu2;
$adminmenu[$i]['link']  = "admin/admin.php?op=list&fct=user";
$i++;
//$adminmenu[$i]['icon'] = _wbc_mi_adminmenu3_icon;
//$adminmenu[$i]['image'] = _wbc_mi_adminmenu3_icon;
//$adminmenu[$i]['title'] = _wbc_mi_adminmenu3;
//$adminmenu[$i]['link']  = "admin/admin.php?op=list&fct=studio";
//$i++;
$adminmenu[$i]['icon'] = _wbc_mi_adminmenu4_icon;
$adminmenu[$i]['image'] = _wbc_mi_adminmenu4_icon;
$adminmenu[$i]['title'] = _wbc_mi_adminmenu4;
$adminmenu[$i]['link']  = "admin/admin.php?op=create&fct=host";
$i++;
$adminmenu[$i]['icon'] = _wbc_mi_adminmenu5_icon;
$adminmenu[$i]['image'] = _wbc_mi_adminmenu5_icon;
$adminmenu[$i]['title'] = _wbc_mi_adminmenu5;
$adminmenu[$i]['link']  = "admin/admin.php?op=create&fct=user";
$i++;
//$adminmenu[$i]['icon'] = _wbc_mi_adminmenu6_icon;
//$adminmenu[$i]['image'] = _wbc_mi_adminmenu6_icon;
//$adminmenu[$i]['title'] = _wbc_mi_adminmenu6;
//$adminmenu[$i]['link']  = "admin/admin.php?op=create&fct=studio";
//$i++;
$adminmenu[$i]['icon'] = _wbc_mi_adminmenu7_icon;
$adminmenu[$i]['image'] = _wbc_mi_adminmenu7_icon;
$adminmenu[$i]['title'] = _wbc_mi_adminmenu7;
$adminmenu[$i]['link']  = "admin/admin.php?op=permissions";

?>