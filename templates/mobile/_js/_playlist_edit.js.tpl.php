<?php defined('_VALID') or die('Restricted Access!'); ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/jquery-tags-input/css/jquery.tagsinput.min.css">
<script src="<?php echo REL_URL; ?>/misc/jquery-tags-input/js/jquery.tagsinput.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('input[name="tags"]').tagsInput({minChars:2, height:'70px',defaultText:'<?php echo __('add-a-tag'); ?>', placeholderColor:'#999999'});
  $('img.thumb').on('click', function() {$("input[name='thumb_id']").val($(this).data('nr')); $('.thumb').removeClass('thumb-active'); $(this).addClass('thumb-active');});    		  	  
});
</script>
