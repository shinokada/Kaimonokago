<div class="signtop paddingright">
    <b><?php
            echo $this->data['loginstatus'];
    ?></b><br />
</div>
<div id="newsletter" class="signtop paddingright">
    <b><?php
            echo $this->lang->line('subscribe_newsletter')."<br />\n";
            echo anchor(base_url()."index.php/".$this->data['mainmodule']."/subscribe/", $this->lang->line('subscribe_subscribe'));
            echo "<br />\n";
            echo anchor(base_url()."index.php/".$this->data['mainmodule']."/unsubscribe/", $this->lang->line('subscribe_unsubscribe'));

    ?></b><br />
</div>

<div class="leftbox"><!-- Start of Top sellers -->        
    <h2><?php echo $this->lang->line('webshop_mostsold'); ?></h2>
        <div class="box ac">
            <?php foreach ($this->data['mostsold'] as $mostsold):?>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td>
                        <div class="topseller">
                            <div class="topsellercname">
                            <a href="<?php echo base_url();?>index.php/<?php echo $this->data['mainmodule'];?>/product/<?php echo $mostsold['id']; ?>"><?php echo $mostsold['name']; ?></a>
                        </div>
                        <div class="topsellerimg">
                            <a href="<?php echo base_url();?>index.php/<?php echo $this->data['mainmodule'];?>/product/<?php echo $mostsold['id']; ?>">
                                    <img src="<?php
                                    $mostsoldimg = $mostsold['thumbnail'];
                                    $most_thumbnail=convert_image_path($mostsoldimg);
                                    echo $most_thumbnail; ?>" border="0" alt=" " title=" " />
                            </a>
                        </div>
                        <div id="topsellerdesc">
                            <?php echo $mostsold['shortdesc']; ?>

                        </div>
                        <div class="topsellerprice">
                            <b><?php echo $this->lang->line('webshop_price');?></b>: <span class='price'><?php echo $this->lang->line('webshop_currency_symbol'); echo $mostsold['price']; ?></span>
                        </div>
                        </div>
                    </td>
                </tr>
            </table>
            <?php endforeach; ?>
        </div>
</div><!-- END of Top sellers -->

    <div class="rightbox"><!-- START FEATURED PRODUCTS BOX -->
    <h2><?php echo $this->lang->line('webshop_newproduct'); ?></h2>
    <div class="box">
        <?php foreach ($this->data['newproduct'] as $newproduct):?>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td>
                    <div class="topseller">
                            <div class="topsellercname">
                            <a href="<?php echo base_url();?>index.php/<?php echo $this->data['mainmodule'];?>/product/<?php echo $newproduct['id']; ?>"><?php echo $newproduct['name']; ?></a>
                    </div>
                    <div class="topsellerimg">
                            <a href="<?php echo base_url();?>index.php/<?php echo $this->data['mainmodule'];?>/product/<?php echo $newproduct['id']; ?>">
                                    <img src="<?php
                                    $thumbimg = $newproduct['thumbnail'];
                                    $thumbnail=convert_image_path($thumbimg);
                                    echo $thumbnail; ?>" border="0" alt=" " title=" " />
                            </a>
                    </div>
                    <div id="topsellerdesc">
                            <?php echo $newproduct['shortdesc']; ?>

                    </div>
                    <div class="topsellerprice">
                            <b>Pris</b>: <span class='price'><?php echo $newproduct['price']; ?></span>
                    </div>
                    </div>
                </td>
            </tr>
        </table>
        <?php endforeach; ?>
    </div>
</div><!-- END FEATURED PRODUCTS BOX --> 

