<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OCP3 Administration</title>

    <link href="<?=SITE_ROOT_URI?>/layout/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=SITE_ROOT_URI?>/layout/admin/css/ocp-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=SITE_ROOT_URI?>/layout/admin/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic|Roboto+Condensed&subset=latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700&subset=latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
    
    <link href="//code.jquery.com/ui/1.11.2/themes/black-tie/jquery-ui.css" rel="stylesheet">
    <link href="<?=SITE_ROOT_URI?>/layout/admin/css/template.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
    <!-- jQuery Version 1.11.0 -->
    <script src="<?=SITE_ROOT_URI?>/layout/admin/js/jquery-1.11.0.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
    <script src="<?=SITE_ROOT_URI?>/layout/admin/js/jquery.datetimepicker.js"></script>
    <script src="<?=SITE_ROOT_URI?>/layout/admin/js/jquery.cookie.js"></script>
    
    <!-- CKEDITOR -->
    <script src="<?=SITE_ROOT_URI?>/layout/admin/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?=SITE_ROOT_URI?>/layout/admin/js/bootstrap.min.js"></script>

</head>
<body>
	<div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">
					<span class="ocp-logo">OCP3</span>
					<span class="site-url">Omnicom Content Platform <em>(www.ocp3.com)</em></span>
				</a>
            </div>
            
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                
            </div>
            <!-- /.navbar-collapse -->
        </nav>
        
        <script>
        $(document).ready(function() {
            /*
            var last = $.cookie('activeNavigationGroup');
            if (last!=null) 
            {
                $('#' + last).prev('a[data-toggle=collapse]').trigger('click');
            }
            */

            var opened = $.cookie('activeNavigationGroup');
            if(opened != null)
            {
                opened = opened.split(',');
                for(i = 0; i < opened.length; i++)
                {
                	$('#' + opened[i]).prev('a[data-toggle=collapse]').trigger('click');
                }
            }
            
            $('.side-nav a[data-toggle=collapse]').bind('click', function() {
                var id = $(this).next('.collapse').attr('id');
                var opened = $.cookie('activeNavigationGroup');

                if(!$(this).next('.collapse').hasClass('in'))
                {
                	opened = opened + ',' + id;
                	$.cookie('activeNavigationGroup', opened);
                }
                else
                {
                    opened = ',' + opened + ',';
                    opened = opened.replace(',' + id + ',', '');
                    
                	$.cookie('activeNavigationGroup', opened);
                }
            });
        });
        </script>

        <div id="page-wrapper">

            <div class="container-fluid">
            
            	<?=Libraries_Layout::getInstance()->renderRegion('content');?>
            	
            	<div class="modal fade" id="loaderModal" style="position: absolute; z-index: 10000" data-backdrop="false">
					<div class="modal-dialog">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<h4 class="modal-title">In progress</h4>
				      		</div>
				      		
				      		<div class="modal-body">
								<div class="progress">
									<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
										<span class="sr-only">100% Complete</span>
									</div>
								</div>
				      		</div>
				    	</div><!-- /.modal-content -->
				  	</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
				
				<div class="modal fade" id="deleteModal" style="position: absolute; z-index: 10000" data-backdrop="false">
					<div class="modal-dialog">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				        		<h4 class="modal-title">Delete</h4>
				      		</div>
				      		
				      		<div class="modal-body">
				        		<p><?=__('Are you sure that you want to delete this?')?></p>
				      		</div>
				      		
				      		<div class="modal-footer">
				      			<button type="button" class="btn btn-primary">Yes</button>
				        		<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				      		</div>
				    	</div><!-- /.modal-content -->
				  	</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
				
				<div class="modal fade" id="restoreModal" style="position: absolute; z-index: 10000" data-backdrop="false">
					<div class="modal-dialog">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				        		<h4 class="modal-title">Restore</h4>
				      		</div>
				      		
				      		<div class="modal-body">
				        		<p><?=__('Are you sure that you want to restore this?')?></p>
				      		</div>
				      		
				      		<div class="modal-footer">
				      			<button type="button" class="btn btn-primary">Yes</button>
				        		<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				      		</div>
				    	</div><!-- /.modal-content -->
				  	</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
</body>

</html>
