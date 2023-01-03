<?php defined('_VALID') or die('Restricted Access!'); ?>
<link href="<?php echo REL_URL; ?>/misc/jquery-guillotine/jquery.guillotine.css" media="all" rel="stylesheet">
<script src="<?php echo REL_URL; ?>/misc/jquery-guillotine/jquery.guillotine.min.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
  var picture = $('#avatar-crop');
  picture.on('load', function() {
	picture.guillotine({width: <?php echo $this->min_width; ?>, height: <?php echo $this->min_height; ?>});
    picture.guillotine('fit');
    $("button[id='zoom-in']").on('click', function() {picture.guillotine('zoomIn');});
    $("button[id='zoom-out']").on('click', function() {picture.guillotine('zoomOut');});
    $("button[id='fit']").on('click', function() {picture.guillotine('fit');});
    $("button[id='crop']").on('click', function() {
  	  var data = picture.guillotine('getData');
      $("input[name='scale']").val(data.scale);
      $("input[name='x']").val(data.x);
      $("input[name='y']").val(data.y);
      $("input[name='w']").val(data.w);
      $("input[name='h']").val(data.h);
      $("#avatar-crop-form").submit();
    });
  });
});
</script>
