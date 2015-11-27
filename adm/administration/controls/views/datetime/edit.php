<div class="date-time-control">
	<i class="fa fa-calendar-o"></i>
	<i class="fa fa-clock-o"></i>
	<input type="text" id="<?=$field->field_name?>" class="form-control" name="<?=$field->field_name?>" value="<?=$value?>" tabindex="<?=$index?>" data-date="<?=$value?>" />
</div>

<script type="text/javascript" language="javascript">
    $(function () {
                $('#<?=$field->field_name?>').datetimepicker({
                    dateFormat: 'yy-mm-dd',
                    timeFormat: 'HH:mm:ss',
                    sideBySide: true,
                    defaultDate: '<?=$value?>'
                });
            });
</script>