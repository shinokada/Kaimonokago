<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php print $header.' | '.$this->preference->item('site_name')?></title>
	<?php print $this->bep_site->get_variables()?>
	<?php print $this->bep_assets->get_header_assets();?>
</head>
<body style="padding: 2em;">
    <a name="top"></a>
    <?php print displayStatus();?>
    <?php print (isset($content)) ? $content : NULL; ?>
    <?php
    if( isset($page)){
    if( isset($module)){
            $this->load->module_view($module,$page);
        } else {
            $this->load->view($page);
        }}
    ?>
	<?php print $this->bep_assets->get_footer_assets();?>
</body>
</html>