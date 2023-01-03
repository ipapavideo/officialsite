<?php defined('_VALID') or die('Restricted Access!'); ?>
<script>
$(document).ready(function() {
  $(".btn-action").on('click', function(e) {
	e.preventDefault();
	var comment_id	= $(this).data('id');
	var action		= $(this).data('action');
    $.ajax({
  	  url: ajax_url + '/ajax.php?s=user_comment_' + action,
      cache: false,
      type: "POST",
      dataType: "json",
      data: {comment_id: comment_id},
      success: function(response) {
    	$("#response").html(close + response.msg);
    	if (response.status == '1') {
    	  $("li[id='comment-" + comment_id + "']").fadeOut(200, function() {
    		$(this).remove();
    		if (!$("li.media").length) {
    		  window.location = ajax_url + '/user/dashboard/';
    		}
    	  });
    	  $("#response").removeClass('alert-danger').addClass('alert-success');
    	} else {
          $("#response").removeClass('alert-success').addClass('alert-danger');
    	}
    	$("#response").show();
  	  }
	});
  });
});
</script>
