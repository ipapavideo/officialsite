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
      	  $("#subscribe").html(response.code);
      	  $("#subscribers-count").html(response.subscribers);
        } else {
      	  $(".model-header").append('<div class="alert alert-danger alert-dismissible" role="alert">' + close + response.msg + '</div>');
        }
      }
    });	
  });
  
  $(".rate-model").on('click', function(e) {
    e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=model_rate',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {model_id: model_id, rating: $(this).data('rating')},
      success: function(response) {
        if (response.status == '1') {
      	  $('i#thumbs-up,i#thumbs-down').removeClass('text-success').removeClass('text-danger');
          if (response.rating == '1') {$('i#thumbs-up').addClass('text-success');} else {$('i#thumbs-down').addClass('text-danger');}
      	  $('.model-rating-result').html(response.code);
      	  $('.rate-model').addClass('disabled');
        } else {
          $("#response").html(close + response.msg);
          $("#response").addClass(response.class);
          $("#response").show();
        }
        
      }
    });
  });  
});
</script>