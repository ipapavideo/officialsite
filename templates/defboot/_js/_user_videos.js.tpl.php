<?php defined('_VALID') or die('Restricted Access!'); ?>
<script>
$(document).ready(function() {
  $(".btn-remove").on('click touchstart', function(e) {
	e.preventDefault();	
	var scr 		= null;
	var sub 		= $(this).data('sub');
	var video_id	= $(this).data('id');
	if (sub == 'user-videos') {
	  scr = '_delete';
	} else if (sub == 'user-favorites') {
	  scr = '_favorite_delete';
	} else if (sub == 'user-history') {
	  scr = '_history_delete';
	}	
    $.ajax({
  	  url: ajax_url + '/ajax.php?s=user_video' + scr,
      cache: false,
      type: "POST",
      dataType: "json",
      data: {video_id: video_id},
      success: function(response) {
    	$("#response").html(close + response.msg);    	
    	if (response.status == '1') {
    	  $("li[id='video-" + video_id + "']").fadeOut(200, function() {
    		$(this).remove();
    		if (!$("li.video").length) {
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
