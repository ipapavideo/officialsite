<?php defined('_VALID') or die('Restricted Access!'); ?>
<script>
$(document).ready(function() {
  $('.btn-delete').on('click', function(e) {
    e.preventDefault();
    if (!confirm('<?php echo __('inbox-delete-chat'); ?>')) {
  		return;
    }
	var sender_id = $(this).data('id');
    $.ajax({
      url: ajax_url + '/ajax.php?s=inbox_del',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {sender_id: sender_id},
      success: function(response) {
        if (response.status == '1') {
      	  $('tr#sender-' + sender_id).fadeOut('slow', function() {
      		$('tr#sender-' + sender_id).remove();
      	  });
        }
      }
    });	
  });  
});
</script>
