<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	  <title>jQuery Quicksand plugin on Codeigniter</title>
	     <link rel="stylesheet" href="<?php echo base_url();?>assets/css/quicksand/qmain.css" />
	    <!--[if IE 7]><link rel="stylesheet" href="<?php echo base_url();?>assets/css/quicksand/ie7.css" /><![endif]-->    
	    
	    <!-- DO NOT USE THESE FILES. they are compiled for fast http access -->
	    <!-- if you’re looking for source, download or read documentation -->
	     
	
    
    <style>
      .webbies {
        overflow: hidden;
      }
      .webbies li {
        display: block;
        float: left;
      }
    </style>
    
 </head>
  	<body>
    
    <div id="wrapper">
      <div id="site">
        <div id="title">
          <h1>Quicksand<span></span></h1>
          <p>Reorder and filter items with a nice shuffling animation.</p>

        </div>
      
        <h2 class="splitter">Advanced: Ajax call</h2>

        <div class="demo">
        
          <p id="load-webbies">
            <a href="http://www.happywebbies.com/">Webbies</a>: 
            <a class="button" href="ajax/ajax-brits.html">Brits</a>
            <a class="button" href="ajax/ajax-developers.html">Developers</a>
            <a class="button" href="ajax/ajax-westerners.html">Westerners</a>
            <a class="button" href="ajax/ajax-designers.html">Designers</a>
            <a class="button" href="ajax/ajax-legends.html">Legends</a>
          </p>
 
          <?php $this->load->view('general/quicksand_ajax_view');?>
                
        </div>

      </div>
    </div>
    
    <p class="footer">
      <span>Powered by <a href="http://jquery.com">jQuery</a> – Made by <a href="http://agilope.com">agilope</a></span>
      <span>Design by <a href="http://riddle.pl">riddle.pl</a></span>

    </p>
    
		<script src="<?php echo base_url();?>assets/js/quicksand/jquery-1.4.1-and-plugins.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/js/quicksand/main.js" type="text/javascript"></script> 
  	</body>
  </html>