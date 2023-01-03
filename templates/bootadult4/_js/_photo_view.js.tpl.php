<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if (VCfg::get('comment_captcha') === 2 and VCfg::get('recaptcha')): ?>
<script src="https://www.google.com/recaptcha/api.js"></script>
<?php endif; ?>
<script>
$(document).ready(function() {
  var photo_id = $("#photo").data('id');

  $('.btn-section').on('click', function(e) {
    e.preventDefault();
    $(this).parent().find('i').removeClass('text-section');
    $(this).find('i').addClass('text-section');
    $('.content-section').removeClass('d-block').addClass('d-none');
    $('#content-' + $(this).data('id')).addClass('d-block');
  });  

  $('#subscribe').on('click', '.btn-subscribe', function(e) {
    e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=profile_subscribe',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {user_id: $(this).data('user'), action: $(this).data('action')},
      success: function(response) {
        if (response.status == '1') {
      	  $('#subscribe').html(response.code);
        } else {
      	  $('#response').find('div').html(response.msg + close);
      	  $('#response').find('div').removeClass('alert-success').addClass('alert-danger');
      	  $('#response').removeClass('d-none').addClass('d-block');
        }
      }
    });
  });
  
  $('#image').on('mouseenter', function(e) {
	$('.photo-prev,.photo-next').show();
  });
      
  $('#image').on('mouseleave touchend', function(e) {
	$('.photo-prev,.photo-next').hide();
  });

  $('.btn-rate-photo').on('click', function(e) {
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
          $('#rating').html(response.code);
          $('.btn-rate-photo').addClass('disabled');
          $('.btn-rate-photo').attr('disabled', true);
        } else {
          $('#response').find('div').html(response.msg + close);
          $('#response').find('div').addClass(response.class);
          $('#response').removeClass('d-none').addClass('d-block');
        }
      }
    });
  });

  $('.btn-favorite-photo').on('click', function(e) {
    e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=photo_favorite',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {photo_id: photo_id},
      success: function(response) {
        if (response.status == '1') {
          $('#favorite-photo').addClass('text-danger');
          $('.btn-favorite-photo').addClass('disabled');
          $('.btn-favorite-photo').attr('disabled', true);
        } else {
          $('#response').find('div').html(response.msg + close);
          $('#response').find('div').addClass(response.class);
          $('#response').removeClass('d-none').addClass('d-block');
        }
      }
    });
  });
  
  $('#flag').on('click', function(e) {
    e.preventDefault();
    $.get(ajax_url + '/ajax.php?s=photo_flag&modal=1', function(response) {
      $('#flag-container').html(response);
      $('#flag-container').show();
      $('#flag-modal').modal();
    });
  });

  $("#flag-container").on('click', '#flag-send', function(e) {
    var reason = $("input[name='reason']:checked").val();
    var message = $("textarea[name='message']").val();
    $.ajax({
      url: ajax_url + '/ajax.php?s=photo_flag',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {photo_id: photo_id, reason: reason, message: message},
      success: function(response) {
       $('#flag-modal').modal('toggle');
        if (response.status == '1') {
          $('#flag i').addClass('text-success');
          $('#flag').prop('disabled', true);
          $('#response').find('div').removeClass('alert-danger').addClass('alert-success');
        } else {
          $('#response').find('div').removeClass('alert-success').addClass('alert-danger');
        }

        $('#response').find('div').html(response.msg + close);
        $('#response').find('div').addClass(response.class);
        $('#response').removeClass('d-none').addClass('d-block');
      }
    });
  });
});
</script>
