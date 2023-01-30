<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_dashboard.js'; ?>
<?php echo $this->fetch('_user_header'); ?>
<div class="w-100 bg-white border rounded">
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
      <div class="col-xs-12 col-sm-12 py-3 text-center">
        <?php if ($premium and VAuth::group('Registered')): ?>
        <a href="<?php echo REL_URL,LANG; ?>/premium/upgrade/" class="btn btn-lg btn-light mb-sm-1"><i class="fa fa-cart-plus fa-3x"></i><br> <?php echo __('upgrade-to-premium'); ?></a>
        <?php endif; if (VModule::enabled('video') and VCfg::get('video.upload')): ?>
        <a href="<?php echo REL_URL,LANG; ?>/upload/" class="btn btn-lg btn-light mb-sm-1"><i class="fa fa-video-camera fa-3x"></i><br> <?php echo __('upload-videos'); ?></a>
        <?php endif; if (VModule::enabled('photo') and VCfg::get('photo.upload')): ?>
        <a href="<?php echo REL_URL,LANG; ?>/photo/upload/" class="btn btn-lg btn-light mb-sm-1"><i class="fa fa-camera fa-3x"></i><br> <?php echo __('upload-photos'); ?></a>
        <?php endif; ?>
        <a href="<?php echo REL_URL,LANG; ?>/users/<?php echo e(VSession::get('username')); ?>/" class="btn btn-lg btn-light mb-sm-1"><i class="fa fa-user fa-3x"></i><br> <?php echo __('view-profile'); ?></a>
      </div>  
  </div>
</div>
<?php if (isset($this->requests) and $this->requests): ?>
<div class="row mt-2">
  <div class="col-12">
    <div class="row">
      <div class="col-12 col-md-7 text-center text-md-left">
        <h3><?php echo __('pending-friendship-requests'); ?></h3>
      </div>
      <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
    	<a href="<?php echo REL_URL,LANG; ?>/user/dashboard/?requests=approve" class="btn btn-sm btn-success rounded-pill"><?php echo __('approve-all'); ?></a>
    	<a href="<?php echo REL_URL,LANG; ?>/user/dashboard/?requests=deny" class="btn btn-sm btn-danger rounded-pill ml-1"><?php echo __('deny-all'); ?></a>
      </div>
    </div>
	<?php echo p('users', $this->requests, '-request', $this->colmenu, $this->submenu, true); ?>
	<div class="none" style="display: none;"><?php echo __('no-pending-requests'); ?></div>
  </div>
</div>
<?php endif; ?>
<?php echo $this->fetch('_user_footer'); ?>
