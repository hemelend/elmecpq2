<form action="customers/loadprofile" method="post" enctype="multipart/form-data">
<?php 
	echo "<input name='data[customers][id]' value='".$this->params['pass'][0]."' id='customersId' type='hidden'>";
    echo "<input name='data[customers][equipment_id]' value='".$this->params['pass'][1]."' id='customersEquipmentId' type='hidden'>";
?>
<div class="input text required">
	<label>Select LoadProfile File:</label>
	<input type="file" name="data[customers][loadprofile]" />
	<input type="submit" name="Upload LOADPROFILE" />
</div>
</form> 