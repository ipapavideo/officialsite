<?php defined('_VALID') or die('Restricted Access!'); ?>
<script>
$(document).ready(function() {
  $(".btn-remove").on('click', function(e) {
	e.preventDefault();	
	var playlist_id	= $(this).data('id');	
    $.ajax({
  	  url: ajax_url + '/ajax.php?s=user_playlist_delete',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {playlist_id: playlist_id},
      success: function(response) {
    	$("#response").html(close + response.msg);
    	if (response.status == '1') {
    	  $("li[id='playlist-" + playlist_id + "']").fadeOut(200, function() {
    		$(this).remove();
    		if (!$("li.playlist").length) {
    		  window.location = ajax_url + '/user/playlists/';
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