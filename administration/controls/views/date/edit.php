<div class="date-control">
	<i class="fa fa-calendar-o"></i>
	<input type="text" id="<?=$field->field_name?>" class="form-control" name="<?=$field->field_name?>" value="<?=$value?>" tabindex="<?=$index?>" />
</div>

<script type="text/javascript" language="javascript">
    $(function() {      
        $("#<?=$field->field_name?>").datepicker({dateFormat: 'yy-mm-dd'});
        $("#<?=$field->field_name?>").datepicker("setDate", '<?=$value?>');
    });
</script>