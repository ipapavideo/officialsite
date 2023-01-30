var preload     = new Array;
var periodic;
var thumb_url   = null;
var thumb_def	= null;
var thumb_id	= null;
var percent		= 0;
var thumbs		= 0;
var j           = 0;
var close		= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';

function turl(video_id) {
  return tmb_url + '/' + pad(video_id, 9).toString().match(/.{3}/g).join('/');
}

function pad(num, size) {
    var s = '000000000' + num;
    return s.substr(s.length-size);
}

function changeThumb(id)
{
    if (j === thumbs) {return;}
    $("#thumb-slider").find('div').css('width', (percent*(j+1)) + '%');
    $("img[id='" + id + "']").attr('src', thumb_url + (j+1) + '.jpg');    
    j = (j+1) % thumbs;
}

function startThumbRotation(id)
{
  j = 0;
  if (thumb_url === null) {return;}
  if (thumbs <= 1) {return;}

  for (var i=1; i<=thumbs; i++) {
	if (i === (thumbs+1)) {break;}
	preload[i] 		= new Image;
	preload[i].src	= thumb_url + i + '.jpg';
  }
  
  periodic = window.setInterval("changeThumb('" + id + "')", 500);
}

function showLoginModal()
{
  $.get(ajax_url + '/ajax.php?s=user_login', function(response) {
	$("#login-container").html(response);
    $("#login-modal").modal();
  }); 
}

function submitLogin()
{
  var username    = $("input[name='m_username']").val();
  var password    = $("input[name='m_password']").val();
  var remember    = $("input[name='m_remember']:checked").val();

  $.ajax({
	url: ajax_url + '/ajax.php?s=user_login',
    cache: false,
    type: "POST",
    dataType: "json",
    data: {username: username, password: password, remember: remember, url: cur_url},
    success: function(response) {
  	  $("#response-login").html(response.msg);
      if (response.status == '1') {
    	$("#response-login").removeClass('alert-danger').addClass('alert-success');
        setTimeout(function() {window.location = cur_url;}, 500);
      } else {
        $("#response-login").removeClass('alert-success').addClass('alert-danger');
      }
      
      $("#response-login").show();
    }
  });
}

function submitSearch()
{
  var query   = $("input[name='s']").val().replace(/\ /g, '+');
  if (query == '') {
	return false;
  }
    
  var action  = $("#search-form").attr('action');
  if (action == rel_url + '/search/user/') {
      window.location = ajax_url + '/search/user/?username=' + query;
  } else {
      window.location = action + '?s=' + query;
  }
}

function startVideoPreview(elem)
{
  elem.append('<div class="thumb-loader"><i class="fa fa-spinner fa-pulse fa-2x fa-fw text-white"></i></div>');
  var thumb = elem.find('img:first');
  var video_id = $(thumb).data('id');
  var vurl = turl(video_id);
  var video = $('<video loop preload="none" muted="muted"><source src="' + vurl + '/preview.mp4" type="video/mp4"><source src="' + vurl + '/preview.webm" type="video/webm"></video>')
  $(video).attr({playsinline: true, muted: true});
  $(video).css({position: 'absolute', left: '0', top: '0', background: '#000000', width: '100%'});
  $(video).hide(); $(thumb).after($(video)); $(video)[0].play(); elem.find('.thumb-loader').remove(); $(video).fadeIn();
}

function stopVideoPreview(elem)
{
  var video = elem.find('video'); $(video).fadeOut(); $(video).remove();
}

function startThumbPreview(elem)
{
  var img = elem.find('img:first');
  var video_id = $(img).data('id');

  thumbs 	= $(img).data('thumbs');
  thumb_url = turl(video_id) + '/';
  thumb_def = $(img).attr('src');
  thumb_id	= $(img).attr('id');
	
  percent	= Math.floor(100/thumbs);
  elem.append('<div id="thumb-slider" class="thumb-slider"><div></div></div>');
	
  startThumbRotation($(img).attr('id'));
}

function stopThumbPreview(elem)
{
  window.clearInterval(periodic);
  $("#thumb-slider").remove();
  if (thumb_def !== null) {$(elem).find('img:first').attr('src', thumb_def);}
}

$(document).ready(function() {
  $('.login').on('click', function(e) {
	  e.preventDefault();
	  e.stopPropagation();

  	  if ($('#menu').hasClass('show-menu')) {
  		$('#menu').removeClass('show-menu').addClass('hide-menu');
  	  }
	  
	  showLoginModal();
  });
  
  $("#login-container").on('click', '#login-submit', function(e) {
	e.preventDefault();
    submitLogin();
  });
     
  $("#login-container").on('keypress', '#username, #m_username', function(e) {
    if (e.which == 13) {
      submitLogin();
    }
  });
    
  $("#login-container").on('keypress', '#password, #m_password', function(e) {
    if (e.which == 13) {
  	  submitLogin();
    }
  });

  if ($(window).width() <= 1024) {
	$('nav.menu').on('click', 'li.parent', function(e) {
	  $(this).children('ul').slideToggle();
	  e.preventDefault();
	  e.stopPropagation();
	});

	$('nav.menu').on('click', 'li > ul > li > a', function(e) {
	  e.stopPropagation();
	});
  }

  $('.menu').on('mouseenter', 'li > a', function(e) {
	$(this).find('.toggler').toggleClass('up');	
  });

  $('.menu').on('mouseleave', 'li > a', function(e) {
	$(this).find('.toggler').toggleClass('up');	
  });
  
  $(".menu-offcanvas").on('click', function(e) {
	e.preventDefault();	
	$(this).find('.toggler').toggleClass('down');	
	if ($('#menu').hasClass('show-menu')) {
	  $('#menu').removeClass('show-menu').addClass('hide-menu');
	} else {
	  $('#menu').removeClass('hide-menu').addClass('show-menu');
	}
  });

  $(".menu-search").on('click', function(e) {
	e.preventDefault();
	$(this).find('.toggler').toggleClass('down');
	if ($('#menu').hasClass('show-menu')) {
	  $('#menu').removeClass('show-menu').addClass('hide-menu');
	}
	$(".search").slideToggle();
  });
  
  $('.menu').on('click', 'button#language', function(e) {
	e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=language',
      cache: false,
      type: "POST",
      dataType: "text",
      data: {url:cur_url},
      success: function(response) {
  		if ($('#menu').hasClass('show-menu')) {
  		  $('#menu').removeClass('show-menu').addClass('hide-menu');
  		}
  	  
		$("#language-container").html(response);
  		$("#language-modal").modal();
      }
    });
  });

  $('.mobile-header').on('click', 'a#change-colors', function(e) {
	e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=theme',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {theme: $(this).data('theme')},
      success: function(response) {
    	window.location = cur_url;
      }
    });
  });
  
  $('.mega-menu').mouseover(function() {
	$(this).prev().addClass('open');
  }).mouseout(function() {
	$(this).prev().removeClass('open');
  });

  $('.menu-list').mouseover(function() {
	$(this).prev().addClass('open');
  }).mouseout(function() {
	$(this).prev().removeClass('open');
  });
  
  
  $('.search').on('click', 'a.dropdown-item', function(e) {
	e.preventDefault();
	$('.search').find('a.dropdown-item').removeClass('active');
	$(this).addClass('active');
	$("i#search-icon").attr('class', $(this).find('i').attr('class'));
	$('span.search-icon').html($(this).text());	
	$("#search-form").attr('action', rel_url + '/search/' + $(this).data('in') + '/');
  });
  
  $("button[id='search']").click(function(e) {
    submitSearch();
  });
    
  $("input[name='s']").keypress(function(e) {
    if (e.which == 13) {
  	  submitSearch();
    }
  });
  
  $("img.captcha-reload").on('click', function (e) {
	$(this).attr('src', ajax_url + '/captcha/?=' + Math.random());
  });  
    
  $(".comments-container,.post-comment").on('click', 'img.captcha-reload', function(e) {
	$(this).attr('src', ajax_url + '/captcha/?=' + Math.random());
  });
  
  $('.tabs').on('click', '.btn-tab', function(e) {
	var tab = $(this).data('target');
	if ($(this).data('type') == 'tabajax') {
	  $.get(ajax_url + '/ajax.php?s=' + $(this).data('url'), function(data) {
		$('#' + tab).html(data);
	  });
	}
	
	$(this).parent().find('.btn-tab').removeClass('btn-primary').addClass('btn-secondary');
	$(this).removeClass('btn-secondary').addClass('btn-primary');
	
	$(this).closest('.tabs').find('.tab-section').removeClass('d-block').addClass('d-none');
	$('#' + tab).addClass('d-block');
  });
  
  $(".autoselect").on("click", function () {
	$(this).select();
  });
  
  $("textarea[class='remaining']").keyup(function(){
    $("#remaining").text((500 - $(this).val().length));
  });  

  $('.videos').on('mouseenter', '.video:not(.video-private)', function(e) {
	$(this).find('.btn-playlist').show();
  });

  $('.videos').on('mouseleave', '.video:not(.video-private)', function(e) {
	$(this).find('.btn-playlist').hide();
  });

  $('.videos').on('mouseenter', '.video-preview', function(e) {
	startVideoPreview($(this));
  });

  $('.videos').on('mouseleave', '.video-preview', function(e) {
	stopVideoPreview($(this));
  });  

  $('.videos').on('mouseenter', '.thumb-preview', function(e) {
	startThumbPreview($(this));
  });

  $('.videos').on('mouseleave touchend', '.thumb-preview', function(e) {
	stopThumbPreview($(this));
  });  

  $('.video-preview').swipe({
    swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
      startVideoPreview($(this));
    },
    swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
      stopVideoPreview($(this));
    }
  });
    
  $('.thumb-preview').swipe({
    swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
      startThumbPreview($(this));
    },
    swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
      stopThumbPreview($(this));
    }
  });

  $("textarea[name='comment']").keyup(function(){
	$("#remaining").text((500 - $(this).val().length));
  });

  $("textarea[name='commentr']").keyup(function(){
    $("#remainingr").text((500 - $(this).val().length));
  });
  
  $("#comments-header").on('click', function(e) {
	$("#comments-body").slideToggle();
  });

  $(".comments-container").on({
	mouseenter: function() {
	  $(this).closest('div').find('.comments-buttons:first').removeClass('d-flex').addClass('d-none');
	  $(this).find('.comments-buttons:first').removeClass('d-none').removeClass('d-flex');
	},
    mouseleave: function() {$(this).find('.comments-buttons:first').removeClass('d-block').addClass('d-none');}
  }, '.media');
  
  $(".comment-post-container").on('click', "button[id^='post-comment-']", function(e) {
    e.preventDefault();
    var content_id	= $(this).data('id');
    var comment  	= $("textarea[id='comment-textarea-" + content_id + "']").val();
    var nickname 	= $("input[id='comment-nickname-" + content_id + "']").val();
    var token	 	= $("input[name='csrf_token_comment']").val();
    var type		= $(this).data('type');
    var captcha  	= null;

    if ($("#recaptcha").length) {
      captcha = grecaptcha.getResponse();
    } else if ($(".captcha-math").length) {
  	  captcha = $("input#comment-captcha-" + content_id).val();
    }
    
    if ($("input[id='comment-field']").val()) {
  		alert($("input[id='comment-field']").val());
  		return;
    }
    
    $.ajax({
      url: ajax_url + '/ajax.php?s=comment',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {csrf_token: token, content_id: content_id, comment: comment, nickname: nickname, captcha: captcha, type: type},
      success: function(response) {
        if (response.status == '1') {
          $("input[name='nickname']").val();
          $("textarea[name='comment']").val('');
          $("#no-comments").hide();
          $("#comments-container-" + content_id).prepend(response.code);
          $("#comments-container-" + content_id).show();
          $("#response-comment").removeClass('alert-danger').addClass('alert-success');
        } else {
          $("#response-comment").removeClass('alert-success').addClass('alert-danger');
        }

        $("#response-comment").html(response.msg + close);
        $("#response-comment").removeClass('d-none').addClass('d-block');;
      }
    });
  });  
  
  $(".comments-container").on('click', '#post-comment-reply', function(e) {
    e.preventDefault();    
    var parent_id	= $(this).data('parent-id');
    var content_id	= $(this).data('content-id');
    var comment  	= $("textarea[name='commentr']").val();
    var nickname 	= $("input[name='nicknamer']").val();
    var token		= $("input[name='csrf_token_comment_reply']").val();
    var captcha  	= null;
    if ($("#recaptcha").length) {
      captcha = grecaptcha.getResponse();
    } else if ($(".captcha-math").length) {
  	  captcha = $("input[name='captcha-verify-reply']").val();
    }

    if ($("input[id='comment-field']").val()) {
  		return;
    }
    
    $.ajax({
      url: ajax_url + '/ajax.php?s=comment',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {csrf_token: token, parent_id: parent_id, content_id: content_id, comment: comment, nickname: nickname, captcha: captcha, type: $(this).data('type')},
      success: function(response) {
        if (response.status == '1') {
          $("input[id='nicknamer']").val();
          $("textarea[name='commentr']").val('');
          $("#no-comments").hide();
          $("#comments-replies-container-" + parent_id).prepend(response.code);
          $("#comment-reply-container").after(response.code);
          $("#response-comment-reply").removeClass('alert-danger').addClass('alert-success');
        } else {
          $("#response-comment-reply").removeClass('alert-success').addClass('alert-danger');
        }

        $("#response-comment-reply").html(close + response.msg);
        $("#response-comment-reply").show();
      }
    });
  });  
  
  $(".comments-container").on('click', '.comment-rate', function(e) {
	var type = $(this).data('type');
	var vote = $(this).data('vote');
	var id	 = $(this).data('id');
    $.ajax({
      url: ajax_url + '/ajax.php?s=comment_vote',
      cache: false,
      type: "POST",
      dataType: "json",
      data: { comment_id: id, type: type, vote: vote},
      success: function(response) {
    	if (response.status == '1') {
    	  $('#comment-vote-' + id).find('small.text-success').html(response.likes);
    	  $('#comment-vote-' + id).find('.btn-rate').attr('disabled', true);
        } else {
      	  $('#comment-vote-' + id).find('small').last().html('<span class="text-danger">' + response.msg + '</span>');
        }
      }
    });
  });  
  
  $('.comments-container').on('click', '.comment-reply', function(e) {
	e.preventDefault();
	var comment_id = $(this).data('id');
    $.ajax({
  	  url: ajax_url + '/ajax.php?s=comment_reply',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {comment_id: comment_id, content_id: $(this).data('content-id'), type: $(this).data('type')},
      success: function(response) {
    	$("#comment-reply-container").remove();
        $("#comment-replies-container-" + comment_id).show();
        if (response.status == '1') {
      	  $("#comment-replies-container-" + comment_id).prepend(response.code);
        } else {
      	  var html = '<div class="alert alert-response content-group" style="display: none;">' + response.msg + '</div>';
          $("#comment-replies-container-" + comment_id).prepend(html);
        }
      }
    });
  });
  
  $('.comment-replies-container').on('click', '.comment-replies-load', function(e) {
	e.preventDefault();
	$(this).hide();
	$('#comment-replies-container-' + $(this).data('id')).find('.media').removeClass('d-none');
  });
  
  $(".comments-container").on('click', "button[id^='more-comments-']", function(e) {
    e.preventDefault();
    var content_id = $(this).data('id');
    $.ajax({
  	  url: ajax_url + '/ajax.php?s=comment_pagination',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {content_id: content_id, page: $(this).data('page'), type: $(this).data('type')},
      success: function(response) {
    	if (response.status == '1') {
    	  $("#comments-container-" + content_id).find('div.media:last').after(response.code);
    	  if (response.end == '1') {
    		$("button[id='more-comments-" + content_id + "']").hide();
    	  } else {
    		alert(content_id);
    		$("button#more-comments-" + content_id).data('page', response.page);
    		$("button#more-comments-" + content_id).attr('data-page', response.page);
    	  }
    	}
  	  }
    });
  });
  
  $(".comments-container").on('click', '.comment-spam', function(e) {
	e.preventDefault();
	var comment_id = $(this).data('id');
    $.ajax({
  	  url: ajax_url + '/ajax.php?s=spam',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {type: $(this).data('type'), comment_id: comment_id, content_id: $(this).data('content-id')},
      success: function(response) {
    	if (response.status == '1') {
    	  $("#comment-spam-button-" + comment_id).hide();
    	  $("#comment-spam-" + comment_id).addClass('text-success').html('<small>' + response.msg + '</small>');
    	} else {
    	  $.growl.error({message: response.msg});
    	}
      }
    });
  });

  $(".comments-container").on('click', '.comment-delete', function(e) {
	e.preventDefault();
	var comment_id = $(this).data('id');
    $.ajax({
  	  url: ajax_url + '/ajax.php?s=comment_delete',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {type: $(this).data('type'), comment_id: comment_id, content_id: $(this).data('content-id')},
      success: function(response) {
    	if (response.status == '1') {
    	  $('#comment-' + comment_id).fadeOut();
    	} else {
    	  $.growl.error({message: response.msg});
    	}
      }
    });
  });
  
  $(".videos").on('click', '.btn-playlist', function(e) {
	e.preventDefault();
    $.get(ajax_url + '/ajax.php?s=playlist&id=' + $(this).data('id'), function(response) {
  	  $('#playlists-modal-container').html(response);
  	  $('#playlists-modal').modal();
    });	  
  });
  
  $("#playlists-modal-container").on('click', 'button#playlist-new', function(e) {
	e.preventDefault();
    $.get(ajax_url + '/ajax.php?s=playlist_create&id=' + $(this).data('id'), function(response) {
  	  $('#playlist-create-container').html(response);
      $("#playlist-create-modal").modal();
      $('#playlists-modal').modal('hide');
    });
  });
  
  $('#playlist-create-container').on('click', "button#playlist-create", function(e) {
    e.preventDefault();
    var vid  = $(this).data('id');
    var name = $("input[name='name']").val();
    var desc = $("textarea[name='description']").val();
    var tags = $("textarea[name='tags']").val();
    var type = $("input[name='type']:checked").val();
    $.ajax({
      url: ajax_url + '/ajax.php?s=playlist_create',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {video_id: vid, name: name, description: desc, tags: tags, type: type},
      success: function(response) {
        if (response.status == '1') {
            $("#response-playlist").removeClass('alert-danger').addClass('alert-success');            
            $("#playlistss-modal-container").remove();
            setTimeout(function(){$("#playlist-create-modal").modal('toggle');}, 500);
        } else {
            $("#response-playlist").removeClass('alert-success').addClass('alert-danger');
        }

        $("#response-playlist").html(close + response.msg);
        $("#response-playlist").show();
      }
    });
  });
  
  $('#playlists-modal-container').on('click', 'a.list-group-item-action', function(e) {
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
  
  $('.video-favorite').on('click', function(e) {
    e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=video_favorite',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {video_id: $(this).data('id')},
      success: function(response) {
        if (response.status == '1') {
      	  $(this).addClass('active');
      	  $(this).addClass('disabled');
      	  $(this).attr('disabled', true);
      	  $.growl.notice({message: response.msg});
        } else {
      	  $.growl.error({message: response.msg});
        }
      }
    });
  });  

  $(document).mouseup(function (e) {
    var container = new Array();
    container.push($('#playlists-container'));    
    $.each(container, function(key, value) {
      if (!$(value).is(e.target) && $(value).has(e.target).length === 0) {
        $(value).remove();
      }
    });
  });
  
  $("input#categories-filter").on('keyup', function() {
	var value = this.value.toLowerCase().trim();
	$("#categories-list a").show().filter(function() {
  	  return $(this).text().toLowerCase().trim().indexOf(value) == -1;
	}).hide();
  });
  
  $('.elastic').focus(function() {
    $(this).attr('rows',3);
  }).blur(function(){
	if ($(this).val() == '0') {
  	  $(this).attr('rows',1);
    }
  });
  
  if (typeof $.fn.lazy == 'function') {
	$('.lazy').lazy();
  }
  
  $('button#gdpr').on('click', function(e) {
	Cookies.set('gdpr_consent', '1');
	$('#gdpr-container').fadeOut();
  });  

  $('.search').removeClass('d-none');  
  
  $(function () {
	$('[data-toggle="tooltip"]').tooltip()
  })  
});
