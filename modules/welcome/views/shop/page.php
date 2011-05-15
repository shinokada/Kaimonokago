<?php
/*
if(isset ($lang_id)){
    echo "<br />lang_id: ";
print_r ($lang_id);
}
echo "<br />session lang is ";
echo $this->session->userdata('lang');
echo "<br />Language is ";
print_r ($language);
*/
$prefix="../";
$pagecontent = str_replace($prefix, "", $pagecontent['content']);
echo $pagecontent;



?>