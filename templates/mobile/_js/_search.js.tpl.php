<?php defined('_VALID') or die('Restricted Access!'); ?>
<script>
$(document).ready(function() {
  if ($(window).width() > 1024) {
	$("#category").slimScroll({height: '250px', color: '#ff9900'});
	$("#trending").slimScroll({height: '370px', color: '#ff9900'});
  } else {
	$(".btn-panel").each(function() {
  	  var id = $(this).data('target');
  	  $(this).removeClass('opened').addClass('closed');
	  $(this).find('i').removeClass('fa-arrow-up').addClass('fa-arrow-down');
  	  $('#' + id).slideUp();
	});
  }
  
  $(".btn-panel").on('click', function(e) {
    e.preventDefault();
    var id = $(this).data('target');
    if ($(this).hasClass('closed')) {
  	  $(this).removeClass('closed').addClass('opened');
	  if (id == 'category' && $(window).width() > 1024) {$("#category").slimScroll({height: '250px', color: '#ff9900'});}
	  $(this).find('i').removeClass('fa-arrow-down').addClass('fa-arrow-up');
  	  $('#' + id).slideDown();
    } else {
  	  $(this).removeClass('opened').addClass('closed');
  	  if (id == 'category' && $(window).width() > 1024) {$("#category").slimScroll({destroy: true});}
	  $(this).find('i').removeClass('fa-arrow-up').addClass('fa-arrow-down');
  	  $('#' + id).slideUp();
    }
  });  
});
</script>
