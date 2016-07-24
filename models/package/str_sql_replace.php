<?php

function str_sql_replace($str){
	$str = trim($str);	
	if(!empty($str))
	{
		// $str = htmlspecialchars($str, ENT_NOQUOTES);
		$str = AddSlashes($str);	
	}
	return $str; 
}

?>