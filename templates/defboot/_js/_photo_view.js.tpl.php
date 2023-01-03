<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if (VCfg::get('comment_captcha') === 2 and VCfg::get('recaptcha')): ?>
<script src="https://www.google.com/recaptcha/api.js"></script>
<?php endif; ?>
<script>
$(document).ready(function() {
  var photo_id = $("#photo").data('id');
  autosize($('textarea'));  
  $("a.video-tab").on('click', function(e) {
    e.preventDefault();
    $('#response').hide();
    $(this).parent().addClass('active').siblings().removeClass('active');
    $('.content-tab').hide();
    $("#content-tab-" + $(this).data('tab')).show();
  });
  
  $('#image').on('mouseenter', function(e) {
	$('.photo-prev,.photo-next').show();
  });
      
  $('#image').on('mouseleave touchend', function(e) {
	$('.photo-prev,.photo-next').hide();
  });
  
  $(".rate-photo").on('click', function(e) {
    e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=photo_rate',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {photo_id: photo_id, rating: $(this).data('rating')},
      success: function(response) {
        if (response.status == '1') {
          $('i#thumbs-up,i#thumbs-down').removeClass('text-success').removeClass('text-danger');
          if (response.rating == '1') {
            $('i#thumbs-up').addClass('text-success');
          } else {
            $('i#thumbs-down').addClass('text-danger');
          }
          $('.content-rating').html(response.code);
          $('.rate-photo').addClass('disabled');
        } else {
          $("#response").html(close + response.msg);
          $("#response").addClass(response.class);
          $("#response").show();
        }
      }
    });
  });
  $('.favorite-photo').on('click', function(e) {
    e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=photo_favorite',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {photo_id: photo_id},
      success: function(response) {
        if (response.status == '1') {
          $('.favorite-photo i').addClass('text-danger');
        } else {
          $("#response").html(close + response.msg);
          $("#response").addClass(response.class);
          $("#response").show();
        }
      }
    });
  });

  $('#flag').on('click', function(e) {
    e.preventDefault();
    $.get(ajax_url + '/ajax.php?s=photo_report&modal=1', function(response) {
      $("#report-container").removeClass();
      $("#report-container").html(response);
      $("#report-container").show();
      $("#report-modal").modal();
    });
  });

  $("#report-container").on('click', '#flag-send', function(e) {
    var reason = $("input[name='reason']:checked").val();
    var message = $("textarea[name='message']").val();
    $.ajax({
      url: ajax_url + '/ajax.php?s=photo_report',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {photo_id: photo_id, reason: reason, message: message},
      success: function(response) {
        $("#report-modal").modal('toggle');
        if (response.status == '1') {
          $("#flag i").addClass('text-success');
          $("#flag").prop('disabled', true);
          $("#response").removeClass('alert-danger').addClass('alert-success');
        } else {
          $("#response").removeClass('alert-success').addClass('alert-danger');
        }

        $("#response").html(close + response.msg);
        $("#response").show();
      }
    });
  });
});
</script>
