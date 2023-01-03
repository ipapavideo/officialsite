<?php defined('_VALID') or die('Restricted Access!'); ?>
<script>
$(document).ready(function() {
  $(".stream-content-model").slimScroll({height: $(".stream-content-model:first").height() + 'px', color: '#ff9900'});
  $(".stream-content-video").slimScroll({height: $(".stream-content-video:first").height() + 'px', color: '#ff9900'});  
  $(".stream-content-profile").slimScroll({height: $(".stream-content-profile:first").height() + 'px', color: '#ff9900'});
});
</script>