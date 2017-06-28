<div class="customers form">
<?php echo $this->Form->create('Customer');?>
	<fieldset>
 		<legend><?php __('Add Customer'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('medidor');
		echo $this->Form->input('ubicacion');
		echo $this->Form->input('topologia');
		echo $this->Form->input('servicio');
		echo "<div class='input select required'>";
		echo $this->Form->label('system_id');
		$options=$systems;
		echo $this->Form->select('system_id', $options,null,array('empty' => false));
		echo "</div>";
		echo "<div class='input select required'>";
		echo $this->Form->label('equipment_id');
		$options2 = $equipments;
		echo $this->Form->select('equipment_id', $options2,null,array('empty' => false));
		echo "</div>";
		echo $this->Form->input('status');
//		echo $this->Form->input('action');
//		echo $this->Form->input('failed_reason');
//		echo $this->Form->input('analysis_done');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Customers', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Equipment', true), array('controller' => 'equipment', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Equipment', true), array('controller' => 'equipment', 'action' => 'add')); ?> </li>
	</ul>
</div>