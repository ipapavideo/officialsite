<?php defined('_VALID') or die('Restricted Access!'); ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/jquery-tags-input/css/jquery.tagsinput.min.css">
<script src="<?php echo REL_URL; ?>/misc/select2/js/select2.full.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/jquery-tags-input/js/jquery.tagsinput.min.js"></script>
<script>
$(document).ready(function() {
  $('input[name="tags"]').tagsInput({minChars:2, height:'70px',defaultText:'<?php echo __('add-a-tag'); ?>', placeholderColor:'#999999'});  	  
  $('#categories').select2({width: '100%',maximumSelectionLength: <?php echo VCfg::get('video.max_categories'); ?>,placeholder: '<?php echo __('video-category-placeholder'); ?>'});
  $('#models').select2({
	ajax: {
  	  url: ajax_url + '/ajax.php?s=model_select2',
      dataType: 'json',
      type: 'POST',
      delay: 250,
      data: function (params) {
    	return {
      	  k: params.term
        };
      },
      processResults: function (data) {
        return {
          results: data
        };
      },
      cache: true
    },
    width: '100%',
    maximumSelectionLength: 4,
    minimumInputLength: 1,
    placeholder: '<?php echo __('video-model-placeholder'); ?>'
  });  
  $('#channel_id').select2({width: '100%', placeholder: '<?php echo __('video-channel-placeholder'); ?>'});
  $('img.thumb').on('click', function() {$("input[name='thumb']").val($(this).data('nr')); $('.thumb').removeClass('thumb-active'); $(this).addClass('thumb-active');});    		  	  
});
</script>
