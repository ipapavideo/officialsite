<?php defined('_VALID') or die('Restricted Access!'); ?>
<script>
$(document).ready(function() {
  $(".btn-remove").on('click', function(e) {
	alert('clicked');
    e.preventDefault();
	var friend_id = $(this).data('id');
    $.ajax({
      url: ajax_url + '/ajax.php?s=user_friend',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {friend_id: friend_id, action: $(this).data('action')},
      success: function(response) {
    	if (response.status == '1') {
         $("div[id='user-" + friend_id + "']").fadeOut(500, function() {
            $(this).remove();
            if (!$("div.user").length) {
          	  $(".none").show();
            }
          });
    	}
      }
    });	
  });
});
</script>
