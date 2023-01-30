<?php defined('_VALID') or die('Restricted Access!'); ?>
<script>
var chat = $('.chat-body');
var idle = 0;

function refresh_chat(sender_id)
{
  $('#spinner').fadeIn();
  
  if (idle > 600) {
	$('#idle').fadeIn();
	return;
  }
  
  $('#idle').hide();
  
  $.ajax({
    url: ajax_url + '/ajax.php?s=chat_refresh',
    cache: false,
    type: "POST",
    dataType: "json",
    data: {sender_id: sender_id, msg_id: $('.sender:last').data('id')},
    success: function(response) {
      if (response.status == '1') {
    	$('.sender:last').nextAll().remove();      
  		$(chat).append(response.code);
      	chat.animate({scrollTop: chat.prop('scrollHeight') - chat.height()}, 500);
      }
    }
  });
  
  idle = idle + <?php echo VCfg::get('message.refresh_interval'); ?>;
  
  $('#spinner').fadeOut();
}

function sendMsg()
{
    var message = $("textarea#message").val();
    var error = '';
    if (message == '') {
  	  error = '<?php echo __('chat-message-empty'); ?>';
    } else if (message.length > <?php echo VCfg::get('message.max_length'); ?>) {
  	  error = '<?php echo __('chat-message-length', VCfg::get('message.max_length')); ?>';    
    }
    
    if (error) {
      $("#response").html(close + error);
      $("#response").show();
      return;
    }

    $.ajax({
      url: ajax_url + '/ajax.php?s=chat_add',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {receiver_id: $('#message').data('receiver'), message: message},
      success: function(response) {
        if (response.status == '1') {
      	  $('.none').hide();
      	  $('.chat-body').append(response.code);
      	  $('textarea#message').val('');
      	  chat.animate({scrollTop: chat.prop('scrollHeight') - chat.height()}, 500);
        } else {
          $("#response").html(close + response.msg);
          $("#response").show();
        }
      }
  });	
}

$(document).ready(function() {  
  $('html, body').animate({scrollTop: $(window).height() - 150}, 500);  
  chat.animate({scrollTop: chat.prop('scrollHeight') - chat.height()}, 100);
  
  $("#push-users").on('click', function() {
	if ($('.chat-users').is(':visible')) {
	  $('.chat-users').fadeOut();
	} else {
	  $('.chat-users').fadeIn();
	}
  });
  
  $("#close-users").on('click', function() {$('.chat-users').fadeOut();});

  $('button#send').on('click', function(e) {
    e.preventDefault();
    sendMsg();
  });
  
  $(document).keypress(function(e) {
	if ($("textarea#message").is(':focus')) {
  	  if(e.which == 13) {
  		sendMsg();	
      }
	}
  });  

  $("#friend").on('click', '.btn-friend', function(e) {
    e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=chat_friend',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {friend_id: $(this).data('id'), action: $(this).data('action')},
      success: function(response) {
        console.log(response);
        if (response.status == '1') {
          $("#friend").html(response.code);
        } else {
      	  alert(response.msg);
        }
      }
    });
  });

  $("#block").on('click', '.btn-block', function(e) {
    e.preventDefault();
    $.ajax({
      url: ajax_url + '/ajax.php?s=chat_block',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {blocked_id: $(this).data('id'), action: $(this).data('action')},
      success: function(response) {
        console.log(response);
        if (response.status == '1') {
          $("#block").html(response.code);
        } else {
      	  alert(response.msg);
        }
      }
    });
  });
  
  $('.btn-delete').on('click', function(e) {
    e.preventDefault();

    if (!confirm('<?php echo __('chat-message-delete'); ?>')) {
        return;
    }

    var msg_id = $(this).data('id');

    $.ajax({
      url: ajax_url + '/ajax.php?s=chat_del',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {msg_id: msg_id},
      success: function(response) {
        if (response.status == '1') {
          $('div#message-' + msg_id).fadeOut('slow', function() {
            $('div#message-' + msg_id).remove();
          });
        }
      }
    });
  }); 
  
  $('button#delete').on('click', function(e) {
    e.preventDefault();

    if (!confirm('<?php echo __('chat-clear'); ?>')) {
        return;
    }

    $.ajax({
      url: ajax_url + '/ajax.php?s=chat_clear',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {sender_id: $(this).data('id')},
      success: function(response) {
        if (response.status == '1') {
      	  $('.chat-body').html('');
        }
      }
    });
  });   

  $('button#clear').on('click', function(e) {
    e.preventDefault();

    $.ajax({
      url: ajax_url + '/ajax.php?s=chat_clear',
      cache: false,
      type: "POST",
      dataType: "json",
      data: {sender_id: $(this).data('id')},
      success: function(response) {
    	location.reload();
      }
    });
  });   
  
  $('a#refresh').on('click', function(e) {
	e.preventDefault();
	refresh_chat($(this).data('id'));
  });
  
  $('#idle').on('click', function(e) {
	  idle = 0;
	  $('#idle').hide();
	  $('a#refresh').trigger('click');
  });
  
  setInterval(function() {
	refresh_chat($('a#refresh').data('id'));	
  }, <?php echo VCfg::get('message.refresh_interval')*1000; ?>);
  
  $(this).mousemove(function (e) {idle = 0;});
  $(this).keypress(function (e) {idle = 0;});
});
</script>
