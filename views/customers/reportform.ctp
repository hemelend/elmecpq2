<div class="customers form">
<form action="reportsummary" method="post" enctype="multipart/form-data">
	<fieldset>
 		<legend><?php __('Report form'); ?></legend>
<?php 
	echo "<input name='data[report][type]' value='summary' id='reportType' type='hidden'>";
?>
<div class="input text required">
	<label>Select start date:</label>
	<?php echo $this->Form->month('month1', $selected = null, $attributes = array('empty' => true))?>
	<?php echo $this->Form->day('day1', $selected = null, $attributes = array('empty' => true))?>
	<?php echo $this->Form->year('year1',2009,date('Y'))?>
	<br>
	<label>Select end date:</label>
	<?php echo $this->Form->month('month2', $selected = null, $attributes = array('empty' => true))?>
	<?php echo $this->Form->day('day2', $selected = null, $attributes = array('empty' => true))?>
	<?php echo $this->Form->year('year2',2009,date('Y'))?>
	<br>
	<br>
	<input type="submit" name="Create Report" />
</div>
	</fieldset>
</form> 
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Customer.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Customer.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Customers', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Equipment', true), array('controller' => 'equipment', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Equipment', true), array('controller' => 'equipment', 'action' => 'add')); ?> </li>
	</ul>
</div>