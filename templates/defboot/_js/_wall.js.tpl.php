<?php defined('_VALID') or die('Restricted Access!'); ?>
<script>
$(document).ready(function() {
  $(".stream-content-post").on("click", ".comment-wall", function(e) {
	e.preventDefault();
    var wall_id	= $(this).data('id');
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
<?php echo $this->fetch('_js/_wall_rating.js'); ?>
});
</script>
