<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if (VCfg::get('comment_captcha') === 2 and VCfg::get('recaptcha')): ?>
<script src="https://www.google.com/recaptcha/api.js"></script>
<?php endif; if (isset($this->playlist) && $this->playlist): ?>
<script src="<?php echo REL_URL; ?>/misc/lightslider/js/lightslider.min.js"></script>
<?php endif; ?>
<script>
$(document).ready(function() {
  var video_id = $("#video").data('id');  
  
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
  
  $(".btn-rate-video").on('click', function(e) {
    e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=video_rate',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {video_id: video_id, rating: $(this).data('rating')},
      success: function(response) {
        if (response.status == '1') {
          $('i#thumbs-up,i#thumbs-down').removeClass('text-success').removeClass('text-danger');
          if (response.rating == '1') {
            $('i#thumbs-up').addClass('text-success');
          } else {
            $('i#thumbs-down').addClass('text-danger');
          }
          $('#rating').html(response.code);
          $('.btn-rate-video').addClass('disabled');
          $('.btn-rate-video').attr('disabled', true);          
        } else {
      	  $('#response').find('div').html(response.msg + close);
      	  $('#response').find('div').addClass(response.class);
      	  $('#response').removeClass('d-none').addClass('d-block');
        }
      }
    });
  });
  
  $('.btn-favorite-video').on('click', function(e) {
    e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=video_favorite',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {video_id: video_id},
      success: function(response) {
        if (response.status == '1') {
      	  $('#favorite-video').addClass('text-danger');
      	  $('.btn-favorite-video').addClass('disabled');
      	  $('.btn-favorite-video').attr('disabled', true);
        } else {
      	  $('#response').find('div').html(response.msg + close);
      	  $('#response').find('div').addClass(response.class);
      	  $('#response').removeClass('d-none').addClass('d-block');
        }
      }
    });
  });

  $("#related-more").on('click', function() {
    var page = $(this).data('page');
    $.ajax({
      url: ajax_url + '/ajax.php?s=video_related',
      cache: false,
      type: "POST",
      dataType: "json",
      data: { video_id: video_id, page: page },
      success: function(response) {
        if (response.status == '1') {
      	  $('#related-more').data('page', response.page);
          $('#related-videos .videos').append(response.code);
          if (response.end == '1') {
            $('#related-more').fadeOut();
          }
        }
      }
    });
  });
<?php if (VModule::enabled('playlist')): ?>
  $('.video-playlist').on('click', function(e) {
    e.preventDefault();
    $(this).parent().find('i').removeClass('text-section');
    $(this).find('i').addClass('text-section');
    $('.content-section').removeClass('d-block').addClass('d-none');
    $.get(ajax_url + '/ajax.php?s=video_playlists&id=' + video_id, function(response) {
  	  $('#content-playlist').html(response);
  	  $('#content-playlist').removeClass('d-none').addClass('d-block');
    });	  
  });

  $('#content-playlist').on('click', 'a.list-group-item-action', function(e) {
    e.preventDefault();
    var vid = $(this).data('video');
    var pid = $(this).data('playlist');
    $.ajax({
      url: ajax_url + '/ajax.php?s=playlist_add',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {playlist_id: pid, video_id: vid},
      success: function(response) {
        if (response.status == '1') {
          $('a#playlist-' + pid + '-' + vid).html(response.code);
          $('a#playlist-' + pid + '-' + vid).addClass('disabled');
        } else if (response.status == '2') {
      	  $.growl.error({message: response.msg});
        }
      }
    });
  });
  
  $("#content-playlist").on('click', "button#playlist-new", function(e) {
	e.preventDefault();
	$.get(ajax_url + '/ajax.php?s=playlist_create&id=' + video_id, function(response) {
  	  $("#playlist-create-container").html(response);
  	  $("#playlist-create-modal").modal();
	});
  });    
  
  $("#content-playlist").on('click', "button#playlist-create", function(e) {
	e.preventDefault();  
    var name = $("input[name='name']").val();
    var desc = $("textarea[name='description']").val();
    var tags = $("textarea[name='tags']").val();
    var type = $("input[name='type']:checked").val();
    $.ajax({
      url: ajax_url + '/ajax.php?s=playlist_create',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {video_id: video_id, name: name, description: desc, tags: tags, type: type},
      success: function(response) {
    	if (response.status == '1') {
    		$("#response-playlist").removeClass('alert-danger').addClass('alert-success');
    		$("#content-tab-playlist").hide();
    		setTimeout(function(){$("#playlist-create-modal").modal('toggle');}, 2000);
    	} else {
    		$("#response-playlist").removeClass('alert-success').addClass('alert-danger');
    	}
    	
    	$("#response-playlist").html(close + response.msg);
    	$("#response-playlist").show();
      }
    });	
  });
<?php endif; ?>  
  $('#flag').on('click', function(e) {
    e.preventDefault();
    $.get(ajax_url + '/ajax.php?s=video_flag&modal=1', function(response) {
  	  $('#flag-container').html(response);
  	  $('#flag-container').show();
  	  $('#flag-modal').modal();
    });
  });

  $('#flag-container').on('click', '#flag-send', function(e) {
    var reason = $("input[name='reason']:checked").val();
    var message = $("textarea[name='message']").val();
    $.ajax({
      url: ajax_url + '/ajax.php?s=video_flag',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {video_id: video_id, reason: reason, message: message},
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
<?php if (isset($this->playlist) and $this->playlist): ?>
  var slider = $("#lightSlider").lightSlider({
	loop: false,
	autoWidth: true,
	pager: false,
    onAfterSlide: function() {$('#lightSlider').removeClass('cS-hidden');}
  });
            
  slider.goToSlide(<?php echo $this->item-1; ?>);
        
  <?php if (isset($this->prev)): ?>
  $("button[id='playlist-prev']").on('click', function() {
    window.location = ajax_url + '<?php echo $this->url_prev; ?>';
  });
  <?php endif; if (isset($this->next)): ?>
  $("button[id='playlist-next']").on('click', function() {
    window.location = ajax_url + '<?php echo $this->url_next; ?>';
  });
  <?php endif; ?>

  $("button[id='playlist-shuffle']").on('click', function() {
	var random = Math.floor((Math.random()* $('ul#lightSlider li').length )+1);
	window.location = $("ul#lightSlider li:nth-child(" + random + ")").find('a').attr('href');
  });
<?php endif; ?>
});
</script>
