<?php print displayStatus();?>
<div id="homeright"  class="adminhome">
    <form method="post" id="form" action="admin/insertShoutBox" >
        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>" />
        <input type="hidden" name="user" id="nick" value="<?php echo $username;?>" />
        <p class="messagelabel"><label class="messagelabel">Message</label>
        <textarea  id="message" name="message" rows="2" cols="80"></textarea>
        </p>
        <div class="buttons">
	<button type="submit" class="positive" name="submit" value="submit">
        <?php print $this->bep_assets->icon('disk');?>
        <?php print $this->lang->line('general_save');?>
        </button>
        </div>
    </form>
    <div id="loading"><img src="../../assets/images/general/ajax-loader2.gif" alt="Loading now. Smile" /></div>
    <div class="clearboth"></div>
    <div id="container">
    <span class="clear"></span>
    <div class="content">
        <h1>Latest Messages or Task To Do</h1>
        <ul id="message_ul" >
        </ul>
        <ul class="hideme">
        <?php
        if(is_array($todos)){
        foreach ($todos as $key => $todo){
         echo "\n<li class=\"".$todo['id']."\">\n<div class=\"listbox\"><span class=\"user\"><strong>".$todo['user']."</strong></span>\n\n<span class=\"date\" >" .$todo['date']."</span>\n";
         echo anchor ('messages/admin/changestatus/'.$todo['id'],$todo['status'],array('class'=>'todo'));
         echo "<span class=\"msg\">".$todo['message'].
        "</span></div></li>";
        }
        }else{
                echo $todos;
        }
        ?>
        </ul>
    </div>
    </div>

    <div id="completed">
    <h1>Completed Lists</h1>
    <ul id="completed_ul">


    </ul>

    <ul class="hideme">
            <?php
            if(is_array($completed)){
                    foreach ($completed as $key => $list){
                    echo "\n<li class=\"".$list['id']."\">\n<span class=\"user\"><strong>".$list['user']."</strong></span>\n<span class=\"date\" >" .$list['date']."</span>\n";
                    echo anchor ('messages/admin/changestatus/'.$list['id'],$list['status'],array('class'=>'completedmsg'));
                    echo	 "\n<a href=\"admin/delete/"
                             .$list['id']."\" id=\"".$list['id']."\" class=\"delete\">x</a><span class=\"msg\">".$list['message'].
                            "</span>\n</li>";
                            }
            }else{
                                    echo $completed;
                            }
            ?>
    </ul>

            </div>
</div>