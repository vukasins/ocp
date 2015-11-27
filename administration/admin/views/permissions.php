<section class="content-header">
	<h1 class="page-header">Role permissions</h1>
</section>

<?php if($saved_status != ''): ?>
	<div class="form-group">
		<div class="alert alert-success alert-dismissable">
			<i class="fa fa-check"></i>
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<b><?=__('Success!')?></b> <?=$saved_status?>
		</div>
	</div>
<?php endif; ?>

<form action="" method="post" class="frm-save">
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<?php foreach ($roles as $role): ?>
			<?php
				$where = array();
				$where[] = array('AND', 'id_adm_user_role', '=', $role->id);
			
				$permission = new Libraries_Db_Mysql_Model('adm_user_role_permission');
				$permissions = $permission->search($where);
			?>
			<div class="panel panel-default" data-field-id="<?=$role->id?>">
				<div class="panel-heading" role="tab" id="heading<?=$role->title;?>">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion"
							href="#collapse<?=$role->title;?>" aria-expanded="true"
							aria-controls="collapse<?=$role->title;?>"> <?=$role->title;?> </a>
					</h4>
				</div>
		
				<div id="collapse<?=$role->title;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$role->title;?>">
					<div class="panel-body">
						<table class="table table-striped dataTable table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Object</th>
									<th class="ocp-permissions-view"><i class="fa fa-eye"></i><br>Can view</th>
									<th class="ocp-permissions-edit"><i class="fa fa-pencil"></i><br>Can edit</th>
									<th class="ocp-permissions-delete"><i class="fa fa-times"></i><br>Can delete</th>
								</tr>
							</thead>
							
							<tbody>
								<?php foreach($objects as $i => $object): ?>
									<?php
										$can_view = true;
										$can_edit = true;
										$can_delete = true;
										
										foreach($permissions as $permission)
										{
											if($permission->action == 'can_view_' . $object->table_name && $permission->is_active == 0)
											{
												$can_view = false;
											}
					
											if($permission->action == 'can_edit_' . $object->table_name && $permission->is_active == 0)
											{
												$can_edit = false;
											}
					
											if($permission->action == 'can_delete_' . $object->table_name && $permission->is_active == 0)
											{
												$can_delete = false;
											}
										}
									?>
									<tr>
										<td><?=($i + 1)?></td>
										<td><?=$object->table_title?></td>
										<td class="text-center">
												<input type="checkbox" value="1" id="can_view_<?=$object->table_name?>_<?=$role->id?>" name="can_view_<?=$object->table_name?>[<?=$role->id?>]" <?=($can_view == true ? 'checked="checked"' : '')?> /> 
												<label for="can_view_<?=$object->table_name?>_<?=$role->id?>"></label>
										</td>
										<td class="text-center">
												<input type="checkbox" value="1" id="can_edit_<?=$object->table_name?>_<?=$role->id?>" name="can_edit_<?=$object->table_name?>[<?=$role->id?>]" <?=($can_edit == true ? 'checked="checked"' : '')?> />
												<label for="can_edit_<?=$object->table_name?>_<?=$role->id?>"></label>
										</td>
										<td class="text-center">
												<input type="checkbox" value="1" id="can_delete_<?=$object->table_name?>_<?=$role->id?>" name="can_delete_<?=$object->table_name?>[<?=$role->id?>]" <?=($can_delete == true ? 'checked="checked"' : '')?> />
												<label for="can_delete_<?=$object->table_name?>_<?=$role->id?>"></label>
										</td>
									</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</form>

<div class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box text-right">
				<a class="btn btn-primary save-permissions" href="#"><i class="fa fa-save"></i> Save</a>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('input[type=checkbox]').change(function(e) {
			if($(this).is(':checked'))
			{
				$(this).parents('td').nextAll().each(function() {
					$(this).find('input[type=checkbox]').removeAttr('disabled');
				});
			}
			else
			{
				$(this).parents('td').nextAll().each(function() {
					$(this).find('input[type=checkbox]').removeAttr('checked');
					$(this).find('input[type=checkbox]').attr('disabled', true);
				});
			}
		});
		
		$('.save-permissions').click(function(e) {
			e.preventDefault();

			$(this).parents('.container-fluid').find('.frm-save').submit();

			return false;
		});
	});
</script>