<section class="content-header">
	<h1 class="page-header">Map objects</h1>
</section>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="heading-user">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse-user" aria-expanded="true" aria-controls="collapse-user"> <?=__('User objects')?> </a>
			</h4>
		</div>

		<div id="collapse-user" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-user">
			<div class="panel-body">
				<table class="table table-striped dataTable table-hover" aria-describedby="example1_info">
					<thead>
						<tr>
							<th>#</th>
							<th>Object</th>
							<th>Title</th>
							<th style="width: 240px;"><i class="fa fa-cogs"></i> Actions</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<th>#</th>
							<th>Object</th>
							<th>Title</th>
							<th style="width: 240px;"><i class="fa fa-cogs"></i> Actions</th>
						</tr>
					</tfoot>

					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php $system_objects = array(); ?>
					<?php foreach ($available_db_objects as $i => $available_db_object):?>
						<?php
							$object = new Crud_Models_Object();
							$object->load($available_db_object, 'table_name');
							
							if(!$object->isEmpty() && $object->is_system == 1)
							{
								$system_objects[] = $object;
								continue;
							}
						?>
						<tr class="<?=(($i + 1) % 2 == 0 ? 'event' : 'odd')?>">
							<td><?=($i + 1)?></td>
							<td><?=$available_db_object?></td>
							<td><?=(!$object->isEmpty() ? $object->table_title : '')?></td>
							<td style="width: 240px;">
								<?php if(!$object->isEmpty()):?><a class="btn btn-primary btn-xs modifyForm" href="<?=SITE_ROOT_URI?>/crud/objects/modifyForm/<?=$object->id?>" data-object-id="<?=$object->id?>"><i class="fa fa-pencil"></i> <?=__('Modify')?></a> <?php endif; ?>
								<a class="btn btn-info btn-xs mapObject" href="<?=SITE_ROOT_URI?>/crud/objects/map/<?=$available_db_object?>"><i class="fa fa-sitemap"></i> <?=($object->isEmpty() ? __('Map') : __('Remap'))?></a> 
								<?php if(!$object->isEmpty()):?> <a class="btn btn-danger btn-xs" data-toggle="modal" data-object-id="<?=$object->id?>" role="button" href="#deleteModal"><i class="fa fa-times"></i> <?=__('Delete')?></a> <?php endif; ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="heading-system">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse-system" aria-expanded="true" aria-controls="collapse-system"> <?=__('System objects')?> </a>
			</h4>
		</div>

		<div id="collapse-system" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-system">
			<div class="panel-body">
				<table class="table table-striped dataTable table-hover" aria-describedby="example1_info">
					<thead>
						<tr>
							<th>#</th>
							<th>Object</th>
							<th style="width: 240px;"><i class="fa fa-cogs"></i> Actions</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<th>#</th>
							<th>Object</th>
							<th style="width: 240px;"><i class="fa fa-cogs"></i> Actions</th>
						</tr>
					</tfoot>

					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($system_objects as $i => $object):?>
						<tr class="<?=(($i + 1) % 2 == 0 ? 'event' : 'odd')?>">
							<td><?=($i + 1)?></td>
							<td><?=$object->table_name?></td>
							<td style="width: 240px;">
								<?php if(!$object->isEmpty()):?><a class="btn btn-primary btn-xs modifyForm" href="<?=SITE_ROOT_URI?>/crud/objects/modifyForm/<?=$object->id?>" data-object-id="<?=$object->id?>"><i class="fa fa-pencil"></i> <?=__('Modify')?></a> <?php endif; ?>
								<a class="btn btn-info btn-xs mapObject" href="<?=SITE_ROOT_URI?>/crud/objects/map/<?=$object->table_name?>"><i class="fa fa-sitemap"></i> <?=($object->isEmpty() ? __('Map') : __('Remap'))?></a> 
								<?php if(!$object->isEmpty()):?> <a class="btn btn-danger btn-xs" data-toggle="modal" data-object-id="<?=$object->id?>" role="button" href="#deleteModal"><i class="fa fa-times"></i> <?=__('Delete')?></a> <?php endif; ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modifyFormModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Modify form</h4>
			</div>

			<div class="modal-body"></div>

			<div class="modal-footer">
				<button type="button" class="btn btn-primary">Save</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
	$(document).ready(function() {
		$('#deleteModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var object_id = button.data('object-id');

			$('#deleteModal').find('.btn.btn-primary').data('object-id', object_id);
		});

		$('#deleteModal').on('hide.bs.modal', function (event) {
			$('#deleteModal').find('.btn.btn-primary').removeAttr('data-object-id');
		});
		
		$('#deleteModal .btn.btn-primary').on('click', function() {
			var object_id = $(this).data('object-id');

			$('#loaderModal').modal('show');
			$("#deleteModal").modal('hide');

			$.ajax({
				type: "POST",
				url: "<?=SITE_ROOT_URI . '/crud/objects/delete/'?>",
				data: {object_id: object_id},
				success: function(response) {
					window.location.reload();
				}
			});
		});

		$('#modifyFormModal').on('hide.bs.modal', function (event) {
			$('#modifyFormModal').find('.modal-body').html('');
			$('#modifyFormModal').removeAttr('data-object-id');
		});

		$('#modifyFormModal .btn.btn-primary').on('click', function (event) {
			var object_id = $('#modifyFormModal').data('object-id');

			var data = $('#modifyFormModal form').serializeArray();

			$('#modifyFormModal form').submit();
			
			console.log(data);
			return false;
			
			$('#modifyFormModal').modal('hide');
			$('#loaderModal').modal('show');

			$.ajax({
				type: "POST",
				url: "<?=SITE_ROOT_URI?>/crud/objects/modify/" + object_id,
				data: data,
				success: function(response) {
					window.location.reload();
				}
			});
		});

		$('.modifyForm').on('click', function(event) {
			event.preventDefault();

			$('#loaderModal').modal('show');
			var url = $(this).attr('href');
			var object_id = $(this).data('object-id');

			$.ajax({
				type: "POST",
				url: url,
				success: function(response) {
					$('#loaderModal').modal('hide');

					$('#modifyFormModal').find('.modal-body').html(response);
					$('#modifyFormModal').modal('show');

					$('#modifyFormModal').data('object-id', object_id);
				}
			});

			return false;
		});

		$('.mapObject').on('click', function(event) {
			event.preventDefault();

			$('#loaderModal').modal('show');
			var url = $(this).attr('href');

			$.ajax({
				type: "POST",
				url: url,
				success: function(response) {
					window.location.reload();
				}
			});
			
			return false;
		});

		$('.modal').keypress(function(event) {
			if(event.which == 13) {
				$(this).find('.btn.btn-primary').trigger('click');
			}
		});
	});
</script>
