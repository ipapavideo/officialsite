<?php defined('_VALID') or die('Restricted Access!'); ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/bootstrap-slider/css/bootstrap-slider.min.css">
<script src="<?php echo REL_URL; ?>/misc/select2/js/select2.full.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/bootstrap-slider/js/bootstrap-slider.min.js"></script>
<script>
$(document).ready(function() {
  $('#age-range').slider({tooltip: 'always'}).on('change', function(event) {
    $('#age-min').html(event.value.newValue[0]);
    $('#age-max').html(event.value.newValue[1]);
    $('#age').val(event.value.newValue[0] + '-' + event.value.newValue[1]);
  });

  $("#user-filters").on('click', function(e) {
    e.preventDefault();

    if ($('#user-filters-container').hasClass('d-block')) {
      $('#user-filters-container').removeClass('d-block').addClass('d-none');
      $(this).html('<?php echo __('more-filters'); ?> <i class="fa fa-plus"></i>');
    } else {
      $('#user-filters-container').removeClass('d-none').addClass('d-block');
      $(this).html('<?php echo __('less-filters'); ?> <i class="fa fa-minus"></i>');
    }
  });  
  
  if ($(window).width() < 768) {
    $(this).html('<?php echo __('more-filters'); ?> <i class="fa fa-plus"></i>');
    $(".user-filters-container").slideUp();
  }
  
  $("#search-users").on('click', function() {
    var values = {};
    var fields = $('#user-search-form').serializeArray();
    jQuery.each( fields, function( i, field ) {
      if (field.value != 'all' && field.value != '' && field.name != 'age-range') {
        if (field.name == 'age' && field.value == '18-99') {
      		
        } else {
      		values[field.name] = field.value;
        }
      }
    });
	
	if (jQuery.isEmptyObject(values)) {
	  window.location = $("#user-search-form").attr('action');
	} else {
	  window.location = $("#user-search-form").attr('action') + '?' + $.param(values);
	}	
  });  
});
</script>
