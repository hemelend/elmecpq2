<div class="customers index" style="height:500px">

<!--
	<h2><?php __('Values out of range');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>Customer</th>
			<th>Metric</th>
			<th>Value</th>
			<th>Date</th>
	</tr>
	<?php
	$i = 0;
	foreach ($values as $value):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $value['Outvalue']['customer_id']; ?>&nbsp;</td>
		<td><?php echo $value['Outvalue']['metric']; ?>&nbsp;</td>
		<td><?php echo $value['Outvalue']['value']; ?>&nbsp;</td>
		<td><?php echo $value['Outvalue']['date']; ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
-->
	<iframe id="blockrandom"
	    name="iframe"
		src="../gridanalysis/<?php echo $id;?>/<?php echo $result;?>"
	    width="100%"
	    height="100%"
	    scrolling="auto"
	    frameborder="0">
	    This option will not work correctly. Unfortunately, your browser does not support inline frames.                   
	</iframe>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Customers', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Equipment', true), array('controller' => 'equipment', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Equipment', true), array('controller' => 'equipment', 'action' => 'add')); ?> </li>
	</ul>
</div>