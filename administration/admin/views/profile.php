<section class="content-header">
	<h1 class="page-header">Your profile</h1>
</section>

<?php if($saved_status != ''): ?>
	<div class="form-group">
		<div class="alert alert-success alert-dismissable">
			<i class="fa fa-check"></i>
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<b><?=__('Success!')?></b> <?=$saved_status?>
		</div>
	</div>
<?php endif; ?>
	
<div class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<form action="" method="post" class="frm-save">
					<div class="form-group">
						<label for="email">Email <span class="description"></span></label>
						<input type="text" tabindex="1" value="<?=$user->email?>" name="email" class="form-control" id="email" />
					</div>

					<div class="divider"></div>
					
					<div class="form-group">
						<label for="password">Password <span class="description">Fill to change</span></label>
						<input type="password" tabindex="3" value="" name="password" class="form-control" id="password" />
					</div>
					
					<div class="form-group">
						<label for="repeat_password">Repeat password <span class="description"></span></label>
						<input type="repeat_password" tabindex="3" value="" name="repeat_password" class="form-control" id="repeat_password" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<a class="btn btn-primary create-new" href="#"><i class="fa fa-save"></i> Save</a>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.create-new').click(function(e) {
			e.preventDefault();

			$(this).parents('.container-fluid').find('.frm-save').submit();

			return false;
		});
	});
</script>