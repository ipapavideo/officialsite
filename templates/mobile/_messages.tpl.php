<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if ($this->messages): ?>
<div class="alert alert-success">
  <?php foreach ($this->messages as $message): echo '<strong>',$message,'</strong>',"<br>\n"; endforeach; ?>
</div>
<?php endif; ?>