<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if (VCfg::get('recaptcha')): ?>
<script src="https://www.google.com/recaptcha/api.js"></script>
<?php endif; ?>
<script>
$(document).ready(function() {
  var playlist_id = $('#playlist').data('id');

  $('.btn-section').on('click', function(e) {
    e.preventDefault();
    $(this).parent().find('i').removeClass('text-section');
    $(this).find('i').addClass('text-section');
    $('.content-section').removeClass('d-block').addClass('d-none');
    $('#content-' + $(this).data('id')).addClass('d-block');
  });

  $('.btn-rate-playlist').on('click', function(e) {
    e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=playlist_rate',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {playlist_id: playlist_id, rating: $(this).data('rating')},
      success: function(response) {
        if (response.status == '1') {
          $('i#thumbs-up,i#thumbs-down').removeClass('text-success').removeClass('text-danger');
          if (response.rating == '1') {
            $('i#thumbs-up').addClass('text-success');
          } else {
            $('i#thumbs-down').addClass('text-danger');
          }
          $('#rating').html(response.code);
          $('.btn-rate-playlist').addClass('disabled');
          $('.btn-rate-playlist').attr('disabled', true);
        } else {
          $('#response').find('div').html(response.msg + close);
          $('#response').find('div').addClass(response.class);
          $('#response').removeClass('d-none').addClass('d-block');
        }
      }
    });
  });

  $('.btn-favorite-playlist').on('click', function(e) {
    e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=playlist_favorite',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {playlist_id: playlist_id},
      success: function(response) {
        if (response.status == '1') {
          $('#favorite-playlist').addClass('text-danger');
          $('.btn-favorite-playlist').addClass('disabled');
          $('.btn-favorite-playlist').attr('disabled', true);
        } else {
          $('#response').find('div').html(response.msg + close);
          $('#response').find('div').addClass(response.class);
          $('#response').removeClass('d-none').addClass('d-block');
        }
      }
    });
  });
});
</script>
