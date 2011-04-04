<h2><?php echo $title;?></h2>
<p><?php echo anchor("menus/admin/create", $this->lang->line('kago_create_menu'));?> <?php //echo anchor("menus/admin/createLangRoot",$this->lang->line('kago_create_lang_root'));?></p>
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
    foreach ($navlist as $row) {
        // This is ugly, there must be a better way. But for now.
        if (array_key_exists($row['page_uri_id'], $pages)) {
            $pathid = $row['page_uri_id'];
            $path = $pages[$pathid];
            if($path =='none'){
                $path=NULL;
            }
        }
        // This is ugly, there must be a better way. But for now.
        if (array_key_exists($row['lang_id'], $languages)) {
            $lang_id = $row['lang_id'];
            $lang = $languages[$lang_id];
            if($lang =='none'||$lang ==NULL){
                $lang='English';
            }
        }else{
                $lang='<a href="'.site_url().'/languages/admin">Activate Language</a>';
            }
        $output .= "<tr ";
        /*
        if($row['lang_id']>0){
            $output .= " class='dentme'";
        }
         */
        $output .= " valign='top'>\n";
        $output .= "<td>". $row['id']."</td>\n";
        /*
        if($row['lang_id']==0){
            // for English
            $output .= "<td class=\"" . $depthClassMapping[$depth] . "\"><a href=\"". site_url(). '/menus/admin/edit/' .  $row['id'] .'/'.$row['page_uri_id'].'/'.$row['lang_id']. '">' . $row['name']."</a></td>\n";
        }else{
            // for other language
            $output .= "<td class=\"" . $depthClassMapping[$depth] . "\"><a href=\"". site_url(). '/menus/admin/edit/' .  $row['menu_id'] .'/'.$row['page_uri_id'].'/'.$row['lang_id'].'/'.$row['id']. '">' . $row['name']."</a></td>\n";
        }
        */
        $output .= "<td class=\"" . $depthClassMapping[$depth] . "\"><a href=\"". site_url(). '/menus/admin/edit/';
        ($row['lang_id']==0)? $output .=$row['id'] : $output .= $row['menu_id'];
        $output .='/'.$row['page_uri_id'].'/'.$row['lang_id'];
        ($row['lang_id']==0)? $output .='' :$output .='/'.$row['id'];
        $output .='">' . $row['name']."</a></td>\n";


        $output .= "<td align='center'>";
        // don't forget to add $module=$this->uri->segment(1); at the top of this page
        $output .= anchor("kaimonokago/admin/changeStatus/menus/".$row['id'],$row['status'], array('class' => $row['status']));
        $output .= "</td>\n";
        //$output .= "<td align='center'>". $row['status']."</td>\n";
        $output .= "<td align='center'>". $row['parentid']."</td>\n";
        $output .= "<td class=\"" . $depthClassMapping[$depth] . "\" >". $row['order']."</td>\n";
        $output .= "<td align='center'>";
        if(isset($path)){
            $output.=$path;
        }
        $output.="</td>\n";
        //$output .= "<td align='center'>". $row['page_uri']."</td>\n";
        $output .= "<td align='center'>". $row['page_uri_id']."</td>\n";
        $output .= "<td align='center'>". $row['lang_id']."</td>\n";
        $output .= "<td align='center'>". $row['menu_id']."</td>\n";
        $output .= "<td align='center'>". $lang."</td>\n";
        $output .= "<td align='center'>";
        $output .= anchor('menus/admin/edit/'. $row['id'],'edit');
        // show delete if parentid is not 0
        // if (!$row['parentid']== '0' && $row['status']=='inactive'){
        // In order not to show delete link for English, parent_id 0, lang_id 0 
        if(!($row['parentid']== '0'  && $row['lang_id']=='0') && $row['status']=='inactive') {
        // if ($row['status']=='inactive')
            $output .= " | ";
            //$output .= anchor("kaimonokago/admin/delete/menus/". $row["id"],"delete", array("onclick"=>"return confirmSubmit('".$row['name']."')"));
            $output .= anchor("menus/admin/deleteMenu/". $row["id"],'delete', array("onclick"=>"return confirmSubmit('".$row['name']."')"));

        }

        $output .= "</td>\n";
        $output .= "</tr>\n";

        // if the row has any children, parse those to ensure we have a properly 
        // displayed nested table
        if (!empty($row['children'])) {
            generateRowsByLevel($row['children'], $output, $depth + 1,$pages,$languages);
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
