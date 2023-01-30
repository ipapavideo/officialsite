<?php defined('_VALID') or die('Restricted Access!'); $icons = VData::get('orders_icons', 'channel'); ?>
<div class="btn-toolbar" role="toolbar">
  <?php if (VCfg::get('channel.browse_letter') and $this->order == 'alphabetical'): ?>
  <div class="btn-group" role="group">
	<div class="dropdown">
	  <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="model-letter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<?php echo __('letter'),': ',ucfirst($this->letter); ?>
	  </button>
	  <div class="dropdown-menu dropdown-menu-inline" aria-labelledby="model-letter">
  		<a href="<?php echo build_url($this->orientation, 'all', $this->order); ?>" class="dropdown-item dropdown-item-inline<?php if ($this->letter == 'all'): echo ' active'; endif; ?>"><?php echo utf8_strtoupper(__('all')); ?></a>
  		<?php $letters = range('a', 'z'); foreach ($letters as $letter): $active = ($letter == $this->letter) ? ' active'  : '';?>
  		<a href="<?php echo build_url($this->orientation, $letter, $this->order); ?>" class="dropdown-item dropdown-item-inline<?php echo $active; ?>"><?php echo strtoupper($letter); ?></a>
  		<?php endforeach; ?>  
	  </div>
	</div>
  </div>
  <?php endif; ?>
  <div class="btn-group ml-2" role="group">
	<div class="dropdown">
	  <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="model-order-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  		<i class="fa fa-<?php echo $icons[$this->order]; ?>"></i> <?php echo $this->orders[$this->order];  ?>
	  </button>
	  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="model-order-menu">
  		<?php foreach ($this->orders as $order => $name): $active = ($order == $this->order) ? ' active'  : '';?>
  		<a href="<?php echo build_url($this->orientation, $this->letter, $order); ?>" class="dropdown-item<?php echo $active; ?>"><i class="fa fa-<?php echo $icons[$order]; ?>"></i> <?php echo e($name); ?></a>
  		<?php endforeach; ?>  
	  </div>
	</div>
  </div>
</div>
