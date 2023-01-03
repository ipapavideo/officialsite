<?php defined('_VALID') or die('Restricted Access!'); ?>
  $(".rate-wall").on('click', function(e) {
	e.preventDefault();
    var wall_id	= $(this).data('id');
    $.ajax({
      url: ajax_url + '/ajax.php?s=profile_post_rate',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {wall_id: wall_id, rating: $(this).data('rating')},
      success: function(response) {
        if (response.status == '1') {
      	  $('#wall-rating-' + wall_id).html(response.code);
        }
      }
    });	
  });

  $(".report-wall").on('click', function(e) {
    e.preventDefault();
    var wall_id	= $(this).data('id');
    $.ajax({
      url: ajax_url + '/ajax.php?s=profile_post_report',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {wall_id: wall_id, modal: 1},
      success: function(response) {
        if (response.status == '1') {
  		  $("#wall-report-container").html(response.code);
  		  $("#report-modal").modal();
        }
      }
    });	
  });

  $('#wall-report-container').on('click', 'button#report-send', function(e) {
    e.preventDefault();
    alert('clicked');
    var wall_id	= $(this).data('id');
    var reason = $("input[name='reason']").val();
    var message = $("textarea[name='message']").val();
    $.ajax({
      url: ajax_url + '/ajax.php?s=profile_post_report',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {wall_id: wall_id, reason: reason, message: message},
      success: function(response) {
        if (response.status == '1') {
  		  $("#report-modal").modal('hide');
  		  $(".report-wall").prop('disabled', true);
        }
      }
    });	
  });
