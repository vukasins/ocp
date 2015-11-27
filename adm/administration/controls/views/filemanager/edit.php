<?php
    $root = isset($control_properties->root) ? preg_replace('/^(\/|)upload\//', '', rtrim($control_properties->root, '/')) : '';
    $type = isset($control_properties->type) ? $control_properties->type : '2';
?>
<div class="file-manager">
	<div class="fm-image">
        <?php if($value != ''): ?>
            <div class="fm-preview"><img src="<?=Libraries_Image::getThumbFromImage($value, '78x78')?>" /></div>
		<?php endif; ?>
	</div>
	<div class="fm-file">
		<input type="text" id="<?=$field->field_name?>" name="<?=$field->field_name?>" class="form-control" tabindex="<?=$index?>" value="<?=$value?>" />
		<div class="fm-buttons">
			<a data-target="#filemanagerModal" href="javascript:void('')" class="btn btn-primary file-manager-button" data-toggle="modal"><i class="fa fa-folder-open"></i> Browse</a>
			<a href="<?=$value?>" target="_blank" class="btn btn-default"><i class="fa fa-eye"></i> Preview</a>
			<a href="#" class="btn btn-warning clear"><i class="fa fa-times"></i> Clear</a>
		</div>
	</div>
</div>

<script>
function responsive_filemanager_callback(field_id)
{
	var url = $('#'+field_id).val();
	var valid_url = '/upload/' + url;

	$('#'+field_id).val(valid_url);
	$('#'+field_id).parents('.file-manager').find('.fm-image').html('');
	$('#'+field_id).parents('.file-manager').find('.fm-image').append('<div class="fm-preview"><img width="78" height="78" src="' + valid_url + '" /></div>');

	var modal = $('.modalInnerFormEdit.in:last');
	$(modal).modal('hide');
  
	$('body').addClass('modal-open'); // height fix
	
	//your code
}

$(document).ready(function() {
	$('.file-manager-button').click(function(event) {
		event.preventDefault();

		var url = $(this).attr('href');

		var modal = $('.modalInnerFormEdit:first').clone();

		$(modal).modal('show');
		$(modal).find('.modal-body').html('<iframe width="100%" height="600" frameborder="0" src="<?=SITE_ROOT_URI?>/layout/admin/js/filemanager/dialog.php?type=<?=$type?>&relative_url=1&fldr=<?=$root?>&field_id=<?=$field->field_name?>"> </iframe>');
		$(modal).find('.modal-footer').remove();

		return false;
	});

	$('.clear').click(function(e) {
		e.preventDefault();

	    $(this).parents('.fm-file').find('input').val('');
	    $(this).parents('.file-manager').find('.fm-image').html('')
		
		return false;
	});
});
</script>