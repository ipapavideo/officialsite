<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if (VCfg::get('comment_captcha') === 2 and VCfg::get('recaptcha')): ?>
<script src="https://www.google.com/recaptcha/api.js"></script>
<?php endif; if (isset($this->playlist) && $this->playlist): ?>
<script src="<?php echo REL_URL; ?>/misc/lightslider/js/lightslider.min.js"></script>
<?php endif; ?>
<script>
$(document).ready(function() {
  var video_id = $("#video").data('id');  
  autosize($('textarea'));  
  $("a.video-tab").on('click', function(e) {
    e.preventDefault();
    $('#response').hide();
    $(this).parent().addClass('active').siblings().removeClass('active');
    $('.content-tab').hide();
    $("#content-tab-" + $(this).data('tab')).show();
  });
  
  if ($(window).width() <= 960) {
	
  }
  
  $(".rate-video").on('click', function(e) {
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
  
  $('.favorite-video').on('click', function(e) {
    e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=video_favorite',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {video_id: video_id},
      success: function(response) {
        if (response.status == '1') {
          $('.favorite-video i').addClass('text-danger');
        } else {
          $("#response").html(close + response.msg);
          $("#response").addClass(response.class);
          $("#response").show();
        }
      }
    });
  });

  $("a[id='related-more']").on('click', function() {
    var page = $(this).data('page');
    $.ajax({
      url: ajax_url + '/ajax.php?s=video_related',
      cache: false,
      type: "POST",
      dataType: "json",
      data: { video_id: video_id, page: page },
      success: function(response) {
        if (response.status == '1') {
          $("a[id='related-more']").data('page', response.page);
          $("ul[class='videos related'] li:last").after(response.code);
          if (response.end == '1') {
            $("a[id='related-more']").fadeOut();
          }
        }
      }
    });
  });
<?php if (VModule::enabled('playlist')): ?>
  $(".video-playlist").on('click', function(e) {
    e.preventDefault();
    $.get(ajax_url + '/ajax.php?s=video_playlists&id=' + video_id, function(response) {
  	  $("#content-tab-playlist").html(response);
  	  $(".content-tab").hide();
  	  $("#content-tab-playlist").show();
    });	  
  });
  
  $("#content-tab-playlist").on('click', "button#playlist-new", function(e) {
	e.preventDefault();
	$.get(ajax_url + '/ajax.php?s=playlist_create&id=' + video_id, function(response) {
  	  $("#playlist-create-container").html(response);
  	  $("#playlist-create-modal").modal();
	});
  });    
  
  $("#content-tab-playlist").on('click', "button#playlist-create", function(e) {
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
    $.get(ajax_url + '/ajax.php?s=video_report&modal=1', function(response) {
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
      url: ajax_url + '/ajax.php?s=video_report',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {video_id: video_id, reason: reason, message: message},
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
<?php if (isset($this->playlist) and $this->playlist): ?>
  var slider = $("#lightSlider").lightSlider({
	autoWidth: true,
    onSliderLoad: function() {$('#lightSlider').removeClass('cS-hidden');}
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
