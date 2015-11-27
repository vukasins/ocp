<?php if(preg_match('/(\.jpg|\.png|\.gif)$/i', $value)): ?>
    <?php 
        $id = 'image-' . md5(microtime());
        $image_name = trim(str_replace(dirname($value), '', $value), '/');
    ?>
    <div id="<?=$id?>">
        <span><?=$image_name?></span>
        <div class="image-hover" style="display: none">
            <img src="<?=Libraries_Image::getThumbFromImage($value, '200x200')?>" />
            <?=$value?>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('#<?=$id?>').hover(
        	    function() {
        	    	$('#<?=$id?>').find('.image-hover').show();
            	},
        	    function() {
            	    $('#<?=$id?>').find('.image-hover').hide();
            	}
        )
    });
    </script>
<?php else: ?>
    <?=$value?>
<?php endif; ?>