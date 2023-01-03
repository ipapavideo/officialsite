<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if (isset($this->wall) and $this->wall): ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/summernote/summernote.css">
<script src="<?php echo REL_URL; ?>/misc/summernote/summernote.min.js"></script>
<?php endif; ?>
<script>
$(document).ready(function() {
  if ($("#profile").length) {
	var user_id = $("#profile").data('id');
  } else {
	var user_id = $("#profile-classic").data('id');
  }
  
  $("#subscribe").on('click', '.btn-subscribe', function(e) {
    e.preventDefault();
    
    var action	= $(this).data('action');
    $.ajax({
      url: ajax_url + '/ajax.php?s=profile_subscribe',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {user_id: user_id, action: action},
      success: function(response) {
    	console.log(response);
        if (response.status == '1') {
      	  $("#subscribe").html(response.code);
      	  $("#subscribers-count").html(response.subscribers);
        } else {
      	  $(".profile-header").append('<div class="alert alert-danger alert-dismissible" role="alert">' + close + response.msg + '</div>');
        }
      }
    });	
  });

  $("#friend").on('click', '.btn-friend', function(e) {
    e.preventDefault();
    
    var action	= $(this).data('action');
    $.ajax({
      url: ajax_url + '/ajax.php?s=profile_friend',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {user_id: user_id, action: action},
      success: function(response) {
    	console.log(response);
        if (response.status == '1') {
      	  $("#friend").html(response.code);
      	  $("#friends-count").html(response.subscribers);
        } else {
      	  $(".profile-header").append('<div class="alert alert-danger alert-dismissible" role="alert">' + close + response.msg + '</div>');
        }
      }
    });	
  });
  
  var VidButton = function (context) {
	var ui = $.summernote.ui;
	var button = ui.button({
  	  contents: '<i class="fa fa-video-camera"></i>',
  	  tooltip: 'hello',
  	  click: function () {
  		$.getJSON(ajax_url + '/ajax.php?s=profile_post_video&type=videos&user_id=' + user_id, function(response) {
  		  $("#modal-container").removeClass();
    	  $("#modal-container").html(response.code);
    	  $("#modal-container").show();
    	  $("#modal-insert").modal();
  		});
  	  }
	});

	return button.render();
  }  
  
  $("button#wall-post").on('click', function(e) {
    $.ajax({
      url: ajax_url + '/ajax.php?s=profile_post_load',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {user_id: user_id},
      success: function(response) {
        if (response.status == '1') {
		  $("#profile-wall-action").html(response.code);
		  $("#profile-editor").summernote({
			height: 200,
			toolbar: [
  			  ['style', ['bold', 'italic', 'underline', 'clear']],
  			  ['fontsize', ['fontsize']],
  			  ['color', ['color']],
  			  ['para', ['ul', 'ol', 'paragraph']],
  			  ['height', ['height']],
  			  ['myGroup', ['vid']],
  			  ['misc', ['fullscreen','undo','redo']]
			],
			buttons: {
			  vid: VidButton
			},
			callbacks: {
			  onKeyup: function(e) {
				var num = $("#profile-editor").summernote('code').length;
				$("#profile-remaining").text((10000 - num));
			  }
			}
		  });
        } else {
      	  $("#profile-wall-action").html('<div id="response" class="alert alert-response content-group">' + response.msg + '</div>');
        }
      }
    });	
  });
  
  $("#profile-wall-action").on('click', '.login', function(e) {
      e.preventDefault();
      e.stopPropagation();
      showLoginModal();
  });
  
  $("#profile-wall-action").on('click', 'ul.nav-tabs-video > li > a', function(e) {
	e.preventDefault();        
	var type    = $(this).data('type');        
	$.getJSON(ajax_url + '/ajax.php?s=profile_post_video&type=' + type + '&user_id=' + user_id, function(response) {
  	  $("#modal-insert").modal('hide');
  	  $('body').removeClass('modal-open');
  	  $("#modal-container").removeClass();
  	  $("#modal-container").html(response.code);
  	  $("#modal-container").show();
  	  $("#modal-insert").modal();
	});
  });
  
  $("#modal-container").on('click', 'ul.pagination-video > li > a', function(e) {
	e.preventDefault();
    var type    = $(this).data('type');
    var page    = $(this).data('page');
	$.getJSON(ajax_url + '/ajax.php?s=profile_post_video&type=' + type + '&user_id=' + user_id + '&page=' + page, function(response) {
  	  $("#modal-insert").modal('hide');
  	  $('body').removeClass('modal-open');
  	  $("#modal-container").removeClass();
  	  $("#modal-container").html(response.code);
  	  $("#modal-container").show();
  	  $("#modal-insert").modal();
	});
  });  

  $("#modal-container").on('click', 'ul.videos a', function(e) {
	e.preventDefault();
	var video_id = $(this).data('id');
	var title = $(this).attr('title');
	var embed = '<div class="embed-video"><iframe src="<?php echo BASE_URL; ?>/embed/' + video_id + '/" width="100%" height="100%" frameborder="0" border="0" scrolling="no"></iframe></div><div class="embed-video-title">' + title + '</div>';
	$("#profile-editor").summernote('code', $("#profile-editor").summernote('code') + embed);
    $("#modal-insert").modal('hide');
    $('body').removeClass('modal-open');
    e.stopPropagation();    
  });  
    
  $("#profile-wall-action").on('click', 'button#wall-submit', function(e) {
	var token	= $("input[name='csrf_token']").val();
	var content = $("#profile-editor").summernote('code');
    $.ajax({
      url: ajax_url + '/ajax.php?s=profile_post',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {user_id: user_id, content: content, csrf_token: token},
      success: function(response) {
        if (response.status == '1') {
      	  $("#profile-wall").after(response.code);
        } else {
      	  alert(response.msg);
        }
      }
    });	
  });
  
  $(".stream-content-post").on("click", ".comment-wall", function(e) {
    e.preventDefault();
    var wall_id = $(this).data('id');
    $.ajax({
      url: ajax_url + '/ajax.php?s=comment_wall_post',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {wall_id: wall_id},
      success: function(response) {
        if (response.status == '1') {
          $('#post-comment-' + wall_id).find('.comment-post-container').html(response.code);
          $('#post-comment-' + wall_id).slideToggle();
        }
      }
    });
  });
  
  $("a[id='wall-more']").on('click', function(e) {
	e.preventDefault();
    var page = $(this).data('page');
    $.ajax({
      url: ajax_url + '/ajax.php?s=profile_posts',
      cache: false,
      type: "POST",
      dataType: "json",
      data: { user_id: user_id, page: page },
      success: function(response) {
        if (response.status == '1') {
          $("a[id='wall-more']").data('page', response.page);
          $('.stream').last().after(response.code);
          if (response.end == '1') {
        	$("a[id='wall-more']").fadeOut();
          }
        }
      }
    });
  });
    
  <?php echo $this->fetch('_js/_wall_rating.js'); ?>
  
  var vheight	= $('.stream-content-video').find('.video:first').height()+45;
  var uheight	= $('.stream-content-profile').find('.user:first').height()+25;
  var cheight	= $('.stream-content-channel').find('.channel:first').height()+25;
  var mheight	= $('.stream-content-model').find('.model:first').height()+5;
  var pheight	= $('.stream-content-playlist').find('.playlist:first').height()+30;
  var aheight	= $('.stream-content-photo').find('.photo:first').height()+25;
 
  $(".stream-content-model").slimScroll({height: mheight + 'px', color: '#ff9900'});
  $(".stream-content-video").slimScroll({height: vheight + 'px', color: '#ff9900'});  
  $(".stream-content-channel").slimScroll({height: cheight + 'px', color: '#ff9900'});
  $(".stream-content-profile").slimScroll({height: uheight + 'px', color: '#ff9900'});
  $(".stream-content-playlist").slimScroll({height: pheight + 'px', color: '#ff9900'});
  $(".stream-content-photo").slimScroll({height: aheight + 'px', color: '#ff9900'});
});
</script>
