<?php defined('_VALID') or die('Restricted Access!'); ?>
<link href="<?php echo REL_URL; ?>/misc/croppie/croppie.css"  rel="stylesheet">
<?php $color = VCfg::get('template.defboot.colors'); if (strpos($color, 'dark') !== false): ?>
<link href="<?php echo REL_URL; ?>/misc/croppie/croppie-dark.css?t=<?php echo time(); ?>"  rel="stylesheet">
<?php endif; ?>
<script src="<?php echo REL_URL; ?>/misc/croppie/croppie.min.js"></script>
<script>
var $uploadCrop;
function readFile(input) {
  if (input.files && input.files[0]) {
	var reader = new FileReader();              
    reader.onload = function (e) {
  		$('#upload-result').show();
        $uploadCrop.croppie('bind', {
          url: e.target.result
        }).then(function(){
      	  $('#submit_crop').prop('disabled', false);
          console.log('jQuery bind complete');
        });      	
    }
              
    reader.readAsDataURL(input.files[0]);
  } else {
	alert("Sorry - you're browser doesn't support the FileReader API!");
  }
}

$(document).ready(function() {
  $uploadCrop = $('#crop').croppie({
	viewport: {
	  width: <?php echo $this->min_width; ?>,
	  height: <?php echo $this->min_height; ?>,
	  type: 'square'
	},
	enableExif: false
  });

  $('#file').on('change', function () { readFile(this); });
  
  $('#submit_crop').on('click', function (ev) {
	$uploadCrop.croppie('result', {
  	  type: 'base64',
      size: 'viewport',
      format: 'png'
    }).then(function (response) {
      $('#image_code').val(response);
      $('#avatar-form').submit();
    });
  });
});
</script>
