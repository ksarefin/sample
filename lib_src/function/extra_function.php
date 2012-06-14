<?php
Define( "ACCESS_TIME" , mftime() );
$AccessTime = "<BR>";
AccessTimeCheck();
function mftime()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function AccessTimeCheck($k=""){
		return; 
        global $AccessTime;
        //if( $k == "START" or $k == "END" or $k == "" )
        $AccessTime .= "<b>$k</b>".( ACCESS_TIME - mftime() ) ."<BR>";
}

function debug($str,$c=0){
		return; 
        if( DEBUG or $c == 1){
                echo "<div style=\"background-color:#003399;color:#FFFFFF;text-align:left;\"><pre>";
                var_dump( $str );
                echo "</pre></div>";
        }
}
function RequestToConvert( $DATA = NULL , $ex = 0 , $need = NULL , $ignore = NULL ){
$Return = "";
        if( $DATA == NULL ) $DATA = $_REQUEST;
        foreach( $DATA as $k => $v ){
                if( is_array( $v )){
                        foreach( $v as $_k => $_v ){
                                $x = $k."[".$_k."]";
                                $Return .= PHP_Function::RequestToConvert(array( $x => $_v ),$ex,$need,$ignore);
                        }
                }else{
                        if( $ignore != NULL){
                                if( is_array( $ignore ) ){
                                        if( is_int( array_search( $k , $ignore )))continue;
                                }else{
                                        if( $k == $ignore )continue;
                                }
                        }
                        if( $need != NULL ){
                                if( is_array( $need ) ){
                                        if( !is_int( array_search( $k , $need )))continue;
                                }else{
                                        if( $k != $need )continue;
                                }
                        }
                        if( $ex == 0 ){
                        $Return .= "<input type=\"hidden\" name=\"$k\" value=\"".$v."\" />";
                        }elseif( $ex == 1 ){
                        $Return .= "&$k=".urlencode($v);
                        }
                }
        }
return $Return;
}
AccessTimeCheck( "START" );
