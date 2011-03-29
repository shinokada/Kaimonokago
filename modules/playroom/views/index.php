<?php
//echo $this->data['lang_id'];
//echo $this->lang_id;
echo "<h1>$title</h1>";
echo "this is in views/index view<br />";

foreach($items as $item){
    $imageinfo = $item['image'];
     $image=convert_image_path($imageinfo);
   //  echo $image;
     echo "<img src='assets/".$image."' border='0' class='thumbnail'/>";
}

/*
  $imageinfo = '<p><img src="../../../../assets/images/cd/242x440_11.jpg" alt="" width="242" height="440" /></p>';
    $image=convert_image_path($imageinfo);
echo $image;
    echo "<img src='".$image."' border='0' class='thumbnail'/>";

 */

echo "modle is $module.";
echo "<pre>items";
print_r ($items);
echo "</pre>";
?>
