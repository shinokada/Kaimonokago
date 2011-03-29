<div id="leftbox"><!--Start of leftbox 1-->
    <h2>Categories</h2>
<?php
    if(count($this->data['navlist'])){// in order to prevent an error after installtion
        echo "\n<ul id='catnav'>";
    foreach ($this->data['navlist'] as $key => $menu){
            echo "\n<li class='menuone'>\n";
            echo anchor ($this->data['mainmodule']."/cat/".$key, $menu);
            echo "\n</li>\n";
    }
    echo "\n</ul>\n";
    }

    ?>
</div>
