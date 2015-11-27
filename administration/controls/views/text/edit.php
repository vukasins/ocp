<?php
    $subtype = isset($control_properties->subtype) ? $control_properties->subtype : null;
    $pattern = isset($control_properties->pattern) ? $control_properties->pattern : null;
    
    $type = empty($subtype) ? 'text' : $subtype;
?>
<input type="<?=$type?>" <?=(!empty($pattern) ? 'pattern="' . $pattern . '"' : '')?> id="<?=$field->field_name?>" class="form-control" name="<?=$field->field_name?>" value="<?=$value?>" tabindex="<?=$index?>" />