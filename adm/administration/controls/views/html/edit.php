<textarea id="<?=$field->field_name?>" name="<?=$field->field_name?>" rows="10" cols="80" tabindex="<?=$index?>"><?=$value?></textarea>  
<script type="text/javascript">
$(function() {CKEDITOR.replace('<?=$field->field_name?>');});
</script>