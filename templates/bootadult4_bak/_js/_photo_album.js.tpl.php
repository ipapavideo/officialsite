<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if (VCfg::get('comment_captcha') === 2 and VCfg::get('recaptcha')): ?>
<script src="https://www.google.com/recaptcha/api.js"></script>
<?php endif; ?>
<link type="text/css" rel="stylesheet" href="<?php echo REL_URL; ?>/misc/lightgallery/css/lightgallery.min.css" />
<script src="<?php echo REL_URL; ?>/misc/lightgallery/js/lightgallery.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/lightgallery-autoplay/lg-autoplay.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/lightgallery-fullscreen/lg-fullscreen.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/lightgallery-thumbnail/lg-thumbnail.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/lightgallery-zoom/lg-zoom.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script>
$(document).ready(function() {
  var album_id = $("#album").data('id');  

  $("#slideshow").on('click', function(e) {
	e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=photo_slideshow',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {album_id: album_id},
      success: function(response) {
        if (response.status == '1') {
      	  $(this).lightGallery({
      		dynamic: true,
      		dynamicEl: jQuery.parseJSON(response.code),
      		speed: 300,
      		download: false,
      		thumbnail: true,
      		autoplay: true
      	  });
        } else {
          $("#response").html(close + response.msg);
          $("#response").addClass(response.class);
          $("#response").show();
        }
      }
    });
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
          $('.btn-subscribe').data('action', response.action);
          $('.btn-subscribe').attr('data-action', response.action);
          $('.btn-subscribe').html(response.code);
        } else {
          $('#response').find('div').html(response.msg + close);
          $('#response').find('div').removeClass('alert-success').addClass('alert-danger');
          $('#response').removeClass('d-none').addClass('d-block');
        }
      }
    });
  });

  <?php if (isset($this->user_id) and $this->user_id = $this->album['user_id'] and VCfg::get('photo.allow_delete')): ?>
  $(".btn-remove").on('click', function(e) {
    e.preventDefault();
    var photo_id    = $(this).data('id');
    $.ajax({
      url: ajax_url + '/ajax.php?s=photo_delete',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {photo_id: $(this).data('id')},
      success: function(response) {
        if (response.status == '1') {
          $("li[id='photo-" + photo_id + "']").fadeOut(200, function() {
            $(this).remove();
            if (!$("li.photo").length) {
              window.location = window.location.href;
            }
          });
        } else {
      	  alert(response.msg);
        }
      }
    });
  });  
  <?php endif; ?> 
});
</script>
