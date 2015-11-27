<script>
	$(document).ready(function() {
		$('.order-btn').click(function(event) {
			event.preventDefault();

			$('#loaderModal').modal('show');

			var direction = $(this).hasClass('orderUp') ? 'up' : 'down';
			var object_id = $(this).parent().find('input').data('object-id');
			var field_id = $(this).parent().find('input').data('field-id');
			var row_id = $(this).parent().find('input').data('row-id');
			var url = '<?=SITE_ROOT_URI?>/controls/orderindex/reorder/'; 

			$.ajax({
				type: "POST",
				url: url,
				data: {direction: direction, object_id: object_id, field_id: field_id, row_id: row_id},
				success: function(response) {
					window.location.reload();
				}
			});
			
			return false;
		});

		$('.order-value').blur(function() {
			var object_id = $(this).parent().find('input').data('object-id');
			var field_id = $(this).parent().find('input').data('field-id');
			var row_id = $(this).parent().find('input').data('row-id');
			var value = $(this).val();

			$('#loaderModal').modal('show');
			
			$.ajax({
				method: "POST",
				url: '<?=SITE_ROOT_URI?>/controls/orderindex/reordermanual/',
				data: { object_id : object_id, field_id: field_id, row_id: row_id, value: value },
				dataType: 'json',
				success: function(response) {
					if(response.error)
					{
						$('#loaderModal').modal('hide');
						
						alert(response.error);
						window.location.reload();
					}
					else
					{
						window.location.reload();
					}
				}
			});
		});
	});
</script>