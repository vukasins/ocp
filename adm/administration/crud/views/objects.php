<section class="content-header">
    <h1 class="page-header">
    	Objects
        <small>(list of object)</small>
	</h1>
</section>

<div class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body table-responsive">
					<div role="grid" class="dataTables_wrapper form-inline">
						<table class="table table-striped dataTable table-hover" aria-describedby="example1_info">
							<thead>
					        	<tr>
					          		<th>#</th>
									<th>Group</th>
									<th>Object</th>
									<th style="width: 180px;"><i class="fa fa-cogs"></i> Actions</th>
					        	</tr>
							</thead>
							
							<tfoot>
					        	<tr>
					          		<th>#</th>
									<th>Group</th>
									<th>Object</th>
									<th style="width: 180px;"><i class="fa fa-cogs"></i> Actions</th>
					        	</tr>
							</tfoot>
							
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php foreach ($sys_object_list as $i => $sys_object):?>
									<tr class="<?=(($i + 1) % 2 == 0 ? 'event' : 'odd')?>">
										<td><?=$sys_object->id?></td>
										<td><?=$sys_object->group_name?></td>
										<td><?=$sys_object->table_title?></td>
										<td style="width: 180px;">
											<a href="<?=SITE_ROOT_URI?>/crud/content/<?=$sys_object->id?>"><i class="icon-pencil">Edit</i></a> 
					                  	</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>