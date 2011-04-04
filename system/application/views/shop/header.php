
<div id="header">
    <div id="logotop"><a href="<?php echo base_url();?>index.php/">
    <img src="assets/images/banner_logo_top.gif" alt="Logo" name="logo" width="53" height="118" id="logo" title="Logo" /></a>
    </div>
    <div id="langbox">
        <?php
        echo form_open($this->data['mainmodule'].'/index');
       //  echo "<label for='parent'>Change Language</label>\n";
        echo form_dropdown('lang',$this->data['langs']) ."\n";
        echo form_submit('submit','Change Language');
        echo form_close();


/*
        if (isset($this->data['langs'])){
            echo "<ul>";
            echo "<li><a href=\"".base_url()."index.php/webshop/english \">English</a></li>";
            foreach($this->data['langs'] as $key=>$lang){
                echo "<li><a href=\"".base_url()."index.php/webshop/".$lang['langname']."\">";
                echo ucwords($lang['langname']);
                echo "</a></li>";

            }
            echo "</ul>";

        }
        */

//echo anchor("welcome/langtest/index/english", 'English');
//echo "<br />";
//echo anchor("welcome/langtest/index/french", 'French');
//echo "<br />";
//echo anchor("welcome/langtest/index/german", 'German');


        ?>
        <?php
         // testing language
        /*
echo "<br />lang_id: ";
if (isset($lang_id)){
    print_r ($lang_id);
}

    print "<br />Current Language is (current_language of this->lang->line) <br />".$this->lang->line('current_language');
*/
    // test finish
?>
    </div>
    <div id="greenbox">
        <div class="insideright10">
            <p><span id="cart"><a href="<?php echo base_url();?>index.php/<?php echo $this->data['mainmodule'];?>/cart"><?php echo lang('general_shopping_cart'); ?></a></span><br />
            <?php
            $this->data['handlekurv'] = number_format($this->data['handlekurv'] ,2,'.',',');
            if(isset($this->data['handlekurv'])){
                    echo lang('webshop_currency_symbol').$this->data['handlekurv'];
            }else{
            echo lang('webshop_shoppingcart_empty');
            }
            ?>
            </p>
        </div>
    </div>
    <div id="flags">

        <?php
        echo form_open($this->data['mainmodule']."/search");
        $data = array(
          "name" => "term",
          "id" => "term",
          "maxlength" => "64",
          "size" => "15"
        );
        echo form_input($data);
        echo form_submit("submit",lang('webshop_search'));
        echo form_close();
        ?>

    </div>
    <div id="headnav">

    <?php
if(count($this->data['mainnav'])){
    echo "\n<ul id='nav'>";

    foreach ($this->data['mainnav'] as $key => $menu){
         if($menu['lang_id']==$this->data['lang_id']){
        echo "\n<li class='menuone'>\n";
        // need to find page uri from id
        // menu /page_uri/lang_id
       
        echo anchor ($this->data['mainmodule']."/pages/".$menu['id'], $menu['name']);
            if (count($menu['children'])){
                echo "\n<ul>";
                    foreach ($menu['children'] as $subkey => $submenu){
                    echo "\n<li class='menutwo'>\n";
                    echo anchor($this->data['mainmodule']."/pages/".$submenu['id'],$submenu['name']);
                        if (count($submenu['children'])){
                        echo "\n<ul>";
                        foreach ($submenu['children'] as $subkey => $subsubname){
                        echo "\n<li class='menuthree'>\n";
                        echo anchor($this->data['mainmodule']."/cat/",$subsubname['name']);
                        echo "\n</li>";
                        }
                        echo "\n</ul>";
                        }
                    echo "\n</li>";
                    }
                echo "\n</ul>";
            }
            echo "\n</li>\n";
    }
    }
echo "\n</ul>\n";
}
?>
		
           <div class="cb">&nbsp;</div>
        </div>
    </div>
   <!-- End of div header-->
