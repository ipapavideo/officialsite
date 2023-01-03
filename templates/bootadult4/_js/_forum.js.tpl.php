<?php defined('_VALID') or die('Restricted Access!'); ?>
<script>
$(document).ready(function() {
  $('a.toggle').on('click', function(e) {
	e.preventDefault();
	if ($(this).hasClass('toggle-open')) {
	  $(this).removeClass('toggle-open').addClass('toggle-closed');
	  $(this).find('i').removeClass('fa-minus').addClass('fa-plus');
	  $("#forums-" + $(this).data('id')).slideUp();
	} else {
	  $(this).removeClass('toggle-closed').addClass('toggle-open');
	  $(this).find('i').removeClass('fa-plus').addClass('fa-minus');
	  $("#forums-" + $(this).data('id')).slideDown();
	}
  });
  
  $('.btn-forum-report').on('click', function(e) {
	e.preventDefault();
	var type    = $(this).data('type');
	var post_id = $(this).data('id');
    $.get(ajax_url + '/ajax.php?s=forum_report&modal=1&post_id=' + post_id + '&type=' + type, function(response) {
      $("#report-container").removeClass();
      $("#report-container").html(response);
      $("#report-container").show();
      $("#report-modal").modal();
    });
  });

  $("#report-container").on('click', '#flag-send', function(e) {
    var reason 	= $("input[name='reason']:checked").val();
    var message = $("textarea[name='message']").val();
    var type	= $(this).data('type');
    var post_id	= $(this).data('id');
    $.ajax({
      url: ajax_url + '/ajax.php?s=forum_report',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {type: type, post_id: post_id, reason: reason, message: message},
      success: function(response) {
        if (response.status == '1') {      	          
      	  $("#report-" + type + "-" + post_id).prop('disabled', true);
      	  $("#report-" + type + "-" + post_id).addClass('btn-success');
      	  $("#report-" + type + "-" + post_id).html(response.msg);
      	  $("#report-modal").modal('toggle');
        } else {
          $("#report-response").removeClass('alert-success').addClass('alert-danger');
        }
        
        $("#report-response").html(close + response.msg);
        $("#report-response").show();
      }
    });
  });

  $('.btn-forum-delete').on('click', function(e) {
	e.preventDefault();
	var type    = $(this).data('type');
	var post_id = $(this).data('id');
    $.get(ajax_url + '/ajax.php?s=forum_delete&modal=1&post_id=' + post_id + '&type=' + type, function(response) {
      $("#delete-container").removeClass();
      $("#delete-container").html(response);
      $("#delete-container").show();
      $("#delete-modal").modal();
    });
  });

  $("#delete-container").on('click', '#forum-delete', function(e) {
    var type	= $(this).data('type');
    var post_id	= $(this).data('id');
    $.ajax({
      url: ajax_url + '/ajax.php?s=forum_delete',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {type: type, post_id: post_id},
      success: function(response) {
        if (response.status == '1') {
      	  if (response.code == '') {
      		$('#p' + post_id).html('<div class="alert alert-success"><strong>' + response.msg + '</strong></div>');
      		$("#delete-modal").modal('toggle');
      	  } else {
      		window.location = response.code;
      	  }                 
        } else {
          $("#delete-response").removeClass('alert-success').addClass('alert-danger');
        }
        
        $("#delete-response").html(close + response.msg);
        $("#delete-response").show();
      }
    });
  });
});
</script>
