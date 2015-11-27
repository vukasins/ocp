<div class="date-search">
	<div class="date-control date-search-left">
		<i class="fa fa-calendar-o"></i>
		<input type="text" id="<?=$field->field_name?>_from" class="form-control" name="<?=$field->field_name?>_from" value="<?=(isset($_POST[$field->field_name . '_from']) ? $_POST[$field->field_name . '_from'] : '')?>" tabindex="<?=$index?>" />
	</div>
	<div class="separator">-</div>
	<div class="date-control date-search-right">
		<i class="fa fa-calendar-o"></i>
		<input type="text" id="<?=$field->field_name?>_to" class="form-control" name="<?=$field->field_name?>_to" value="<?=(isset($_POST[$field->field_name . '_to']) ? $_POST[$field->field_name . '_to'] : '')?>" tabindex="<?=$index?>" />
	</div>
</div>

<script type="text/javascript" language="javascript">
    $(function() {      
        $("#<?=$field->field_name?>_from").datepicker({dateFormat: 'yy-mm-dd'});
        //$("#<?=$field->field_name?>_from").datepicker("setDate", '<?=$value?>');

        $("#<?=$field->field_name?>_to").datepicker({dateFormat: 'yy-mm-dd'});
        //$("#<?=$field->field_name?>_to").datepicker("setDate", '<?=$value?>');
    });
</script>

<input type="hidden" name="search_field_query_<?=$field->field_name?>" value="(if(:<?=$field->field_name?>_from != '', <?=$field->field_name?> >= :<?=$field->field_name?>_from, '1=1')) AND (if(:<?=$field->field_name?>_to != '', <?=$field->field_name?> <= :<?=$field->field_name?>_to, '1=1'))" />