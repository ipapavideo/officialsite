<?php defined('_VALID') or die('Restricted Access!'); ?>
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo REL_URL; ?>/misc/jquery-tags-input/css/jquery.tagsinput.min.css">
<script src="<?php echo REL_URL; ?>/misc/select2/js/select2.full.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/jquery-tags-input/js/jquery.tagsinput.min.js"></script>
<script src="<?php echo REL_URL; ?>/misc/plupload/js/plupload.full.min.js"></script>
<script>
$(document).ready(function() {
  $('input[name="tags"]').tagsInput({minChars:2, height:'70px',defaultText:'<?php echo __('add-a-tag'); ?>', placeholderColor:'#999999'});  	  
  $('#categories').select2({width: '100%',maximumSelectionLength: <?php echo VCfg::get('video.max_categories'); ?>,placeholder: '<?php echo __('video-category-placeholder'); ?>'});
  $('#models').select2({
	ajax: {
  	  url: ajax_url + '/ajax.php?s=model_select2',
  	  dataType: 'json',
  	  type: 'POST',
  	  delay: 250,
  	  data: function (params) {
  		return {
    	  k: params.term
    	};
  	  },
  	  processResults: function (data) {
  		return {
    	  results: data
    	};
  	  },
  	  cache: true
    },
    width: '100%',
    maximumSelectionLength: 4,
    minimumInputLength: 1,
    placeholder: '<?php echo __('video-model-placeholder'); ?>'
  });	  	  
});

var errors = false;
var uploader = new plupload.Uploader({
  runtimes : 'html5,flash,silverlight,html4',
  browse_button : 'file',
  container: document.getElementById('upload-container'),
  url : '<?php echo REL_URL; ?>/ajax.php?s=video_upload&id=<?php echo $this->unique; ?>',
  flash_swf_url : '<?php echo REL_URL; ?>/misc/plupload/js/Moxie.swf',
  silverlight_xap_url : '<?php echo REL_URL; ?>/misc/plupload/js/Moxie.xap',
  multipart: true,
  multi_selection: false,                    
  filters : {
	max_file_size : '<?php echo VCfg::get('video.max_size'); ?>mb',
    mime_types: [
  	  {title : "<?php echo __('video-files'); ?>", extensions : "<?php echo VCfg::get('video.allowed_extensions'); ?>"},
    ]
  }
});	  
      
uploader.init();                
  
uploader.bind('FilesAdded', function(up, files) {
  if (files.length > 1) uploader.splice(1, files.length - 1);
  plupload.each(files, function(file) {
    $("#properties").html('<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>');
    $("#details").show();
  });
                  
  up.refresh();
});
                
uploader.bind('UploadProgress', function(up, file) {
  $(".progress-bar").css('width', file.percent + '%');
});
                
uploader.bind('Error', function(up, err) {
  errors = true;
  $("#file-group").removeClass('has-success').addClass('has-error');
  $("#errors").html(err.code + ': ' + err.message);
  $("#errors").show();
});
                
uploader.bind('UploadComplete', function(up) {                  
  $("#upload-form").submit();
});
	  
$("button[id='upload']").on('click', function() {
  var error   = false;
  var title   = $("input[name='title']").val();
  if (title == '') {
	$("#title-group").removeClass('has-success').addClass('has-error');
    $("#title-error").html('<?php echo e(__('title-empty')); ?>');
    error = true;
  } else if (title.length < <?php echo VCfg::get('video.title_min_length'); ?>) {
    $("#title-group").removeClass('has-success').addClass('has-error');
    $("#title-error").html('<?php echo e(__('title-length', array(VCfg::get('video.title_min_length'), VCfg::get('video.title_max_length')))); ?>');
    error = true;
  } else if (title.length > <?php echo VCfg::get('video.title_max_length'); ?>) {
    $("#title-group").removeClass('has-success').addClass('has-error');
    $("#title-error").html('<?php echo e(__('title-length', array(VCfg::get('video.title_min_length'), VCfg::get('video.title_max_length')))); ?>');
    error = true;
  } else {
    $("#title-group").removeClass('has-error').addClass('has-success');
    $("#title-error").html('');
  }
        
  var categories = $("#categories").val();
  if (!categories || categories.length == 0) {
    $("#categories-group").removeClass('has-success').addClass('has-error');
    $("#categories-error").html('<?php echo e(__('categories-empty')); ?>');
  } else if (categories.length > <?php echo VCfg::get('video.max_categories'); ?>) {
    $("#categories-group").removeClass('has-success').addClass('has-error');
    $("#categories-error").html('<?php echo e(__('categories-max', array(VCfg::get('video.max_categories')))); ?>');
    error = true;
  } else {
    $("#categories-group").removeClass('has-error').addClass('has-success');
    $("#categories-error").html('');
  }
                    
  var tags    = $("input[name='tags']").val();
  if (tags == '') {
    $("#tags-group").removeClass('has-success').addClass('has-error');
    $("#tags-error").html('<?php echo e(__('tags-empty')); ?>');
    error = true;
  } else if (tags.length < <?php echo VCfg::get('video.tags_min_length'); ?>) {
    $("#tags-group").removeClass('has-success').addClass('has-error');
    $("#tags-error").html('<?php echo e(__('tags-length', array(VCfg::get('video.tags_min_length'), VCfg::get('video.tags_max_length')))); ?>');
    error = true;
  } else if (tags.length > <?php echo VCfg::get('video.tags_max_length'); ?>) {
    $("#tags-group").removeClass('has-success').addClass('has-error');
    $("#tags-error").html('<?php echo e(__('tags-length', array(VCfg::get('video.tags_min_length'), VCfg::get('video.tags_max_length')))); ?>');
    error = true;
  } else {
    $("#tags-error").html('');
          
    var tag_max_length_error = '<?php echo e(__('tag-length', array('#TAG#', VCfg::get('video.tag_max_length')))); ?>';
    var tag_max_words_error = '<?php echo e(__('tag-words', array('#TAG#', VCfg::get('video.tag_max_words')))); ?>';
    var tags_error = false;
    var arr = tags.split(',');
    jQuery.each(arr, function() {
  	  if (this.length > <?php echo VCfg::get('video.tag_max_length'); ?>) {
        $("#tags-group").removeClass('has-success').addClass('has-error');
        $("#tags-error").append(tag_max_length_error.replace('#TAG#', '"' + this + '"') + '<br>');
        error = true;
        tags_error = true;
      } else if (this.split(' ').length > <?php echo VCfg::get('video.tag_max_words'); ?>) {
        $("#tags-group").removeClass('has-success').addClass('has-error');
        $("#tags-error").append(tag_max_words_error.replace('#TAG#', '"' + this + '"') + '<br>');
        error = true;
        tags_error = true;
      }
    });

    if (!tags_error) {
  	  $("#tags-group").removeClass('has-error').addClass('has-success');
      $("#tags-error").html('');
    }      		
  }
                    
  if (uploader.files.length < 1) {
    $("#file-group").removeClass('has-success').addClass('has-error');
    $("#errors").html('<?php echo e(__('upload-file-select')); ?>');
    error = true;
  } else {
    $("#file-group").removeClass('has-error').addClass('has-success');
    $("#errors").html('');
  }

  if (error) {
    return;
  }
                
  uploader.start();
});	  
</script>	  