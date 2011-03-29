<li id="menu_bep_general"><span class="icon_general"><?php print $this->lang->line('backendpro_general')?></span>
        <ul>
            <?php if(check('Calendar',NULL,FALSE)):?><li><?php print anchor('calendar/admin',$this->lang->line('backendpro_calendar'),array('class'=>'icon_calendar'))?></li><?php echo "\n"; endif;?>
            <?php if(check('Category',NULL,FALSE)):?><li><?php print anchor('category/admin',$this->lang->line('backendpro_category'),array('class'=>'icon_category'))?></li><?php echo "\n"; endif;?>
            <?php if(check('Customers',NULL,FALSE)):?><li><?php print anchor('customers/admin',$this->lang->line('backendpro_customers'),array('class'=>'icon_user_suit'))?></li><?php echo "\n"; endif;?>
            <?php if(check('Filemanager',NULL,FALSE)):?><li><?php print anchor('file_manager/admin',$this->lang->line('backendpro_file_manager'),array('class'=>'icon_folder'))?></li><?php echo "\n"; endif;?>
            <?php if(check('Multi languages',NULL,FALSE)):?><li><?php print anchor('languages/admin',$this->lang->line('backendpro_langages'),array('class'=>'icon_blueflag'))?></li><?php echo "\n"; endif;?>
            <?php if(check('Menus',NULL,FALSE)):?><li><?php print anchor('menus/admin',$this->lang->line('backendpro_menus'),array('class'=>'icon_folder'))?></li><?php echo "\n"; endif;?>
            <?php if(check('Messages',NULL,FALSE)):?><li><?php print anchor('messages/admin',$this->lang->line('backendpro_messages'),array('class'=>'icon_comment'))?></li><?php echo "\n"; endif;?>
            <?php if(check('Orders',NULL,FALSE)):?><li><?php print anchor('orders/admin',$this->lang->line('backendpro_orders'),array('class'=>'icon_cake'))?></li><?php echo "\n"; endif;?>
            <?php if(check('Pages',NULL,FALSE)):?><li><?php print anchor('pages/admin',$this->lang->line('backendpro_pages'),array('class'=>'icon_page'))?></li><?php echo "\n"; endif;?>
            <?php if(check('Playroom',NULL,FALSE)):?><li><?php print anchor('playroom/admin',$this->lang->line('kago_playroom'),array('class'=>'icon_asterisk_orange'))?></li><?php echo "\n"; endif;?>
            <?php if(check('Products',NULL,FALSE)):?><li><?php print anchor('products/admin',$this->lang->line('backendpro_products'),array('class'=>'icon_color_swatch'))?></li><?php echo "\n"; endif;?>
            <?php if(check('Slideshow',NULL,FALSE)):?><li><?php print anchor('slideshow/admin',$this->lang->line('backendpro_slideshow'),array('class'=>'icon_television'))?></li><?php echo "\n"; endif;?>
            <?php if(check('Subscribers',NULL,FALSE)):?><li><?php print anchor('subscribers/admin',$this->lang->line('backendpro_subscribers'),array('class'=>'icon_user_red'))?></li><?php echo "\n"; endif;?>
        </ul>
    </li>