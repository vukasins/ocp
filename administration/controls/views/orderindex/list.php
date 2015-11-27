<a href="#" class="order-btn orderUp">Up</a>
<input type="text" class="order-value" value="<?=$value?>" size="3" style="text-align: center" data-object-id="<?=$object->id?>" data-field-id="<?=$field->id?>" data-row-id="<?=$row->id?>" />
<a href="#" class="order-btn orderDown">Down</a>

<?php Controls_Controllers_Orderindex::renderJs()?>