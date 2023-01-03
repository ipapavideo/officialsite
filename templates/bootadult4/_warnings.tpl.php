<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php if ($this->warnings): ?>
<div class="alert alert-warning">
  <?php foreach ($this->warnings as $warning): echo '<strong>',$warning,'</strong>',"<br>\n"; endforeach; ?>
</div>
<?php endif; ?>
