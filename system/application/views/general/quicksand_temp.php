<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	  <title>jQuery Quicksand plugin on Codeigniter</title>
	     <link rel="stylesheet" href="<?php echo base_url();?>assets/css/quicksand/qmain.css" />
	    <!--[if IE 7]><link rel="stylesheet" href="<?php echo base_url();?>assets/css/quicksand/ie7.css" /><![endif]-->    
	    
	    <!-- DO NOT USE THESE FILES. they are compiled for fast http access -->
	    <!-- if you’re looking for source, download or read documentation -->
	     
	</head>
  	<body>
    
    <div id="wrapper">
      <div id="site">
        <div id="title">
          <h1>Quicksand<span></span></h1>

          <p>Reorder and filter items with a nice shuffling animation.</p>
        </div>

        <!-- this isn’t part of the plugin, just a control for demo -->
        <ul class="splitter">
        	<li>Filter by type:
        		<ul>
        			<li class="segment-1 selected-1"><a href="#" data-value="all">Everything</a></li>
        			<li class="segment-0"><a href="#" data-value="app">Applications</a></li>
        			<li class="segment-2"><a href="#" data-value="util">Utilities</a></li>
        		</ul>
        	</li>
        	<li>Sort by:
        		<ul>
        			<li class="segment-1 selected-1"><a href="#" data-value="name">Name</a></li>
        			<li class="segment-2"><a href="#" data-value="size">Size</a></li>
        		</ul>
        	</li>
        </ul>

        <div class="demo">
          <!-- read the documentation to understand what’s going on here -->
       
		<?php $this->load->view('general/quicksand_view');?>
		
        </div>
      </div>
    </div>

    
    <p class="footer">
      <span>Powered by <a href="http://jquery.com">jQuery</a> – Made by <a href="http://twitter.com/razorjack">@razorjack</a></span>
      <span>Design by <a href="http://twitter.com/riddle">@riddle</a></span>
    </p>
    

   	<script src="<?php echo base_url();?>assets/js/quicksand/jquery-1.4.1-and-plugins.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/js/quicksand/main.js" type="text/javascript"></script> 
  	</body>
  </html>