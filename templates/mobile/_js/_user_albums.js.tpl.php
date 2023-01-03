<?php defined('_VALID') or die('Restricted Access!'); ?>
<script>
$(document).ready(function() {
  $(".btn-remove").on('click', function(e) {
	e.preventDefault();
	var scr 		= null;
	var sub 		= $(this).data('sub');
	var album_id	= $(this).data('id');
	if (sub == 'user-albums') {
	  scr = '_delete';
	}
    $.ajax({
  	  url: ajax_url + '/ajax.php?s=user_album' + scr,
      cache: false,
      type: "POST",
      dataType: "json",
      data: {album_id: album_id},
      success: function(response) {
    	$("#response").html(close + response.msg);
    	if (response.status == '1') {
    	  $("li[id='album-" + album_id + "']").fadeOut(200, function() {
    		$(this).remove();
    		if (!$("li.album").length) {
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
