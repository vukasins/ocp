<?php
// load maped objects
$where = array();
$order = array();

//$where[] = array('AND', 'id', '!=', $parent_sys_object_id);
$order[] = array('table_name', 'ASC');

$maped_object = new Crud_Models_Object();
$maped_objects = $maped_object->search($where, $order);


$where = array();
$where[] = array('AND', 'id_sys_object', '=', $field->id_sys_object);
$where[] = array('AND', 'id', '!=', $field->id);

$sys_field = new Crud_Models_Field();
$sys_fields = $sys_field->search($where);
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


<div class="form-group">
	<label>Conditional field</label> 
	<div class="ocp-select">
		<select class="form-control" name="control-properties-conditional_field_id[<?=$field->id?>]">
			<option value=""></option>
			<?php foreach($sys_fields as $sys_field): ?>
				<option <?=(isset($properties->conditional_field_id) && $properties->conditional_field_id == $sys_field->id ? 'selected="selected"' : '')?> value="<?=$sys_field->id?>"><?=$sys_field->field_name?></option>
			<?php endforeach;?>
		</select>
	</div>
</div>
