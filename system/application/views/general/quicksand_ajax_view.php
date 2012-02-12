<ul class="webbies">
          
          <?php 
          
          	foreach($images as $elem => $image){
  echo "<li data-id=\"id-".($elem + 1)."\" data-type=\"".$image['class'].
  "\">\n<img src=\"".base_url().$image['thumbnail'].
  "\" width=\"128\" height=\"128\" />\n<strong>".
  $image['name']."</strong>\n<span data-type=\"size\">".
  $image['shortdesc']."</span></li>\n";
}

          ?>
            <li data-id="ab"><img src="../content/images/webby-andy-budd.png" width="110" height="110" alt="" /></li>
            <li data-id="ac"><img src="../content/images/webby-andy-clarke.png" width="110" height="110" alt="" /></li>

            <li data-id="db"><img src="../content/images/webby-dan-benjamin.png" width="110" height="110" alt="" /></li>
            <li data-id="dc"><img src="../content/images/webby-dan-cederholm.png" width="110" height="110" alt="" /></li>
            <li data-id="dr"><img src="../content/images/webby-dan-rubin.png" width="110" height="110" alt="" /></li>
            <li data-id="ds"><img src="../content/images/webby-dave-shea.png" width="110" height="110" alt="" /></li>
            <li data-id="dbw"><img src="../content/images/webby-doug-bowman.png" width="110" height="110" alt="" /></li>
            <li data-id="em"><img src="../content/images/webby-eric-meyer.png" width="110" height="110" alt="" /></li>
            <li data-id="jz"><img src="../content/images/webby-jeffrey-zeldman.png" width="110" height="110" alt="" /></li>
            <li data-id="jk"><img src="../content/images/webby-jeremy-keith.png" width="110" height="110" alt="" /></li>
            <li data-id="jh"><img src="../content/images/webby-jon-hicks.png" width="110" height="110" alt="" /></li>

            <li data-id="js"><img src="../content/images/webby-jonathan-snook.png" width="110" height="110" alt="" /></li>
            <li data-id="si"><img src="../content/images/webby-shaun-inman.png" width="110" height="110" alt="" /></li>
            <li data-id="vd"><img src="../content/images/webby-veerle-duoh.png" width="110" height="110" alt="" /></li>
          </ul>
          
          <script type="text/javascript">
            $(function() {
              $('#load-webbies a.button').click(function(e) {
            		$.get( $(this).attr('href'), function(data) {
            		  	$('.webbies').quicksand( $(data).find('li') );
            		});	
            		e.preventDefault();	
            	});
            });
          </script>