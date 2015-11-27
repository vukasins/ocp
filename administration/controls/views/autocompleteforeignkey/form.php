<?php
// load maped objects
$where = array();
$order = array();

//$where[] = array('AND', 'id', '!=', $parent_sys_object_id);
$order[] = array('table_name', 'ASC');

$maped_object = new Crud_Models_Object();
$maped_objects = $maped_object->search($where, $order);
?>
<div class="form-group">
	<label>Table</label> 
	<div class="ocp-select">
		<select class="form-control" name="control-properties-table_name[<?=$field->id?>]">
			<option value=""></option>
			<?php foreach($maped_objects as $maped_object): ?>
				<option <?=(isset($properties->table_name) && $properties->table_name == $maped_object->table_name ? 'selected="selected"' : '')?> value="<?=$maped_object->table_name?>"><?=$maped_object->table_title?></option>
			<?php endforeach;?>
		</select>
	</div>
</div>
