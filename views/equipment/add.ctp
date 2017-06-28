<div class="equipment form">
<?php echo $this->Form->create('Equipment');?>
	<fieldset>
 		<legend><?php __('Add Equipment'); ?></legend>
	<?php
		echo "<div class='input select required'>";
		echo $this->Form->label('mark');
		$options=array("Enetics"=>"Enetics","Dewetron"=>"Dewetron","Elstar"=>"Elstar");
		echo $this->Form->select('mark', $options);
		echo "</div>";
//		echo $this->Form->input('mark');
		echo $this->Form->input('model');
		echo $this->Form->input('serialnumber');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Equipment', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Customers', true), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer', true), array('controller' => 'customers', 'action' => 'add')); ?> </li>
	</ul>
</div>