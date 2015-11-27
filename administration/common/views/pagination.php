<div class="dataTables_paginate paging_bootstrap">
	<ul class="pagination">
		<li class="prev <?=($current_page <= 1 ? 'disabled' : '')?>"><a href="<?=$url . '/' . (1) . $get_results?>">← <?=__('Fist')?></a></li>
		<li class="prev <?=($current_page <= 1 ? 'disabled' : '')?>"><a href="<?=$url . '/' . ($current_page <= 1 ? $current_page : ($current_page - 1)) . $get_results?>">← <?=__('Previous')?></a></li>
			<?php for($i = $pagination_start; $i <= $number_of_pages; $i++): ?>
				<li class="<?=($i == $current_page ? 'active' : '')?>"><a href="<?=$url . '/' . $i . $get_results?>"><?=$i?></a></li>
			<?php endfor; ?>
		<li class="next <?=($current_page >= $max_number_of_pages ? 'disabled' : '')?>"><a href="<?=$url . '/' . ($current_page + 1 >= $number_of_pages ? $number_of_pages : ($current_page + 1)) . $get_results?>"><?=__('Next')?> → </a></li>
		<li class="next <?=($current_page >= $max_number_of_pages ? 'disabled' : '')?>"><a href="<?=$url . '/' . ($max_number_of_pages) . $get_results?>"><?=__('Last')?> → </a></li>
	</ul>
</div>