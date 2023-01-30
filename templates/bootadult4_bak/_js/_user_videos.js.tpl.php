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
    	$("#response").find('div').html(response.msg + close);
    	if (response.status == '1') {
    	  $('div#video-' + video_id).fadeOut(200, function() {
    		$(this).remove();
    		if (!$('div.video').length) {
    		  window.location = ajax_url + '/user/dashboard/';
    		}
    	  });
    	  
    	  $('#response').find('div').removeClass('alert-danger').addClass('alert-success');
    	} else {
    	  $('#response').find('div').removeClass('alert-success').addClass('alert-danger');
    	}
    	
    	$('#response').removeClass('d-none').addClass('d-block');
  	  }
	});
  });
});
</script>
