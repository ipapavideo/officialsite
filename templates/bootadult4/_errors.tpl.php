<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if ($this->errors): ?>
<div class="alert alert-danger">
  <?php foreach ($this->errors as $error): echo '<strong>',$error,'</strong>',"<br>\n"; endforeach; ?>
</div>
<?php endif; ?>