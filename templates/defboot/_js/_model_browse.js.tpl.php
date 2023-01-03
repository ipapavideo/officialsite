<?php defined('_VALID') or die('Restricted Access!'); ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/bootstrap-slider/css/bootstrap-slider.min.css">
<script src="<?php echo REL_URL; ?>/misc/bootstrap-slider/js/bootstrap-slider.min.js"></script>
<script>
$(document).ready(function() {
  $("#model-filters").on('click', function(e) {
	e.preventDefault();
	if ($(".model-filters-container").is(':visible')) {
	  $(this).html('<?php echo __('more-filters'); ?> <i class="fa fa-plus"></i>');
	  $(".model-filters-container").slideUp();
	} else {
	  $(this).html('<?php echo __('less-filters'); ?> <i class="fa fa-minus"></i>');
	  $(".model-filters-container").slideDown();
	}
  });

 $("#age-range").slider().on('change', function(event) {
    var oldrange = event.value.oldValue[0] + '-' + event.value.oldValue[1];
    var newrange = event.value.newValue[0] + '-' + event.value.newValue[1];
    if (oldrange != newrange) {
      var url = $("#age-url").attr('href').replace('RANGE', newrange);
      setTimeout(function() {window.location = url;}, 2000);
    }
  });  
});
</script>
