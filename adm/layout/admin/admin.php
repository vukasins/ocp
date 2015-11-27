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
            
            <?php
                $user = Admin_Libraries_Admin::getLogedUser();
				$user->loadRole(); 
            ?>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$user->username?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?=SITE_ROOT_URI . '/admin/profile/'?>"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        
                        <li class="divider"></li>
                        <li>
                            <a href="<?=SITE_ROOT_URI . '/admin/auth/logout/'?>"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                	<li class="treeview">
		                <a href="#"><i class="fa fa-folder"></i> <span>Objects</span><i class="fa fa-angle-left pull-right"></i></a>
                        
                        <?php 
                        	$sql = "SELECT id, group_name
                        			FROM sys_object
                        			WHERE 	is_deleted = 0 AND
                        					is_system = 0
                        			GROUP BY group_name
                        			ORDER BY group_name";
                        	$groups = Libraries_Db_Factory::getDb()->fetchAll($sql, array(), Libraries_Db_Adapter::FETCH_TYPE_CLASS);
                        ?>
                        
                        <?php foreach($groups as $group): ?>
                        	<ul class="treeview-menu">
								<li>
									<a data-target="#collapse-<?=$group->id?>" data-toggle="collapse" href="javascript:;"><i class="fa fa-folder"></i> <?=$group->group_name?> <i class="fa fa-fw fa-caret-down"></i></a>
									
									<?php 
										$where = array();
		                        		$order = array();
		                        		
		                        		$where[] = array('AND', 'is_system', '=', 0);
		                        		$where[] = array('AND', 'group_name', '=', $group->group_name);
		                        		
		                        		$order[] = array('group_name', 'ASC');
		                        		$order[] = array('table_title', 'ASC');
		                        	
		                        		$sys_object = new Crud_Models_Object();
		                        		$sys_objects = $sys_object->search($where, $order);
									?>
									<ul class="collapse" id="collapse-<?=$group->id?>">
										<?php foreach($sys_objects as $sys_object): ?>
											<?php 
												if(!$user->role->canExecuteAction('can_view_' . $sys_object->table_name))
												{
													continue;
												}
											?>
											<li>
												<a href="<?=SITE_ROOT_URI . '/crud/content/' . $sys_object->id?>">
						                        	<i class="fa"></i> <span><?=$sys_object->table_title?></span>
						                        </a>
											</li>
										<?php endforeach; ?>
									</ul>
								</li>
                        	</ul>
                        <?php endforeach; ?>
                    </li>
                    
                    <?php if($user->role->safe_title == 'administrator'): ?>
                    <li class="treeview">
		                <a href="#"><i class="fa fa-folder"></i> <span>Admin</span><i class="fa fa-angle-left pull-right"></i></a>
                        
						<ul class="treeview-menu">
							<li>
                        		<a href="<?=SITE_ROOT_URI . '/crud/objects/maplist/'?>"><i class="fa fa-folder"></i> <span>Map objects</span></a>
		                    </li>
                        	<li>
                        		<a data-target="#sysobjects" data-toggle="collapse" href="javascript:;"><i class="fa fa-folder"></i> System objects <i class="fa fa-fw fa-caret-down"></i></a>
                        		
								<ul class="collapse" id="sysobjects">
		                        	<?php 
		                        		$where = array();
		                        		$order = array();
		                        		
		                        		$where[] = array('AND', 'is_system', '=', 1);
		                        		
		                        		$order[] = array('group_name', 'ASC');
		                        		$order[] = array('table_title', 'ASC');
		                        	
		                        		$sys_object = new Crud_Models_Object();
		                        		$sys_objects = $sys_object->search($where, $order);
		                        	?>
		                        	<?php foreach($sys_objects as $sys_object): ?>
		                        		<li>
											<a href="<?=SITE_ROOT_URI . '/crud/content/' . $sys_object->id?>"><span><?=$sys_object->table_title?></span></a>
										</li>
		                        	<?php endforeach; ?>
		                        </ul>
                        	</li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    
                	<?php /* ?>
                	<?php 
                       	Admin_Libraries_Module_Actions::getInstance()->registerActionFiles();
						Admin_Libraries_Module_Actions::getInstance()->prepareActionFiles();
						
						$actions = Admin_Libraries_Module_Actions::getInstance()->getActions();
					?>
                    <?php foreach($actions as $group_name => $action_group): ?>
						<?php if(count($action_group) == 1): ?>
							<li>
								<a href="<?=SITE_ROOT_URI . $action_group[0]->action?>">
		                        	<i class="fa <?=$action_group[0]->class?>"></i> <span><?=$action_group[0]->title?></span>
		                        </a>
							</li>
						<?php else: ?>
							<li class="treeview">
		                    	<a href="#">
		                        	<i class="fa fa-folder"></i>
		                            <span><?=$group_name?></span>
		                            <i class="fa fa-angle-left pull-right"></i>
		                        </a>
		                        
								<ul class="treeview-menu">
		                        	<?php foreach($action_group as $action): ?>
		                            	<li>
											<a href="<?=SITE_ROOT_URI . $action->action?>">
					                        	<i class="fa fa-angle-double-right"></i> <span><?=$action->title?></span>
					                        </a>
										</li>
		                            <?php endforeach;?>
		                        </ul>
		                    </li>
						<?php endif; ?>
					<?php endforeach; ?>
					<?php */ ?>
                </ul>
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

            var window_height = $(window).height() - $('.collapse.navbar-collapse.navbar-ex1-collapse').height();
            $('.nav.navbar-nav.side-nav ').height(window_height + 'px');
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
