<?php defined('_VALID') or die('Restricted Access!'); ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/bootstrap-slider/css/bootstrap-slider.min.css">
<script src="<?php echo REL_URL; ?>/misc/bootstrap-slider/js/bootstrap-slider.min.js"></script>
<script>
$(document).ready(function() {
  $("#model-filters").on('click', function(e) {
	e.preventDefault();
	
	if ($('#model-filters-container').hasClass('d-block')) {
	  $('#model-filters-container').removeClass('d-block').addClass('d-none');
	  $(this).html('<?php echo __('more-filters'); ?> <i class="fa fa-plus"></i>');
	} else {
	  $('#model-filters-container').removeClass('d-none').addClass('d-block');
	  $(this).html('<?php echo __('less-filters'); ?> <i class="fa fa-minus"></i>');
	}
  });

 $('#age-range').slider({tooltip: 'always'}).on('change', function(event) {
	$('#age-min').html(event.value.newValue[0]);
	$('#age-max').html(event.value.newValue[1]);
	$('#age').val(event.value.newValue[0] + '-' + event.value.newValue[1]);
  });
  
  $('button#model-filter').on('click', function(e) {
	e.preventDefault();
	
	var url	= "<?php echo BASE_URL.LANG.'/search/model/?s='.$this->query; ?>";
	var fields = $('#model-filters-form').serializeArray();
	jQuery.each( fields, function( i, field ) {
	  if (field.value != 'all' && field.name != 'age-range') {
		if (field.name == 'age' && field.value == '18-99') {
			url	= url;
		} else {
			url = url + '&' + field.name + '=' + field.value;
		}
	  }
	});
	
	window.location = url;
  });

  $('button#model-reset').on('click', function(e) {
	e.preventDefault();
	window.location = "<?php echo build_search_url($this->query, $this->order, true); ?>";
  });
});
</script>
