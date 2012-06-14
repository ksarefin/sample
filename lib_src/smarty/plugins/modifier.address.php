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
 * Name:     address<br>
 * Purpose:  works like random number
 * 
 * @link 
 * @author Arefin  
 * @param address data 
 * @return real address 
 */
function smarty_modifier_address($address)
{ 
   
	
	$data_class = new DataClass();
	$pref_list = $data_class->prefecture();
	
	$explode	= explode('::', $address);
 	$pref 		= $pref_list[$explode[0]];
 	$city_name 	= $explode[1];
 	$area1	 	= $explode[2];
 	$area2	 	= @$explode[3];
	
 	return  $pref." ".$city_name." ".$area1." ".$area2;
 	
	
} 

?>