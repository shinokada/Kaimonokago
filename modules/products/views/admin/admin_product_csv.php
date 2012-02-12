<?php
if (count($csv)){
	echo form_open('products/admin/import');
	echo form_submit('cancel','<< start over');
	echo form_submit('submit','finalize import >>');
	?>
	<table border='1' cellspacing='0' cellpadding='5'>
	<tr valign='top'>
	<?php
		$headers = array_keys($csv[0]);
		foreach ($headers as $v){
			$hdr = trim(str_replace('"','',$v));
			if ($hdr != '' && !eregi("thumbnail",$hdr) && !eregi("image",$hdr)){
				echo "<th>".$hdr."</th>\n";	
			}
		}
	?>
	</tr>
	<?php
	
		foreach ($csv as $key => $line){
			echo "<tr valign='top'>\n";
			foreach ($line as $f => $d){
				$FIELD = trim(str_replace('"','',$f));
				$FDATA = trim(str_replace('"','',$d));
				if ($FIELD != '' && !eregi("thumbnail",$FDATA) && !eregi("image",$FDATA)){
					echo "<td>";
					echo $FDATA . "\n";
					echo form_hidden("line_$key"."[".$FIELD."]",$FDATA);
					echo "</td>\n";
				}
				
			}
			echo "</tr>\n";
		}
	?>
	</table>
	<?php
	echo form_hidden('csvgo',true);
	echo form_close();
}else{
	echo "<h1>We detected a problem...</h1>";
	echo "<p>No records to import! Please try again.</p>";
}
?>