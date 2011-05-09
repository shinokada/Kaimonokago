<h2><?php echo $title;?></h2>
<div class="buttons">
	<a href="<?php print  site_url('menus/admin/create')?>">
    <?php print $this->bep_assets->icon('add');?>
    <?php print $this->lang->line('kago_create_menu'); ?>
    </a>
</div>
<div class="clearboth">&nbsp;</div>
<?php
if(isset ($checkmenu)){
    echo "<pre>";
    print_r ($checkmenu);
    echo "</pre>";
}
echo '<h2>Menus</h2>';
/**
 * @param array $level The current navigation level array
 * @param string $output The output to be added to
 * @param int $depth The current depth of the tree to determine classname
 */
function generateRowsByLevel($navlist, &$output, $depth = 0,$pages,$languages) {
    $depthClassMapping = array(0 => 'parent', 1 => 'child', 2 => 'grandchild');
    foreach ($navlist as $list) {
        // This is ugly, there must be a better way. But for now.
        if (array_key_exists($list['page_uri_id'], $pages)) {
            $pathid = $list['page_uri_id'];
            $path = $pages[$pathid];
            if($path =='none'){
                $path=NULL;
            }
        }
        // This is ugly, there must be a better way. But for now.
        if (array_key_exists($list['lang_id'], $languages)) {
            $lang_id = $list['lang_id'];
            $lang = $languages[$lang_id];
            if($lang =='none'||$lang ==NULL){
                $lang='English';
            }
        }else{
                $lang='<a href="'.site_url().'/languages/admin">Activate Language</a>';
            }
        $output .= "<tr ";
        /*
        if($list['lang_id']>0){
            $output .= " class='dentme'";
        }
         */
        $output .= " valign='top'>\n";
        $output .= "<td>". $list['id']."</td>\n";
        /*
        if($list['lang_id']==0){
            // for English
            $output .= "<td class=\"" . $depthClassMapping[$depth] . "\"><a href=\"". site_url(). '/menus/admin/edit/' .  $list['id'] .'/'.$list['page_uri_id'].'/'.$list['lang_id']. '">' . $list['name']."</a></td>\n";
        }else{
            // for other language
            $output .= "<td class=\"" . $depthClassMapping[$depth] . "\"><a href=\"". site_url(). '/menus/admin/edit/' .  $list['menu_id'] .'/'.$list['page_uri_id'].'/'.$list['lang_id'].'/'.$list['id']. '">' . $list['name']."</a></td>\n";
        }
        */
        $output .= "<td class=\"" . $depthClassMapping[$depth] . "\"><a href=\"". site_url(). '/menus/admin/edit/';
        ($list['lang_id']==0)? $output .=$list['id'] : $output .= $list['menu_id'];
        $output .='/'.$list['page_uri_id'].'/'.$list['lang_id'];
        ($list['lang_id']==0)? $output .='' :$output .='/'.$list['id'];
        $output .='">' . $list['name']."</a></td>\n";


        $output .= "<td align='center'>";
        // don't forget to add $module=$this->uri->segment(1); at the top of this page
        $active_icon = ($list['status']=='active'?'tick':'cross');
        $output .= anchor("kaimonokago/admin/changeStatus/menus/".$list['id'],'<img src="'.base_url().'assets/icons/'.$active_icon.'.png"  alt="'.$active_icon.'" />', array('class' => $list['status']));
        $output .= "</td>\n";
        //$output .= "<td align='center'>". $list['status']."</td>\n";
        $output .= "<td align='center'>". $list['parentid']."</td>\n";
        $output .= "<td class=\"" . $depthClassMapping[$depth] . "\" >". $list['order']."</td>\n";
        $output .= "<td align='center'>";
        if(isset($path)){
            $output.=$path;
        }
        $output.="</td>\n";
        //$output .= "<td align='center'>". $list['page_uri']."</td>\n";
        $output .= "<td align='center'>". $list['page_uri_id']."</td>\n";
        $output .= "<td align='center'>". $list['lang_id']."</td>\n";
        $output .= "<td align='center'>". $list['menu_id']."</td>\n";
        $output .= "<td align='center'>". $lang."</td>\n";
        $output .= "<td align='center'>";
        $output .= anchor('menus/admin/edit/'. $list['id'],'<img src="'.base_url().'assets/icons/pencil.png"  alt="edit" />');
        // show delete if parentid is not 0
        // if (!$list['parentid']== '0' && $list['status']=='inactive'){
        // In order not to show delete link for English, parent_id 0, lang_id 0 
        if(!($list['parentid']== '0'  && $list['lang_id']=='0') && $list['status']=='inactive') {
        // if ($list['status']=='inactive')
           // $output .= " | ";
            //$output .= anchor("kaimonokago/admin/delete/menus/". $list["id"],"delete", array("onclick"=>"return confirmSubmit('".$list['name']."')"));
            $output .= anchor("menus/admin/deleteMenu/". $list["id"],'<img src="'.base_url().'assets/icons/delete.png"  alt="delete" />', array("onclick"=>"return confirmSubmit('".$list['name']."')"));

        }

        $output .= "</td>\n";
        $output .= "</tr>\n";

        // if the row has any children, parse those to ensure we have a properly 
        // displayed nested table
        if (!empty($list['children'])) {
            generateRowsByLevel($list['children'], $output, $depth + 1,$pages,$languages);
        }
    }
}


//==================
// RUN THE GENERATOR 
//==================
if (count($navlist)){

    // begin table
    $output = "<div  id='menutable'><table border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
    $output .= "<thead>\n<tr valign='top'>\n";
    $output .= "<th>ID</th>\n<th>".$this->lang->line('kago_name')."</th><th>".$this->lang->line('kago_status').
            "</th><th>".$this->lang->line('kago_parentid')."</th><th>".$this->lang->line('kago_order').
            "</th><th>".$this->lang->line('kago_page_uri')."</th><th>".$this->lang->line('kago_page_uri_id').
            "</th><th>".$this->lang->line('kago_lang_id')."</th><th>".$this->lang->line('kago_menu_id').
            "</th><th>".$this->lang->line('kago_lang')."</th><th>".$this->lang->line('kago_actions')."</th>\n";
    $output .= "</tr>\n</thead>\n<tbody>\n";
    // generate all table rows
    generateRowsByLevel($navlist, $output,$depth = 0,$pages,$languages);
    // close up the table
    $output .= "</tbody>\n</table></div>";
    // display table
    echo $output;
}

echo "<pre>pages";
print_r ($pages);
//var_dump($page_uri_id);
echo "</pre>";
echo "<pre>languages";
print_r ($languages);
//var_dump($page_uri_id);
echo "</pre>";

echo "<pre>navlist";
print_r ($navlist);
//var_dump($page_uri_id);
echo "</pre>";

?>
