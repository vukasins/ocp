<?php
    $subtype = isset($control_properties->subtype) ? $control_properties->subtype : null;
    $pattern = isset($control_properties->pattern) ? $control_properties->pattern : null;
    
    $type = empty($subtype) ? 'text' : $subtype;
?>
<input type="<?=$type?>" <?=(!empty($pattern) ? 'pattern="' . $pattern . '"' : '')?> id="<?=$field->field_name?>" class="form-control" name="<?=$field->field_name?>" value="<?=(isset($_POST[$field->field_name]) ? $_POST[$field->field_name] : '')?>" tabindex="<?=$index?>" />
<input type="hidden" name="search_field_query_<?=$field->field_name?>" value="(<?=$field->field_name?> LIKE :<?=$field->field_name?>)" />