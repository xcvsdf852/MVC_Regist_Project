<?php

function str_sql_replace($str){
	$str = trim($str);	
	if(!empty($str))
	{
		$str = AddSlashes($str);	
	}
	return $str; 
}

?>