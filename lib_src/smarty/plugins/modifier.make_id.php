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
 * Name:     make_id<br>
 * Purpose:  works like random number
 * 
 * @link 
 * @author Arefin  
 * @param id 
 * @return random id 
 */
function smarty_modifier_make_id($id)
{ 
   return  make_id($id);
} 

?>