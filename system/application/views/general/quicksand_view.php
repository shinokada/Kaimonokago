          <ul id="list" class="image-grid">
          <?php 
          
          	foreach($images as $elem => $image){
  echo "<li data-id=\"id-".($elem + 1)."\" data-type=\"".$image['class'].
  "\">\n<img src=\"".base_url().$image['thumbnail'].
  "\" width=\"128\" height=\"128\" />\n<strong>".
  $image['name']."</strong>\n<span data-type=\"size\">".
  $image['shortdesc']."</span></li>\n";
}

          ?>
         </ul>