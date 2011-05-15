<div id="maintop">

    <?php print displayStatus();?>
    
    <?php
/*
echo "<pre>get_class is: ";
print_r($get_class);
echo "</pre>";
echo "<pre>module name is: ";
print_r($module);
echo "</pre>";
echo "<pre>index path is: ";
print_r($index_path);
echo "</pre>";
echo "<pre>cat_parent is: ";
print_r ($this->data['cat_parent']);
echo "</pre>";
echo "<pre>navlist: ";
print_r ($this->data['navlist']);
echo "</pre>";
*/
    if(!empty($slides)){
        echo "<div id=\"slideshow\" class=\"pics\">";
        foreach ($slides as $slide)
        {
            $imageinfo = $slide['image'];
                            $slideimg=convert_image_path($imageinfo);
            echo '<img class="hideme" src="'. $slideimg. '" alt="' . $slide['name'] .
            '" />';

        }
        echo "</div>";
    }
  //  print_r ($slides);

   // print_r ($pagecontent);
     if(isset($pagecontent['content'])){// this if is for the installation without this it will display an error
         echo $pagecontent['content'];
     }
     ;?>
</div>
<div id="frontproducttable">

<?php
foreach ($images as $image)
{
    $imageinfo = $image['thumbnail'];
    $thumbnail=convert_image_path($imageinfo);

        echo '<div class="vt ac" >'."\n".'<div class="frontpro">'."\n".'<div class="vt">'."\n";
        echo '<a href="' . site_url().'/'.$module. '/product/'.$image['id']. '">';
        echo "<img src='".$thumbnail."' border='0' class='thumbnail'/></a>\n</div>\n<div class='vt al'>\n";
        echo '<span class="hdrproduct"><a href="' . site_url(). '/'.$module.'/product/'.$image['id']. '">'."\n";
        echo $image['name']. "</a></span><br />\n";
        echo $image['shortdesc']."</div>\n";
        echo "<div class='vt ar'><b>".$this->lang->line('webshop_price')."</b>: <span class='price'>".$this->lang->line('webshop_currency_symbol').$image['price']."</span><br />\n";
        echo '<a href="' . site_url()."/".$module. '/cart/'.$image['id']. '"><p class="addtocart">'.$this->lang->line('webshop_buy').'</p></a></div>';
    echo "\n</div>\n</div>\n";
}


echo "<div class=\"clearboth\" ></div>";
/*
echo "<pre>";
print_r ($this->data['mainnav']);
echo "</pre>";
*/
?>

</div>

