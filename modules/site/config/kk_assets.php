<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Added from here
// Back-end Admin CSS
$config['asset'][] = array('file'=>'admin.css');

// Back-end Calendar CSS
$config['asset'][] = array('file'=>'master.css');
$config['asset'][] = array('file'=>'jquery.datepick.css');

// Back-end Calendar JS
$config['asset'][] = array('file'=>'jquery.datepick.pack.js', 'needs'=>'jquery');
$config['asset'][] = array('file'=>'coda.js', 'needs'=>'jquery');
$config['asset'][] = array('file'=>'site.js', 'needs'=>'jquery');

// Back-end Messages js
$config['asset'][] = array('file'=>'shoutbox.js', 'needs'=>'jquery');

// Back-end dataTables js
$config['asset'][] = array('file'=>'jquery.dataTables.min.js', 'needs'=>'jquery');
$config['asset'][] = array('file'=>'demo_table.css');

// Back-end jqaccordion
$config['asset'][] = array('file'=>'jquery.accordion.js', 'needs'=>'jquery_ui');
$config['asset'][] = array('file'=>'jqaccordion.css');

// CI shopping cart front-end
$config['asset'][] = array('file'=>'default.css');

// webshop
$config['asset'][] = array('file'=>'webshop.css');
	// dropdown menu
$config['asset'][] = array('file'=>'menu.init.js', 'needs'=>'jquery');	
	// delete item or recalculate
$config['asset'][] = array('file'=>'shopcustomtools.js', 'needs'=>'jquery');
	// menu, slideshow for the front page
$config['asset'][] = array('file'=>'jquery.innerfade.js', 'needs'=>'jquery');	
	// browser detect js
// $config['asset'][] = array('file'=>'browserDetect-min.js', 'needs'=>'jquery');

// TINYMCE 
$config['asset'][] = array('file'=>'tiny_mce.js');
$config['asset'][] = array('file'=>'tinymce.init.js', 'needs'=>'tiny_mce');

// cu3er slideshow. since appending some html we need jquery
$config['asset'][] = array('file'=>'cu3er.js', 'needs'=>'jquery');

// conin-slider
$config['asset'][] = array('file'=>'conin-slider-styles.css');
$config['asset'][] = array('file'=>'coin-slider.min.js', 'needs'=>'jquery');

// jquery.nivo.slider
$config['asset'][] = array('file'=>'nivo-slider.css');
$config['asset'][] = array('file'=>'jquery.nivo.slider.pack.js', 'needs'=>'jquery');
// Added upto here




// Added from here 
$config['asset_group']['SHOP'] = 'shopcustomtools|FlashStatus|webshop|menu.init';
$config['asset_group']['SHOPADMIN'] = 'jquery_ui|admin|shoutbox|master|jquery.datepick|jquery.datepick.pack|coda|site|jquery.dataTables.min|jquery.accordion|demo_table|jqaccordion';

// TinyMCE group
$config['asset_group']['TINYMCE'] = "tinymce.init";

// Slideshow groups. There are two kinds of slideshows are implemented
// cu3er group
$config['asset_group']['cu3er'] = "cu3er";
$config['asset_group']['interfade'] = "jquery.innerfade";
$config['asset_group']['coinslider'] = "coin-slider.min|conin-slider-styles";
$config['asset_group']['nivoslider'] = "jquery.nivo.slider.pack|nivo-slider";
// Added upto here
