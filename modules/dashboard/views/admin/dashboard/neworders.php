<table width="100%" cellspacing="0">
	<thead>
		<tr><th width="50%"><?php print $this->lang->line('dashboard_statistics_name') ?></th><th><?php print $this->lang->line('dashboard_statistics_value') ?></th></tr>
	</thead>

	<tbody>
		<tr><td><?php print $this->lang->line('dashboard_statistics_total_orders') ?></td><td><?php print $total_orders ?></td></tr>
		<tr><td><?php print $this->lang->line('dashboard_statistics_total_new_orders') ?></td><td><?php print $total_new_orders ?></td></tr>
		<tr><th><?php print $this->lang->line('dashboard_statistics_order_total') ?></th><th><?php print $this->lang->line('dashboard_order_date') ?></th></tr>
		
		<?php
                /*
                echo "<pre>";
                print_r ($orderdetails);
                echo "</pre>";
                   echo "<pre>";
                print_r ($total_new_orders);
                echo "</pre>";
                   echo "<pre>";
                print_r ($total_orders);
                echo "</pre>";
*/

if ($orderdetails->num_rows() > 0){
       foreach ($orderdetails->result_array() as $row){
        echo '<tr><td>'. $row['total'].'</td><td>'. 
        $row['order_date'].'</td></tr>';
       }
    }
?>
		</tbody>
</table>

