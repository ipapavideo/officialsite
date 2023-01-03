<?php defined('_VALID') or die('Restricted Access!'); ?>
		  	  <div class="user-filters-container">
        		<form id="user-search-form" method="get" action="<?php echo BASE_URL,LANG,'/user/search/'; ?>">
        		<div class="col-sm-4 col-md-3">
        		  <div class="form-group">
        			<label for="relation"><?php echo __('relation'); ?></label>
        			<select name="relation" id="relation" class="form-control select2">
        			  <?php echo VForm::option(__('all'), $this->relation, 'all'); ?>
        			  <?php foreach ($this->relationships as $name => $id): echo VForm::option(__($name), $name, $this->relation); endforeach; ?>
        			</select>
        		  </div>
        		</div>
        		<div class="col-sm-4 col-md-3">
        		  <div class="form-group">
        			<label for="gender"><?php echo __('gender'); ?></label>
        			<select name="gender" id="gender" class="form-control select2">
        			  <?php echo VForm::option(__('all'), $this->gender, 'all'); ?>
        			  <?php foreach ($this->genders as $name => $id): echo VForm::option(__($name), $name, $this->gender); endforeach; ?>
        			</select>
        		  </div>
        		</div>
        		<div class="col-sm-4 col-md-3">
        		  <div class="form-group">
        			<label for="interested"><?php echo __('interested'); ?></label>
        			<select name="interested" id="interested" class="form-control select2">
        			  <?php echo VForm::option(__('all'), $this->interested, 'all'); ?>
        			  <?php foreach ($this->interestedins as $name => $id): echo VForm::option(__($name), $name, $this->interested); endforeach; ?>
        			</select>
        		  </div>
        		</div>
        		<div class="col-sm-4 col-md-3">
        		  <div class="form-group">
        			<label for="username"><?php echo __('username'); ?></label>
        			<input name="username" type="text" id="username" class="form-control" value="<?php if ($this->username != 'all'): echo e($this->username); endif; ?>">
        		  </div>
        		</div>
        		<div class="col-sm-4 col-md-3">
        		  <div class="form-group">
        			<label for="city"><?php echo __('city'); ?></label>
        			<input name="city" type="text" id="city" class="form-control" value="<?php if ($this->city != 'all'): echo e($this->city); endif; ?>">
        		  </div>
        		</div>
        		<div class="col-sm-4 col-md-3">
        		  <div class="form-group">
        			<label for="country"><?php echo __('country'); ?></label>
        			<select name="country" id="country" class="form-control select2">
        			  <?php echo VForm::option(__('all'), $this->country, 'all'); ?>
        			  <?php foreach ($this->countries as $row): echo VForm::option(e($row['countryName']), e($row['countryCode']), $this->country); endforeach; ?>
        			</select>
        		  </div>
        		</div>
        		<div class="col-sm-4 col-md-3">
        		  <div class="form-group">
        			<label for="age"><?php echo __('age'); ?></label>
        			<div>
            		  <input name="age" type="hidden" value="<?php echo e($this->age); ?>">
                  	  <input type="text" id="age-range" name="age-range" data-slider-min="18" data-slider-max="99" data-slider-step="10" data-slider-value="[18,99]" data-slider-orientation="horizontal" data-slider-selection="none" data-slider-tooltip="show">
                    </div>
        		  </div>
        		</div>
        		<div class="col-sm-4 col-md-3">
        		  <div class="form-group">
              		<div class="checkbox"><?php echo VForm::checkbox('videos', 'yes', $this->videos); ?> <label><span class="profile-row"><?php echo __('has-videos'); ?></label></div>
              		<?php if (VModule::enabled('photo')): ?>
              		<div class="checkbox"><?php echo VForm::checkbox('albums', 'yes', $this->albums); ?> <label><span class="profile-row"><?php echo __('has-albums'); ?></label></div>
              		<?php endif; ?>
              		<div class="checkbox"><?php echo VForm::checkbox('avatar', 'yes', $this->avatar); ?> <label><span class="profile-row"><?php echo __('has-avatar'); ?></label></div>
              		<div class="checkbox"><?php echo VForm::checkbox('online', 'yes', $this->online); ?> <label><span class="profile-row"><?php echo __('online'); ?></label></div>
        		  </div>
        		</div>
        		<div class="clearfix"></div>
        		<div class="row text-center">
        		  <button id="search-users" type="button" class="btn btn-lg btn-submit"><?php echo __('search'); ?></button>
        		</div>
        		</form>
        	  </div>
