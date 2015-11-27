<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OCP3 Administration</title>

    <link href="http://www.demo.omnicom.local/layout/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://www.demo.omnicom.local/layout/admin/css/ocp-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="http://www.demo.omnicom.local/layout/admin/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic|Roboto+Condensed&subset=latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700&subset=latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
    
    <link href="//code.jquery.com/ui/1.10.3/themes/black-tie/jquery-ui.css" rel="stylesheet">
    <link href="http://www.demo.omnicom.local/layout/admin/css/template.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
    <!-- jQuery Version 1.11.0 -->
    <script src="http://www.demo.omnicom.local/layout/admin/js/jquery-1.11.0.js"></script>
    <script src="//code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
    <script src="http://www.demo.omnicom.local/layout/admin/js/jquery.datetimepicker.js"></script>
    <script src="http://www.demo.omnicom.local/layout/admin/js/jquery.cookie.js"></script>
    
    <!-- CKEDITOR -->
    <script src="http://www.demo.omnicom.local/layout/admin/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="http://www.demo.omnicom.local/layout/admin/js/bootstrap.min.js"></script>
    
    <style>
    	iframe {
		    width: 100%;
		}
		
    </style>


	<script>
	$(document).ready(function() {
		var active_widget = null;
		
		$('iframe').load(function() {
			$('iframe').contents().find('.widget').append(' <a href="#" class="edit">edit</a>');
			//$('iframe').contents().find('.widget').append(' <a href="#" class="handle">move</a>');

			$('iframe').contents().find('.widget .edit').unbind('click');
			$('iframe').contents().find('.widget .edit').click(loadModelData);

			$('iframe').height($('iframe').contents().height());
		});

		var loadModelData = function(e) {
			e.preventDefault();

			active_widget = $(this).parents('.widget');
			
			var id_sys_object = $(this).parents('.widget').data('widget-object-id');
			var id_row = $(this).parents('.widget').data('widget-row-id');
			var url = 'http://www.demo.omnicom.local/crud/modify/' + id_sys_object + '/' + id_row;

			var modal = $('.modalInnerFormEdit:first').clone();
			
			$(modal).attr('data-url', url);

			$('#loaderModal').modal('show');

			if($(this).parents('.subform').length)
			{
				var subform = $(this).parents('.subform');
				var sys_object_id = $(subform).data('sys-object-id');
				var subform_relation_id = $(subform).data('subform-relation-id');
				var subform_relation_value = $(subform).data('subform-relation-value');
				
				url = url + '/' + subform_relation_id + '/' + subform_relation_value;
			}

			$.ajax({
				type: "POST",
				url: url,
				success: function(response) {
					$('#loaderModal').modal('hide');

					$(modal).find('.modal-body').html(response);

					$(modal).modal({
						backdrop: 'static',
					    keyboard: false
					});

					$(modal).find(':input:first').focus();
					
					if(!$(this).hasClass('create-new'))
					{
						$(modal).find('.subform').each(function() {
						//	loadSubformData($(this));
						});
					}
				}
			});

			return false;
		};

		var closeModal = function() {
			$('.modalInnerFormEdit').on('hidden.bs.modal', function (e) {
				$(this).remove();
			});
			
			$(this).parents('.modalInnerFormEdit').modal('hide');
			if($('.modal.in').length)
			{
				$('body').addClass('modal-open'); // height fix
			}
		};

		var saveModalData = function(event)
		{
			event.preventDefault();

			$('.form-group.has-error').removeClass('has-error');
			$('.form-group label.error').remove();

			for(editor in CKEDITOR.instances)
			{
				$('textarea#' + editor).val(CKEDITOR.instances[editor].getData());
			}
						
			var modal = $(this).parents('.modalInnerFormEdit');			
			var url = $(this).parents('.modalInnerFormEdit').find('form').attr('action');
			var data = $(this).parents('.modalInnerFormEdit').find('form').serialize();

			$('#loaderModal').modal('show');

			$.ajax({
				type: "POST",
				url: url,
				data: data,
				dataType: 'json',
				success: function(response)
				{			
					$('#loaderModal').modal('hide');
					
					if(response.errors != '')
					{
						for(i = 0; i < response.errors.length; i++)
						{
							var field = response.errors[i].field;
							var message = response.errors[i].message;

							$('#' + field).parents('.form-group').addClass('has-error');
							$('#' + field).parents('.form-group').append('<label class="error">' + message + '</label>');
						}

						if(response.errors.general)
						{
							alert(response.errors.general);
						}

						$('body').addClass('modal-open'); // height fix
					}
					else
					{
						if(response.id)
						{
							$.ajax({
								type: "POST",
								url: '/page/widget/updateWidgetInstance/',
								data: {id_widget_instance: $(active_widget).data('widget-instance-id'), id_row: response.id},
								success: function(response)
								{
									document.location.reload();
									active_widget = null;
								}
							});
						}
						else
						{
							document.location.reload();
							active_widget = null;
						}						
					}
				}
			});
			
			return false;
		};

		$('.add-new-widget').click(function(e) {
			e.preventDefault();

			var modal = $('.modalInnerFormEdit:first').clone();
			
			$('#loaderModal').modal('show');

			$.ajax({
				type: "POST",
				url: '/page/widget/loadAvailableWidgets',
				success: function(response) {
					$('#loaderModal').modal('hide');

					$(modal).find('.modal-body').html(response);

					$(modal).modal({
						backdrop: 'static',
					    keyboard: false
					});
				}
			});
			
			return false;
		});

		var saveNewWidget = function(e) 
		{
			e.preventDefault();

			var id_widget= $(this).data('widget-id');

			$.ajax({
				type: "POST",
				url: '/page/widget/saveNewWidgetInstance',
				data: {id_page: 1, id_widget: id_widget},
				success: function(response) {
					document.location.reload();
				}
			});
			
			return false;
		};
		

		$(document).on('click', '.close, .exit', closeModal);
		$(document).on('click', '.save', saveModalData);
		$(document).on('click', '.new-widget', saveNewWidget);
	});

	var updateWidgetOrder = function()
	{
		var list = new Array();
		$('iframe').contents().find('.data-region').each(function() {
			var region = $(this).data('region-name');

			$(this).find('.widget').each(function() {
				var id_widget_instance = $(this).data('widget-instance-id');
				var index = $(this).parents('.data-region').find('.widget').index($(this));
				var item = {'region': region, 'id_widget_instance': id_widget_instance, 'index': index};
				
				list.push(item);
			});
		});

		$.ajax({
			type: "POST",
			url: '/page/widget/updateWidgetInstanceOrder/',
			data: {widget_instances: list},
			success: function(response)
			{
				//document.location.reload();
			}
		});
	};
	</script>
</head>
<body>
	
</body>
	<div class="site-manager-header">
		<a href="#" class="add-new-widget">Add new widget</a>
	</div>
	
	<iframe frameborder="0" id="my-frame" src="/page.1.html?edit=1"></iframe>
	
	<div class="modal fade modalInnerFormEdit">
		<div class="modal-dialog modal-lg">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        		<h4 class="modal-title">Modal form</h4>
	      		</div>
	      		
	      		<div class="modal-body"></div>
	      		
	      		<div class="modal-footer">
	      			<button type="button" class="btn btn-primary save">Save</button>
	        		<button type="button" class="btn btn-default exit">Close</button>
	      		</div>
	    	</div><!-- /.modal-content -->
	  	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</html>
