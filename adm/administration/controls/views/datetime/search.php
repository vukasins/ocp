<div class="date-time-search">
	<div class="date-time-control date-time-search-left">
		<i class="fa fa-calendar-o"></i>
		<i class="fa fa-clock-o"></i>
		<input type="text" id="<?=$field->field_name?>_from" class="form-control" name="<?=$field->field_name?>_from" value="<?=(isset($_POST[$field->field_name . '_from']) ? $_POST[$field->field_name . '_from'] : '')?>" tabindex="<?=$index?>" />
	</div>
	<div class="separator">-</div>
	<div class="date-time-control date-time-search-right">
		<i class="fa fa-calendar-o"></i>
		<i class="fa fa-clock-o"></i>
		<input type="text" id="<?=$field->field_name?>_to" class="form-control" name="<?=$field->field_name?>_to" value="<?=(isset($_POST[$field->field_name . '_to']) ? $_POST[$field->field_name . '_to'] : '')?>" tabindex="<?=$index?>" />
	</div>
</div>

<script>
$(document).ready(function() {
    $('#<?=$field->field_name?>_from').datetimepicker({
    	dateFormat: 'yy-mm-dd',
    	timeFormat: 'HH:mm:00'
    });

    $('#<?=$field->field_name?>_to').datetimepicker({
    	dateFormat: 'yy-mm-dd',
    	timeFormat: 'HH:mm:00'
    });
});
</script>

<input type="hidden" name="search_field_query_<?=$field->field_name?>" value="(if(:<?=$field->field_name?>_from != '', <?=$field->field_name?> >= :<?=$field->field_name?>_from, '1=1')) AND (if(:<?=$field->field_name?>_to != '', <?=$field->field_name?> <= :<?=$field->field_name?>_to, '1=1'))" />