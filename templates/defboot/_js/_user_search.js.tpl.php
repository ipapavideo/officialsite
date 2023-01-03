<?php defined('_VALID') or die('Restricted Access!'); ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/bootstrap-slider/css/bootstrap-slider.min.css">
<script src="<?php echo REL_URL; ?>/misc/select2/js/select2.full.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/bootstrap-slider/js/bootstrap-slider.min.js"></script>
<script>
$(document).ready(function() {
  $("#age-range").slider().on('change', function(event) {
    var oldrange = event.value.oldValue[0] + '-' + event.value.oldValue[1];
    var newrange = event.value.newValue[0] + '-' + event.value.newValue[1];
    if (oldrange != newrange) {
  	  $("input[name='age']").val(newrange);
    }
  });

  $('.select2').select2({minimumResultsForSearch: -1});
  $('#country').select2({width:'100%'});

  $("#user-filters").on('click', function(e) {
    e.preventDefault();
    if ($(".user-filters-container").is(':visible')) {
      $(this).html('<?php echo __('more-filters'); ?> <i class="fa fa-plus"></i>');
      $(".user-filters-container").slideUp();
    } else {
      $(this).html('<?php echo __('less-filters'); ?> <i class="fa fa-minus"></i>');
      $(".user-filters-container").slideDown();
    }
  });
  
  if ($(window).width() < 768) {
    $(this).html('<?php echo __('more-filters'); ?> <i class="fa fa-plus"></i>');
    $(".user-filters-container").slideUp();
  }
  
  $("#search-users").on('click', function() {
	var values = {};
	$.each($('#user-search-form').serializeArray(), function(i, field) {
	  if (field.value != 'all' && field.value != '' && field.name != 'age-range') {	
  		values[field.name] = field.value;
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
