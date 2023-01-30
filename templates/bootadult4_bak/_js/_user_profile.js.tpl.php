<?php defined('_VALID') or die('Restricted Access!'); ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/select2/css/select2.min.css">
<script src="<?php echo REL_URL; ?>/misc/select2/js/select2.full.min.js"></script>
<script>
$(document).ready(function() {
  $('.select2').select2({minimumResultsForSearch: -1});
  $('#country_id').select2({width:'100%'});		
});
</script>
