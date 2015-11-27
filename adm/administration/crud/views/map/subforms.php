<div class="box">
	<p><a href="#" class="btn btn-primary create-new add"><i class="fa fa-plus"></i> Add new</a></p>
</div>
<div class="dataTables_wrapper form-inline">
	<div class="table-responsive">
		<table class="table table-striped dataTable table-hover subforms">
			<thead>
				<tr>
					<th>Object</th>
					<th>Field</th>
					<th>Relation title</th>
					<th style="width: 110px;"><i class="fa fa-cogs"></i> Action</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Object</th>
					<th>Field</th>
					<th>Relation title</th>
					<th style="width: 110px;"><i class="fa fa-cogs"></i> Action</th>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach($selected_maped_objects as $selected_maped_object): ?>
					<?php 
						$field = new Crud_Models_Field();
						$field->load($selected_maped_object->id_sys_field);
						
						$sys_object = new Crud_Models_Object();
						$sys_object->load($selected_maped_object->id_sys_object_child);
						$sys_object->loadFieldsForObject();
					?>
					<tr class="form-group">
						<td>
							<div class="ocp-select">
								<select name="id_sys_object_child[<?=$selected_maped_object->id?>]" class="form-control table-selector">
									<option value=""></option>
									<?php foreach($maped_objects as $maped_object): ?>
										<option <?=($maped_object->id == $selected_maped_object->id_sys_object_child ? 'selected="selected"' : '')?> value="<?=$maped_object->id?>"><?=$maped_object->table_title?></option>
									<?php endforeach;?>
								</select>
							</div>
						</td>
						<td>
							<div class="ocp-select">
								<select name="sys_field_title[<?=$selected_maped_object->id?>]" class="form-control field-selector">
									<?php foreach($sys_object->sys_field_list as $sys_field): ?>
										<option value="<?=$sys_field->field_name?>" <?=($sys_field->field_name == $field->field_name ? 'selected="selected"' : '')?>><?=$sys_field->field_title?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</td>
						<td>
							<input type="text" name="title[<?=$selected_maped_object->id?>]" value="<?=$selected_maped_object->title?>" class="form-control" />
						</td>
						<td>
							<input type="hidden" name="delete[<?=$selected_maped_object->id?>]" value="0" />
							<a href="#" class="btn btn-danger btn-xs delete remove"><i class="fa fa-times"></i> Remove</a>
						</td>
					</tr>
				<?php endforeach; ?>

					<tr class="form-group clone">
						<td>
							<div class="ocp-select">
								<select name="id_sys_object_child[]" class="form-control table-selector">
									<option value=""></option>
									<?php foreach($maped_objects as $maped_object): ?>
										<option value="<?=$maped_object->id?>"><?=$maped_object->table_title?></option>
									<?php endforeach;?>
								</select>
							</div>
						</td>
						<td>
							<div class="ocp-select">
								<select name="sys_field_title[]" class="form-control field-selector">
									<option value=""></option>
								</select>
							</div>
						</td>
						<td>
							<input type="text" name="title[]" value="" class="form-control" />
						</td>
						<td>
							<a href="#" class="btn btn-danger btn-xs delete remove"><i class="fa fa-times"></i> Remove</a>
						</td>
					</tr>
			</tbody>
		</table>
	</div>
</div>

<script>
	var subform_clone = $('.subforms .form-group.clone').clone();

	var remove = function(event) {
		event.preventDefault();
		
		var root = $(this).parents('tr');

		$(root).find('input[type=hidden]').val('1');
		$(root).hide();
		//$(root).parent().hide();

		return false;
	};

	var add = function(event) {
		event.preventDefault();
		
		$(this).parents('.form-group').find('table').append($(subform_clone).clone());

		unbindSubformEvents();
		bindSubformEvents();

		return false;
	};

	var loadFieldsForTable = function() {
		var sys_object_id = $(this).val();
		var root = $(this).parents('tr');

		$.ajax({
			type: "POST",
			url: '<?=SITE_ROOT_URI?>/crud/objects/getfields',
			data: {sys_object_id: sys_object_id},
			dataType: 'json',
			success: function(response) {
				$(root).find('.field-selector').html('');

				for(i = 0; i < response.length; i++)
				{
					$(root).find('.field-selector').append('<option value="' + response[i].field_name + '">' + response[i].field_title + '</option>');
				}
			}
		});
	};

	var bindSubformEvents = function() {
		$('.remove').bind('click', remove);
		$('.add').bind('click', add);
		$('.table-selector').bind('change', loadFieldsForTable);
	};

	var unbindSubformEvents = function() {
		$('.remove').unbind('click');
		$('.add').unbind('click');
		$('.table-selector').unbind('change');
	};

	$(document).ready(function() {
		unbindSubformEvents();
		bindSubformEvents();
	});
</script>