<?php
function id_clean($id,$size=11){
	return intval(substr($id,0,$size));
}

function db_clean($string,$size=255){
	return xss_clean(substr($string,0,$size));
}
?>