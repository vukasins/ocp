<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title></title>
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width" />

        <link rel="stylesheet" href="css/normalize.min.css" />
        <link rel="stylesheet" href="css/main.css" />
        <link rel="stylesheet" href="css/login.css" />
        
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:light&v1' rel='stylesheet' type='text/css'>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="//code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
        
        <script src="jscript/main.js"></script>
        <script src="jscript/login.js"></script>
        
        <?php if(isset($_GET['edit'])): ?>
        <script>
        	$(document).ready(function() {
        		$('.data-region').sortable({
    				iframeFix: true,
    		        forceHelperSize: true,
    		        connectWith: '.data-region',
    		        stop: function( event, ui ) {
        		        window.parent.updateWidgetOrder();
        		    }
    		    });

        		$('.data-region').disableSelection();
            });
        </script>
        <?php endif; ?>
        
    </head>
    <body>
        <div class="left data-region" data-region-name="home_left"><?php Page_Libraries_Widget::render('home_left'); ?></div>
    	<div class="center data-region" data-region-name="home_center"><?php Page_Libraries_Widget::render('home_center'); ?></div>
    	<div class="right data-region" data-region-name="home_right"><?php Page_Libraries_Widget::render('home_right'); ?></div>
    </body>
</html>
