<div class="form-group">
	<label>Root directory</label>
	<input class="form-control" type="text" name="control-properties-root[<?=$field->id?>]" value="<?=(isset($properties->root) ? $properties->root : '')?>" />
</div>

<div class="form-group">
    <label>File type</label>
	<div class="ocp-select">
		<select class="form-control" name="control-properties-type[<?=$field->id?>]">
			<option value="1" <?=(isset($properties->type) && $properties->type == 1 ? 'selected="selected"' : '')?>>Images</option>
			<option value="2" <?=(isset($properties->type) && $properties->type == 2 ? 'selected="selected"' : '')?>>Any file</option>
			<option value="3" <?=(isset($properties->type) && $properties->type == 3 ? 'selected="selected"' : '')?>>Videos</option>
		</select>
	</div>
</div>