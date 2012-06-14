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
 * @param $pref_id
 * @return pref name 
 */
function smarty_modifier_pref($pref_id)
{
	//print $pref_id;
	
	$data_class = new DataClass();
	$pref_list = $data_class->prefecture();
	
	$pref_name = $pref_list[$pref_id];
 	
	return  $pref_name;
 	
	
} 

?>