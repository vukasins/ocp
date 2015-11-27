<?php if(!$is_ajax_call): ?>
	<section class="content-header">
	    <h1 class="page-header">
	    	<?=$sys_object->table_title?>
		</h1>
	</section>
<?php endif; ?>

<div class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<p>
					<a href="<?=SITE_ROOT_URI . '/crud/modify/' . $sys_object->id . '/0'?>" class="btn btn-primary create-new"><i class="fa fa-plus"></i> <?=__('Create new')?></a>
					<?php if(!$is_ajax_call): ?>
						<a class="btn btn-info search" href="#"><i class="fa fa-search"></i> <?=__('Search')?></a>
						
						<?php if(Admin_Libraries_Admin::getLogedUser()->loadRole()->role->safe_title == 'administrator'): ?>
							<a class="btn <?=(isset($_SESSION['trash']) && $_SESSION['trash'] == 1) ? 'btn-success' : 'btn-default'?> trash" href="<?=SITE_ROOT_URI . '/crud/trash/'?>"><i class="fa fa-trash-o"></i> <?=__('Trash')?>: <?=(isset($_SESSION['trash']) && $_SESSION['trash'] == 1) ? __('on') : __('off')?></a>
						<?php endif; ?>
					<?php endif; ?>
				</p>
			</div>
		</div>
	</div>
</div>

<?php if(isset($_POST) && !empty($_POST)):?>
	<form method="post" action="" class="search-frm">
		<?php foreach($_POST as $key => $value): ?>
			<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
		<?php endforeach; ?>
	</form>
	
	<?php
		$search_text = ''; 
		foreach($search_data as $search_key => $search_value) 
		{
			if(empty($search_value))
			{
				continue;
			}
			
			$search_text .= '<div class="param">'. $search_key . ' <i class="fa fa-angle-right"></i> <span>' . $search_value . '</span></div>';
		}
		
		echo '<div class="search_params"><h4>Search parameters</h4>'. rtrim($search_text, ', ') . '</div>';
	?>
<?php endif; ?>

<?php if(count($generic_model_data) > 0): ?>
	<div class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-body">
						<div role="grid" class="dataTables_wrapper form-inline">
							<div class="table-responsive">
								<table class="table table-striped dataTable table-hover" aria-describedby="example1_info">
									<thead>
							        	<tr>
							          		<?php foreach ($sys_object->sys_field_list as $field): ?>
							            		<?php if($field->is_identification == 1): ?>
                                                    <?php 
                                                        $sort_class = 'ocp-th-sort-none';
                                                        if(isset($_GET['ord_field']) && $_GET['ord_field'] == $field->field_name)
                                                        {
                                                        	$sort_class = 'ocp-th-sort-asc';
                                                        	
                                                        	if(isset($_GET['ord_direction']) && $_GET['ord_direction'] == 'desc')
                                                        	{
                                                        		$sort_class = 'ocp-th-sort-desc';
                                                        	}
                                                        }
                                                    ?>
							            			<th>	
							            				<a href="?ord_field=<?=$field->field_name?>&ord_direction=<?=(isset($_GET['ord_direction']) && $_GET['ord_direction'] == 'asc' ? 'desc' : 'asc')?>" class="<?=$sort_class?>"><?=$field->field_title;?></a>
							            			</th>
							            		<?php endif; ?>
							            	<?php endforeach; ?>
											<th style="width: 130px;"><i class="fa fa-cogs"></i> <?=__('Actions')?></th>
							        	</tr>
									</thead>
									
									<tfoot>
							        	<tr>
							          		<?php foreach ($sys_object->sys_field_list as $field): ?>
							            		<?php if($field->is_identification == 1): ?>
							            		    <?php 
							            		       $sort_class = 'ocp-th-sort-none';
                                                        if(isset($_GET['ord_field']) && $_GET['ord_field'] == $field->field_name)
                                                        {
                                                            $sort_class = 'ocp-th-sort-asc';
                                                            
                                                            if(isset($_GET['ord_direction']) && $_GET['ord_direction'] == 'desc')
                                                            {
                                                                $sort_class = 'ocp-th-sort-desc';
                                                            }
                                                        }
							            		    ?>
							            			<th>	
							            				<a href="?ord_field=<?=$field->field_name?>&ord_direction=<?=(isset($_GET['ord_direction']) && $_GET['ord_direction'] == 'asc' ? 'desc' : 'asc')?>" class="<?=$sort_class?>"><?=$field->field_title;?></a>
							            			</th>
							            		<?php endif; ?>
							            	<?php endforeach; ?>
											<th style="width: 190px;"><i class="fa fa-cogs"></i> <?=__('Actions')?></th>
							        	</tr>
									</tfoot>
									
									<tbody role="alert" aria-live="polite" aria-relevant="all">
									    <?php $field_index = 0;?>
										<?php foreach ($generic_model_data as $row): ?>
							        		<tr>
							        			<?php foreach ($sys_object->sys_field_list as $field): ?>
							            			<?php
							            				if(array_key_exists($field->field_name, $row->data))
							            				{
															$value =  $row->data[$field->field_name];
							            				}
							            				else
							            				{
							            					$value = __('Undefined');
							            				}
							            			?>
							            			<?php if($field->is_identification == 1): ?>
	                                                    <?php if($field->id_sys_control > 0): ?>
	                                                        <td>
	                                                        	<?php $field->loadControl();?>
								                                <?=Controls_Libraries_Control::render($field->control, $sys_object, $field, $row, $field_index++, Controls_Libraries_Control::CONTROL_TYPE_LIST);?>
								                            </td>
							                            <?php else: ?>
								            				<td>
								            					<?=$value?>
								            				</td>
							            				<?php endif; ?>
							            			<?php endif; ?>
							            		<?php endforeach; ?>
							            		
							            		<td>
							            			<?php if(!isset($_SESSION['trash']) || $_SESSION['trash'] == 0): ?>
							            				<?php if($user->role->canExecuteAction('can_edit_' . $sys_object->table_name)): ?>
															<a class="btn btn-primary btn-xs edit" href="<?=SITE_ROOT_URI?>/crud/modify/<?=$sys_object->id?>/<?=$row->id?>"><i class="fa fa-pencil"></i> <?=__('Edit')?></a>
															<a class="btn btn-info btn-xs edit clone" href="<?=SITE_ROOT_URI?>/crud/modify/<?=$sys_object->id?>/<?=$row->id?>?clone=1"><i class="fa fa-copy "></i> <?=__('Clone')?></a>
														<?php endif; ?>
														
														<?php if($user->role->canExecuteAction('can_delete_' . $sys_object->table_name)): ?>
								                      		<a data-toggle="modal" role="button" class="btn btn-danger btn-xs delete" href="#deleteModal" data-url="<?=SITE_ROOT_URI?>/crud/delete/<?=$sys_object->id?>/<?=$row->id?>"><i class="fa fa-times"></i> <?=__('Delete')?></a>
								                      	<?php endif; ?>
							                      	<?php else: ?>
							                      		<a data-toggle="modal" role="button" class="btn btn-success btn-xs" href="#restoreModal" data-url="<?=SITE_ROOT_URI?>/crud/restore/<?=$sys_object->id?>/<?=$row->id?>"><i class="fa fa-refresh"></i> <?=__('Restore')?></a>
							                      	<?php endif; ?>
							                  	</td>
							        		</tr>
							        	<?php endforeach; ?>
									</tbody>
								</table>
							</div>
							
							<div class="row">
								<div class="col-xs-12">
									<?=Common_Libraries_Pagination::render($generic_model_data_count, Config_Environment::DEFAULT_ITEMS_PER_PAGE, $current_page, SITE_ROOT_URI . '/crud/content/' . $sys_object->id);?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if(!$is_ajax_call): ?>
<div class="modal fade modalInnerFormEdit">
	<div class="modal-dialog modal-lg">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only"><?=__('Close')?></span></button>
        		<h4 class="modal-title"><?=__('Modify form')?></h4>
      		</div>
      		
      		<div class="modal-body">
      		</div>
      		
      		<div class="modal-footer">
      			<button type="button" class="btn btn-primary save"><?=__('Save')?></button>
        		<button type="button" class="btn btn-default exit"><?=__('Close')?></button>
      		</div>
    	</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	$(document).ready(function() {
		var loadModalData = function(event)
		{
			event.preventDefault();

			var url = $(this).attr('href');

			var modal = $('.modalInnerFormEdit:first').clone();

			$(modal).modal({
				backdrop: 'static',
			    keyboard: false
			});
			$(modal).attr('data-url', url);

			if($(this).parents('.subform').length)
			{
				var subform = $(this).parents('.subform');
				var sys_object_id = $(subform).data('sys-object-id');
				var subform_relation_id = $(subform).data('subform-relation-id');
				var subform_relation_value = $(subform).data('subform-relation-value');
				
				url = url + '/' + subform_relation_id + '/' + subform_relation_value;
			}
			
			$.ajax({
				type: "POST",
				url: url,
				success: function(response) {
					$('#loaderModal').modal('hide');

					$(modal).find('.modal-body').html(response);
					$(modal).modal({
						backdrop: 'static',
					    keyboard: false
					});
					//$(modal).modal('show');

					$(modal).find(':input:first').focus();
					
					if(!$(this).hasClass('create-new'))
					{
						$(modal).find('.subform').each(function() {
							loadSubformData($(this));
						});
					}
				}
			});

			return false;
		};

		var loadSubformData = function(subform)
		{
			var sys_object_id = $(subform).data('sys-object-id');
			var subform_relation_id = $(subform).data('subform-relation-id');
			var subform_relation_value = $(subform).data('subform-relation-value');
			var url = '<?=SITE_ROOT_URI?>/crud/content/' + sys_object_id + '/1/1/' + subform_relation_id + '/' + subform_relation_value;

			$.ajax({
				type: "POST",
				url: url,
				data: {},
				dataType: 'html',
				success: function(response)
				{
					$(subform).html(response);
				}
			});
		};

		var closeModal = function() {
			$('.modalInnerFormEdit').on('hidden.bs.modal', function (e) {
				$(this).remove();
			});
			
			$(this).parents('.modalInnerFormEdit').modal('hide');
			if($('.modal.in').length)
			{
				$('body').addClass('modal-open'); // height fix
			}
		};

		var saveModalData = function(event)
		{
			event.preventDefault();

			$('.form-group.has-error').removeClass('has-error');
			$('.form-group label.error').remove();

			for(editor in CKEDITOR.instances)
			{
				$('textarea#' + editor).val(CKEDITOR.instances[editor].getData());
			}
						
			var modal = $(this).parents('.modalInnerFormEdit');			
			var url = $(this).parents('.modalInnerFormEdit').find('form').attr('action');
			var data = $(this).parents('.modalInnerFormEdit').find('form').serialize();

			$('#loaderModal').modal('show');

			$.ajax({
				type: "POST",
				url: url,
				data: data,
				dataType: 'json',
				success: function(response)
				{			
					$('#loaderModal').modal('hide');
					
					if(response.errors != '')
					{
						for(i = 0; i < response.errors.length; i++)
						{
							var field = response.errors[i].field;
							var message = response.errors[i].message;

							$('#' + field).parents('.form-group').addClass('has-error');
							$('#' + field).parents('.form-group').append('<label class="error">' + message + '</label>');
						}

						if(response.errors.general)
						{
							alert(response.errors.general);
						}

						$('body').addClass('modal-open'); // height fix
					}
					else
					{
						$(modal).modal('hide');

						var parent_modal = $('.modalInnerFormEdit.in:last');

						if(!$(parent_modal).length)
						{
							document.location.reload();
							return false;
						}
						
						var url = $(parent_modal).data('url');
						
						$(parent_modal).find('.subform').each(function() {
							loadSubformData($(this));
						});
					}
				}
			});
			
			return false;
		};

		var paginate = function(event)
		{
			event.preventDefault();
			
			$('#loaderModal').modal('show');

			var url = $(this).attr('href');
			var subform = $(this).parents('.subform');

			url = url + '/1';

			$.ajax({
				type: "POST",
				url: url,
				data: {},
				dataType: 'html',
				success: function(response)
				{
					$(subform).html(response);
					$('#loaderModal').modal('hide');
				}
			});

			return false;
		};

		var loadSearchModal = function(event) {
			event.preventDefault();
			
			$('#loaderModal').modal('show');

			$.ajax({
				type: "POST",
				url: '<?=SITE_ROOT_URI?>/crud/search/<?=$sys_object->id?>',
				data: <?=json_encode($_POST)?>,
				dataType: 'html',
				success: function(response)
				{
					var modal = $('.modalInnerFormEdit:first').clone();

					$('#loaderModal').modal('hide');

					$(modal).find('.modal-title').html('<?=__('Search')?>');
					$(modal).find('.btn-primary.save').html('<?=__('Search')?>');

					var reset = $(modal).find('.btn-primary.save').clone();
					$(reset).html('<?=__('Reset')?>');
					$(reset).removeClass('save');
					$(reset).addClass('reset');
					$(modal).find('.btn-primary.save').after($(reset));
					
					$(reset).click(function(e) {
						e.preventDefault();
						
						$(this).parents('.modal-content').find(':input').val('');

						return false;
					});
					
					$(modal).find('.btn-primary.save').removeClass('save').addClass('do-search');
					$(modal).find('.modal-body').html(response);
					$(modal).modal('show');
				}
			});
		};

		var submitSearchForm = function(event) {
			event.preventDefault();
			
			$(this).parents('.modal').find('form').submit();

			return false;
		};

		$('#restoreModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var url = button.data('url');

			$('#restoreModal').find('.btn.btn-primary').data('url', url);
		});

		$('#restoreModal').on('hide.bs.modal', function (event) {
			$('#restoreModal').find('.btn.btn-primary').removeAttr('data-url');
		});

		$('#restoreModal .btn.btn-primary').on('click', function() {
			var url = $(this).data('url');

			$('#loaderModal').modal('show');
			$("#restoreModal").modal('hide');

			$.ajax({
				type: "POST",
				url: url,
				success: function(response) {
					document.location.reload();
				}
			});
		});

		$('#deleteModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var url = button.data('url');

			$('#deleteModal').find('.btn.btn-primary').data('url', url);
		});

		$('#deleteModal').on('hide.bs.modal', function (event) {
			$('#deleteModal').find('.btn.btn-primary').removeAttr('data-url');
		});

		$('#deleteModal .btn.btn-primary').on('click', function() {
			var url = $(this).data('url');

			$('#loaderModal').modal('show');
			$("#deleteModal").modal('hide');

			$.ajax({
				type: "POST",
				url: url,
				success: function(response) {
					var parent_modal = $('.modalInnerFormEdit.in:last');

					if(!$(parent_modal).length)
					{
						document.location.reload();
						return false;
					}
					
					var url = $(parent_modal).data('url');
					
					$(parent_modal).find('.subform').each(function() {
						loadSubformData($(this));
					});

					$('#loaderModal').modal('hide');
				}
			});
		});

		var clone = function(event)
		{
			event.preventDefault();

			var url = $(this).attr('href');

			$.ajax({
				type: "POST",
				url: url,
				success: function(response) {
					document.location.reload();
				}
			});

			return false;
		};

		$(document).on('click', '.create-new, .edit', loadModalData);
		$(document).on('click', '.close, .exit', closeModal);
		$(document).on('click', '.save', saveModalData);
		$(document).on('click', '.subform .pagination a', paginate);
		$(document).on('click', '.search', loadSearchModal);
		$(document).on('click', '.do-search', submitSearchForm);
		//$(document).on('click', '.clone', clone);

		<?php if(isset($_POST) && !empty($_POST)):?>
		var mainPagePaginate = function(event)
		{
			event.preventDefault();

			var url = $(this).attr('href');

			$('.search-frm').attr('action', url);
			$('.search-frm').submit();
			
			return false;
		};
		
		$(document).on('click', '#page-wrapper .pagination a', mainPagePaginate);
		<?php endif; ?>
		
		$(document).on('keypress', '.modal', function(event) {
			if(event.which == 13) {
				event.preventDefault();

				var button = $(this).find('.btn.btn-primary:last');

				if($(button).html() != '<?=__('Search')?>')
				{
					$(button).trigger();
				}

				return false;
			}
		});
	});
</script>
<?php endif; ?>