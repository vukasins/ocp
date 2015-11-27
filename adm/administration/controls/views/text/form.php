<div class="form-group">
	<label>Input subtype</label>
	<input class="form-control" type="text" name="control-properties-subtype[<?=$field->id?>]" value="<?=(isset($properties->subtype) ? $properties->subtype : '')?>" />
</div>

<div class="form-group">
    <label>Input pattern</label>
    <input class="form-control" type="text" name="control-properties-pattern[<?=$field->id?>]" value="<?=(isset($properties->pattern) ? $properties->pattern : '')?>" />
</div>