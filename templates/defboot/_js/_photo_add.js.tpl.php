<?php defined('_VALID') or die('Restricted Access!'); ?>
<script src="<?php echo REL_URL; ?>/misc/bootstrap-filestyle/bootstrap-filestyle.min.js"></script>	  
<script src="<?php echo REL_URL; ?>/misc/plupload/js/plupload.full.min.js"></script>
<script>
$(function() {
  var errors = false;
  var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
    browse_button : 'files',
    container: document.getElementById('upload-container'),
    url : '<?php echo REL_URL; ?>/ajax.php?s=photo_upload&id=<?php echo $this->unique; ?>',
    flash_swf_url : '<?php echo REL_URL; ?>/misc/plupload/js/Moxie.swf',
    silverlight_xap_url : '<?php echo REL_URL; ?>/misc/plupload/js/Moxie.xap',
    multipart: true,
    multi_selection: true,                    
    filters : {
  	  max_file_size : '<?php echo VCfg::get('photo.max_size'); ?>mb',
      mime_types: [
    	{title : "<?php echo __('image-files'); ?>", extensions : "<?php echo VCfg::get('photo.allowed_extensions'); ?>"},
      ]
    }
  });	        
  uploader.init();                      
  uploader.bind('FilesAdded', function(up, files) {
	plupload.each(files, function(file) {
  	  $("#properties").append('<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>');
      $("#details").show();
    });
                  
    up.refresh();
  });                
  uploader.bind('UploadProgress', function(up, file) {$(".progress-bar").css('width', file.percent + '%');});                
  uploader.bind('Error', function(up, err) {
	errors = true;
    $("#file-group").removeClass('has-success').addClass('has-error');
    $("#errors").html(err.code + ': ' + err.message);
    $("#errors").show();
  });                
  uploader.bind('UploadComplete', function(up) {$("#upload-form").submit();});  
  $("button[id='upload']").on('click', function() {uploader.start();});
});	  
</script>
