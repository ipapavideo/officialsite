<?php defined('_VALID') or die('Restricted Access!'); ?>
<?php $default = VCfg::get('orientation'); if ($default !== 0): $orientation = orientation(); $orientations = VData::get('orientations', 'core'); $icons = array(1 => 'venus-mars', 2 => 'mars-double', 3 => 'transgender'); ?>
<div class="dropdown show">
  <a class="btn dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-<?php echo $icons[$orientation]; ?>"></i> <?php echo __($orientations[$orientation]); ?></a>
  <div class="dropdown-menu">
	<?php foreach ($orientations as $key => $name): $url = ($default == $key) ? '/?orientation='.$name : '/'.$name.'/?orientation='.$name; $active = ($orientation == $key) ? ' active' : ''; ?>
  	<a href="<?php echo REL_URL.LANG.$url; ?>" class="dropdown-item<?php echo $active; ?>"><i class="fa fa-<?php echo $icons[$key]; ?>"></i> <?php echo __($name); ?></a>
  	<?php endforeach; ?>		
  </div>
</div>
<?php endif; if (VCfg::get('photo.browse_order')): ?>
<hr width="90%">
<div class="list-group list-group-small">
  <?php $icons = VData::get('orders_icons', 'photo'); foreach ($this->orders as $order => $name): $active = ($order == $this->order) ? ' active'  : ''; ?>
  <a href="<?php echo build_url($order, null, $this->slug, 1); ?>" class="list-group-item list-group-item-action<?php echo $active; ?>"><i class="fa fa-<?php echo $icons[$order]; ?>"></i> <?php echo e($name); ?></a>
  <?php endforeach; ?>
</div>
<?php endif; if (VCfg::get('photo.browse_category')): ?>
<hr width="90%">
<div class="input-group mb-3">
  <input type="text" id="categories-filter" class="form-control rounded-left-pill" placeholder="<?php echo __('categories'); ?>" aria-label="">
  <div class="input-group-append">
	<button class="btn btn-primary rounded-right-pill btn-search" type="button"><i class="fa fa-search"></i></button>
  </div>
</div>
<div id="categories-list" class="list-group list-group-small categories-less">
  <?php echo p('categories_list', $this->cat_id, 'photo'); ?>
</div>
<?php endif; ?>
