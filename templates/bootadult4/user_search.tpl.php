<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_user_search.js'; $icons = VData::get('orders_icons', 'user'); ?>
<div class="row">
  <div class="col-12">
	<div class="row">
	  <div class="col-12 col-md-7 text-center text-md-left">
		<h1><?php echo e($this->title); ?></h1>
	  </div>
	  <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end align-items-center pb-1">
		<div class="btn-group" role="group">
  		  <div class="dropdown">
    		<button class="btn btn-sm btn-light dropdown-toggle" type="button" id="video-order-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      		  <i class="fa fa-<?php echo $icons[$this->order]; ?>"></i> <?php echo $this->orders[$this->order];  ?>
    		</button>
    		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="video-order-menu">
      		  <?php foreach ($this->orders as $order => $name): $active = ($order == $this->order) ? ' active'  : '';?>
      		  <a href="<?php echo build_url('order', $order, true); ?>" class="dropdown-item<?php echo $active; ?>"><i class="fa fa-<?php echo $icons[$order]; ?>"></i> <?php echo e($name); ?></a>
      		  <?php endforeach; ?>
    		</div>
  		  </div>
		</div>
		<div class="btn-group btn-group-sm ml-2" role="group">
		  <button id="user-filters" type="button" class="btn btn-sm btn-light"><?php echo __('more-filters'); ?> <i class="fa fa-plus"></i></button>
		  <a href="<?php echo REL_URL.LANG; ?>/user/search/" class="btn btn-link text-success" data-toggle="tooltip" data-placement="top" title="<?php echo __('user-reset-filters'); ?>"><i class="fa fa-toggle-off"></i></a>
		</div>
	  </div>
	</div>
	<div id="user-filters-container" class="bg-white border rounded-lg p-2 mb-2 mt-2 mt-md-1 d-none">
	  <form id="user-search-form" method="get" action="<?php echo BASE_URL,LANG,'/user/search/'; ?>">
		<div class="form-row">
      	  <div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
        	<label for="relation"><?php echo __('relation'); ?></label>
            <select name="relation" id="relation" class="form-control">
          	  <?php echo VForm::option(__('all'), $this->relation, 'all'); ?>
          	  <?php foreach ($this->relationships as $name => $id): echo VForm::option(__($name), $name, $this->relation); endforeach; ?>
            </select>
          </div>
          <div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
        	<label for="gender"><?php echo __('gender'); ?></label>
            <select name="gender" id="gender" class="form-control">
          	  <?php echo VForm::option(__('all'), $this->gender, 'all'); ?>
              <?php foreach ($this->genders as $name => $id): echo VForm::option(__($name), $name, $this->gender); endforeach; ?>
            </select>
          </div>    	
          <div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
            <label for="interested"><?php echo __('interested'); ?></label>
            <select name="interested" id="interested" class="form-control">
              <?php echo VForm::option(__('all'), $this->interested, 'all'); ?>
              <?php foreach ($this->interestedins as $name => $id): echo VForm::option(__($name), $name, $this->interested); endforeach; ?>
            </select>
          </div>    	
          <div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
            <label for="username"><?php echo __('username'); ?></label>
            <input name="username" type="text" id="username" class="form-control" value="<?php if ($this->username != 'all'): echo e($this->username); endif; ?>">
          </div>
          <div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
            <label for="city"><?php echo __('city'); ?></label>
            <input name="city" type="text" id="city" class="form-control" value="<?php if ($this->city != 'all'): echo e($this->city); endif; ?>">
          </div>    	
          <div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
        	<label for="country"><?php echo __('country'); ?></label>
            <select name="country" id="country" class="form-control">
          	  <?php echo VForm::option(__('all'), $this->country, 'all'); ?>
              <?php foreach ($this->countries as $row): echo VForm::option(e($row['countryName']), e($row['countryCode']), $this->country); endforeach; ?>
            </select>
          </div>    	
          <div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
        	<label for="age"><?php echo __('age'); ?></label>
        	<div class="d-block ml-2">
          	  <input name="age" id="age" type="hidden" value="18-99">
          	  <span id="age-min" class="mr-3 font-weight-bold">18</span><input type="text" id="age-range" name="age-range" data-slider-min="18" data-slider-max="99" data-slider-step="5" data-slider-value="[18,99]"><span id="age-max" class="ml-3 font-weight-bold">99</span>
            </div>
          </div>
          <div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
        	<?php echo VForm4::checkboxCustom('videos', 'yes', $this->videos, array('label' => __('has-videos'))); ?>
        	<?php echo VForm4::checkboxCustom('albums', 'yes', $this->albums, array('label' => __('has-albums'))); ?>
        	<?php echo VForm4::checkboxCustom('avatar', 'yes', $this->avatar, array('label' => __('has-avatar'))); ?>
        	<?php echo VForm4::checkboxCustom('online', 'yes', $this->online, array('label' => __('online'))); ?>
          </div>
    	</div>
    	<div class="w-100 mt-3 text-center">
    	  <button id="search-users" type="button" class="btn btn-lg btn-primary rounded-pill"><?php echo __('search'); ?></button>
    	</div>
	  </form>
	</div>
	<?php if ($this->users): echo p('users', $this->users); ?>
    <nav class="mt-3"><ul class="pagination pagination-lg justify-content-center"><?php echo p('pagination', $this->pagination, CUR_URL); ?></ul></nav>
    <?php else: ?>
    <div class="none"><?php echo __('no-users'); ?>
    <?php endif; ?>
  </div>
</div>
