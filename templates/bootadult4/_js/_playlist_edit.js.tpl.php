<?php defined('_VALID') or die('Restricted Access!'); ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/jquery-tags-input/css/jquery.tagsinput.min.css">
<script src="<?php echo REL_URL; ?>/misc/jquery-tags-input/js/jquery.tagsinput.min.js"></script>
<script>
$(document).ready(function() {
  $('input[name="tags"]').tagsInput({minChars:2, height:'80px', width: '100%', defaultText:'<?php echo __('add-a-tag'); ?>', placeholderColor:'#999999'});
  $('img.playlist-image').on('click', function() {$("input[name='thumb_id']").val($(this).data('nr')); $('.playlist-image').removeClass('border-primary'); $(this).addClass('border-primary');});
});
</script>
