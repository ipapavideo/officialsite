<?php defined('_VALID') or die('Restricted Access!'); ?>
<script>
$(document).ready(function() {
  var model_id = $("#model").data('id');  
  $("#subscribe").on('click', '.btn-subscribe', function(e) {
    e.preventDefault();
    var action	= $(this).data('action');
    $.ajax({
      url: ajax_url + '/ajax.php?s=model_subscribe',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {model_id: model_id, action: action},
      success: function(response) {
        if (response.status == '1') {
          $('#subscribe').html(response.code);
          $('#subscribers-count').html(response.subscribers);
        } else {
      	  $('#model').before('<div class="row"><div class="col-12"><div class="alert alert-danger alert-dismissible" role="alert">' + response.msg + close + '</div></div></div>');
        }      
      }
    });	
  });
});
</script>