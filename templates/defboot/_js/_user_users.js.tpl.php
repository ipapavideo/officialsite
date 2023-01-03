<?php defined('_VALID') or die('Restricted Access!'); ?>
<script>
$(document).ready(function() {
  $(".btn-remove").on('click touchstart', function(e) {
	e.preventDefault();	
	var scr 	= null;
	var sub 	= $(this).data('sub');
	var user_id	= $(this).data('id');
	if (sub == 'user-friends') {
	  scr = '_friend_delete';
	} else if (sub == 'user-subscribers') {
	  scr = '_subscriber_delete';
	} else if (sub == 'user-subscriptions') {
	  scr = '_subscription_delete';
	}	
    $.ajax({
  	  url: ajax_url + '/ajax.php?s=user' + scr,
      cache: false,
      type: "POST",
      dataType: "json",
      data: {user_id: user_id},
      success: function(response) {
    	$("#response").html(close + response.msg);
    	if (response.status == '1') {
    	  $("li[id='user-" + user_id + "']").fadeOut(500, function() {
    		$(this).remove();
    		if (!$("li.user").length) {
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
