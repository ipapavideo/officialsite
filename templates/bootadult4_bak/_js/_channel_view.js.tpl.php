<?php defined('_VALID') or die('Restricted Access!'); ?>
<script>
$(document).ready(function() {
  var channel_id = $("#channel").data('id');
  $('#subscribe').on('click', '.btn-subscribe', function(e) {
    e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=channel_subscribe',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {channel_id: channel_id, action: $(this).data('action')},
      success: function(response) {
        if (response.status == '1') {
          $('#subscribe').html(response.code);
          $('#subscribers-count').html(response.subscribers);
        } else {
      	  $('#channel').before('<div class="row"><div class="col-12"><div class="alert alert-danger alert-dismissible" role="alert">' + response.msg + close + '</div></div></div>');
        }
      }
    });
  });
});
</script>

