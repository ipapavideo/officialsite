<?php defined('_VALID') or die('Restricted Access!'); ?>
<script>
$(document).ready(function() {
  if ($('.categories-less').height() > 500) {
	$('.categories-less').after('<div class="container-content-lm w-100 mt-1 text-center"><button type="button" class="btn btn-xs btn-primary rounded-pill btn-view-more"><?php echo __('view-more'); ?></button></div>');
	
	$('.btn-view-more').on('click', function(e) {
	  $('.categories-less').removeClass('categories-less').addClass('categories-more');
	  $(this).remove();
	});
  }
});
</script>
