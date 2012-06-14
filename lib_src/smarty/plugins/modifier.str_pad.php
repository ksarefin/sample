<?php

function smarty_modifier_str_pad($string, $length = 6, $direction="LEFT")
{
   
    if($direction == "LEFT"){
    	return str_pad($string,$length,"0",STR_PAD_LEFT);
    }if($direction == "RIGHT"){
    	return str_pad($string,$length,"0",STR_PAD_RIGHT);
    }else{
    	return str_pad($string,$length,"0",STR_PAD_LEFT);
    }
    
}


?>
