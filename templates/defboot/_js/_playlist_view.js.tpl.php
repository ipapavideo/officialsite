<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if (VCfg::get('recaptcha')): ?>
<script src="https://www.google.com/recaptcha/api.js"></script>
<?php endif; ?>
<script>
$(document).ready(function() {
  var playlist_id = $("#playlist").data('id');
  $("a.playlist-tab").on('click', function(e) {
    e.preventDefault();
    $('#response').hide();
    $(this).parent().addClass('active').siblings().removeClass('active');
    $('.content-tab').hide();
    $("#content-tab-" + $(this).data('tab')).show();
  });
  
  $(".rate-playlist").on('click', function(e) {
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
          $('.content-rating').html(response.code);
          $('.rate-video').addClass('disabled');
        } else {
          $("#response").html(close + response.msg);
          $("#response").addClass(response.class);
          $("#response").show();
        }
      }
    });
  });
  
  $('.favorite-playlist').on('click', function(e) {
    e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=playlist_favorite',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {playlist_id: playlist_id},
      success: function(response) {
        if (response.status == '1') {
          $('.favorite-playlist i').addClass('text-danger');
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