<?php defined('_VALID') or die('Restricted Access!'); ?>
<div class="alert alert-danger text-center" role="alert">
  <div class="h2"><?php if (isset($this->message)): echo $this->message; else: echo __('page-not-found'); endif; ?></div>
</div>
<?php echo w('videos_viewed_today'); if (VModule::enabled('photo')): echo w('albums_viewed_today'); endif; ?>


