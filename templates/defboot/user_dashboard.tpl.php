<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_dashboard.js'; ?>
<?php echo $this->fetch('_user_header'); ?>
	<div class="row">
	  <?php $premium = VPlugin::enabled('premium'); if ($premium and VAuth::group('Premium')): $system = VCfg::get('premium.system'); ?>
	  <div class="col-xs-12 col-sm-12 text-center dashboard">
		<?php if ($system == 'subscription'): $end_time = VSession::get('end_time'); $end_date = date('d M Y', $end_time); $trans = ($end_time > time()) ? 'premium-membership-valid' : 'premium-membership-valid'; ?>
		<?php echo __($trans, $end_date); ?> <a href="<?php echo REL_URL; ?>/premium/renew/" class="btn btn-link"><strong><?php echo __('renew-now'); ?> <i class="fa fa-cart-plus"></i></a>
		<?php else: ?>
		<?php echo __('credits'),': <span class="btn btn-warning badge">',VSession::get('credit'); ?></span> <a href="<?php echo REL_URL; ?>/premium/credit/" class="btn btn-link"><strong><?php echo __('add'); ?> <i class="fa fa-cart-plus"></i></strong></a>
		<?php endif; ?>
	  </div>
	  <?php endif; ?>
	  <div class="col-xs-12 col-sm-12 text-center">
		<?php if ($premium and VAuth::group('Registered')): ?>		
		<a href="<?php echo REL_URL,LANG; ?>/premium/upgrade/" class="btn btn-lg btn-menu btn-success"><i class="fa fa-cart-plus fa-3x"></i><br> <?php echo __('upgrade-to-premium'); ?></a>
		<?php endif; if (VModule::enabled('video') and VCfg::get('video.upload')): ?>
		<a href="<?php echo REL_URL,LANG; ?>/upload/" class="btn btn-lg btn-menu"><i class="fa fa-video-camera fa-3x"></i><br> <?php echo __('upload-videos'); ?></a>
		<?php endif; if (VModule::enabled('photo') and VCfg::get('photo.upload')): ?>
		<a href="<?php echo REL_URL,LANG; ?>/photo/upload/" class="btn btn-lg btn-menu"><i class="fa fa-camera fa-3x"></i><br> <?php echo __('upload-photos'); ?></a>
		<?php endif; ?>
		<a href="<?php echo REL_URL,LANG; ?>/users/<?php echo e(VSession::get('username')); ?>/" class="btn btn-lg btn-menu"><i class="fa fa-user fa-3x"></i><br> <?php echo __('view-profile'); ?></a>
	  </div>
	</div>
  </div>
</div>
<?php if (isset($this->requests) and $this->requests): ?>
<div class="panel panel-default">
  <div class="panel-heading">
	<h3 class="panel-title pull-left"><?php echo __('pending-friendship-requests'); ?></h3>
	<div class="pull-right">
  	  <a href="<?php echo REL_URL,LANG; ?>/user/dashboard/?requests=approve" class="btn btn-xs btn-success"><?php echo __('approve-all'); ?></a>
  	  <a href="<?php echo REL_URL,LANG; ?>/user/dashboard/?requests=deny" class="btn btn-xs btn-danger"><?php echo __('deny-all'); ?></a>
    </div>
  	<div class="clearfix"></div>
  </div>
  <div class="panel-body">
	<?php $this->users = $this->requests; echo $this->fetch('_user_list'); ?>
	<div class="none" style="display: none;"><?php echo __('no-pending-requests'); ?></div>
  </div>
</div>	
<?php endif; ?>
