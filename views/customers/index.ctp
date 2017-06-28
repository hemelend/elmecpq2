<div class="customers index">
	<h2><?php __('Customers');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('medidor');?></th>
			
			<th><?php echo $this->Paginator->sort('ubicacion');?></th>
			<!--
			<th><?php //echo $this->Paginator->sort('topologia');?></th>
			<th><?php //echo $this->Paginator->sort('servicio');?></th>
			-->
			<th><?php echo $this->Paginator->sort('system_id');?></th>
			<th><?php echo $this->Paginator->sort('equipment_id');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<!--
			<th><?php //echo $this->Paginator->sort('action');?></th>
			<th><?php //echo $this->Paginator->sort('failed_reason');?></th>
			<th><?php //echo $this->Paginator->sort('analysis_done');?></th>
			-->
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($customers as $customer):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $customer['Customer']['id']; ?>&nbsp;</td>
		<td><?php echo $customer['Customer']['name']; ?>&nbsp;</td>
		<td><?php echo $customer['Customer']['medidor']; ?>&nbsp;</td>
		
		<td><?php echo $customer['Customer']['ubicacion']; ?>&nbsp;</td>
		<!--
		<td><?php //echo $customer['Customer']['topologia']; ?>&nbsp;</td>
		<td><?php //echo $customer['Customer']['servicio']; ?>&nbsp;</td>
		-->	
		<td><?php echo $customer['System']['name']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($customer['Equipment']['mark']."-".$customer['Equipment']['model']."-".$customer['Equipment']['serialnumber'], array('controller' => 'equipment', 'action' => 'view', $customer['Equipment']['id'])); ?>
		</td>
		<td><?php echo $customer['Customer']['status']; ?>&nbsp;</td>
		<!--
		<td><?php //echo $customer['Customer']['action']; ?>&nbsp;</td>
		<td><?php //echo $customer['Customer']['failed_reason']; ?>&nbsp;</td>
		<td><?php //echo $customer['Customer']['analysis_done']; ?>&nbsp;</td>
		-->
		<td class="actions">
			<?php echo $ajax->link('DataFile', array('action' => 'uploader', $customer['Customer']['id'],$customer['Customer']['equipment_id']), array('update' => 'uploader')); ?> 
			<?php echo $ajax->link('LoadProFile', array('action' => 'addloadprofile', $customer['Customer']['id'],$customer['Customer']['equipment_id']), array('update' => 'uploader')); ?>
			<?php echo $this->Html->link(__('Analysis', true), array('action' => 'analysis', $customer['Customer']['id'])); ?>
			<?php echo $this->Html->link(__('Report', true), array('action' => 'reportsummary', $customer['Customer']['id']),array('target' => '_blank')); ?>
			<?php echo $this->Html->link(__('Trend', true), array('controller' => 'powerqs', 'action' => 'trender', $customer['Customer']['id']),array('target' => '_blank')); ?>
			<?php echo $this->Html->link(__('Show/Edit', true), array('action' => 'edit', $customer['Customer']['id'])); ?>
			<?php //echo $this->Html->link(__('Delete', true), array('action' => 'delete', $customer['Customer']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $customer['Customer']['id'])); ?>
			
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<div id="uploader">
	</div>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Customer', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Equipment', true), array('controller' => 'equipment', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Equipment', true), array('controller' => 'equipment', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Report', true), array('controller' => 'customers', 'action' => 'reportform')); ?> </li>

	</ul>
</div>