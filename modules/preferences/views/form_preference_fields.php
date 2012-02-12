<h2><?php print $header;?></h2>

<?php print form_open($form_link);?>
<table id="preference_form">
	<?php foreach($field as $name => $data): ?>
	<tr>
	    <td class='label'>

	    <?php print form_label($data['label'],$name);?>
	    <?php
	    if (FALSE !== ($desc = $this->lang->line('preference_desc_'.$name)))
	    {
	        print "<small>".$desc."</small>";
	    }
	    ?>
	    </td>
	    <td><?php print $data['input'];?></td>
	</tr>
	<?php endforeach; ?>
</table>

<div class="buttons">
	<button type="submit" class="positive" name="submit" value="submit">
    <?php print $this->bep_assets->icon('disk');?>
    <?php print $this->lang->line('general_save');?>
    </button>

    <a href="<?php print site_url($cancel_link);?>" class="negative">
    <?php print $this->bep_assets->icon('cross');?>
    <?php print $this->lang->line('general_cancel');?>
    </a>
</div>
<?php print form_close();?>