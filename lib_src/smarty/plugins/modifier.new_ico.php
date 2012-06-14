<?php
/**
 * Smarty plugin
 * 
 * @package Smarty
 * @subpackage PluginsModifier
 */

/**
 * Smarty capitalize modifier plugin
 * 
 * Type:     modifier<br>
 * Name:     new_ico<br>
 * Purpose:  make new icon
 * 
 * @link 
 * @author Arefin  
 * @param date
 * @return new icon 
 */
function smarty_modifier_new_ico($date)
{ 
	$date = str_replace('年', '/', $date);
	$date = str_replace('月', '/', $date);
	$date = str_replace('日', ' ', $date);
	$date = strtotime($date);
	
	//echo $date.'--'.date('Y-m-d', $date).' ::: ';
   
	$last_one_month_time = mktime(0,0,0,(date("n")-1),date('j'),date("Y"));
	//$last_one_month_time = mktime(date("H"),(date("i")-5),date("s"),(date("n",$date)),date('j', $date),date("Y",$date));
	//print $last_one_month_time;
	
	if ($date > $last_one_month_time)
		return  '<span class="icoNew">［新機能］</span>';
} 

?>