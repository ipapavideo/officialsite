<?php defined('_VALID') or die('Restricted Access!'); $yesno = array('yes' => 'yes', 'no' => 'no'); ?>
	<div id="model-filters-container" class="bg-white border rounded-lg p-2 mb-2 d-none">
	  <form id="model-filters-form" method="get" action="<?php echo REL_URL.LANG.'/search/model/?s='.$this->query; ?>">
	  <div class="form-row">
		<div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
		  <label for="gender"><?php echo __('gender'); ?></label>
		  <?php echo VForm4::select('gender', $this->genders, $this->gender, array('class' => 'form-control', 'translate' => true, 'inverse' => true), array('display' => __('all'), 'value' => 'all', 'selected' => $this->gender)); ?>
		</div>
		<div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
		  <label for="ethnicity"><?php echo __('ethnicity'); ?></label>
		  <?php echo VForm4::select('ethnicity', $this->ethnicities, $this->ethnicity, array('class' => 'form-control', 'translate' => true, 'inverse' => true), array('display' => __('all'), 'value' => 'all', 'selected' => $this->ethnicity)); ?>
		</div>
		<div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
		  <label for="hair_color"><?php echo __('hair-color'); ?></label>
		  <?php echo VForm4::select('hair_color', $this->hair_colors, $this->hair_color, array('class' => 'form-control', 'translate' => true, 'inverse' => true), array('display' => __('all'), 'value' => 'all', 'selected' => $this->hair_color)); ?>
		</div>
		<div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
		  <label for="eye_color"><?php echo __('eye-color'); ?></label>
		  <?php echo VForm4::select('eyes', $this->eye_colors, $this->eye_color, array('class' => 'form-control', 'translate' => true, 'inverse' => true), array('display' => __('all'), 'value' => 'all', 'selected' => $this->eye_color)); ?>
		</div>
		<div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
		  <label for="bust_type"><?php echo __('bust-type'); ?></label>
		  <?php echo VForm4::select('bust', $this->bust_types, $this->bust_type, array('class' => 'form-control', 'translate' => true, 'inverse' => true), array('display' => __('all'), 'value' => 'all', 'selected' => $this->bust_type)); ?>
		</div>
		<div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
		  <label for="bust_size"><?php echo __('bust-size'); ?></label>
		  <?php echo VForm4::select('cup', $this->bust_sizes, $this->bust_size, array('class' => 'form-control', 'translate' => true, 'inverse' => true), array('display' => __('all'), 'value' => 'all', 'selected' => $this->bust_size)); ?>
		</div>
		<div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
		  <label for="piercings"><?php echo __('piercings'); ?></label>
		  <?php echo VForm4::select('piercings', $yesno, $this->piercings, array('class' => 'form-control', 'translate' => true), array('display' => __('all'), 'value' => 'all', 'selected' => $this->piercings)); ?>
		</div>
		<div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
		  <label for="tattoos"><?php echo __('tattoos'); ?></label>
		  <?php echo VForm4::select('tattoos', $yesno, $this->tattoos, array('class' => 'form-control', 'translate' => true), array('display' => __('all'), 'value' => 'all', 'selected' => $this->tattoos)); ?>
		</div>
		<div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
		  <label for="country"><?php echo __('country'); ?></label>
		  <select name="country" id="country" class="form-control">
			<?php echo VForm4::option(__('all'), 'all', $this->country);  foreach (VCountry::getCountries() as $country_id => $country): echo VForm4::option(e($country['countryName']), $country_id, $this->country); endforeach; ?>
		  </select>
		</div>
		<div class="form-group col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
		  <label for="age"><?php echo __('age'); ?></label>
		  <div class="d-block ml-2">
			<input name="age" id="age" type="hidden" value="18-99">
        	<span id="age-min" class="mr-3 font-weight-bold">18</span><input type="text" id="age-range" name="age-range" data-slider-min="18" data-slider-max="99" data-slider-step="5" data-slider-value="[18,99]"><span id="age-max" class="ml-3 font-weight-bold">99</span>
          </div>
		</div>
		<div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center">
		  <button id="model-filter" type="button" class="btn btn-primary mt-4"><?php echo __('search'); ?></button>
		  <button id="model-reset" type="button" class="btn btn-secondary mt-4"><?php echo __('cancel'); ?></button>
		</div>		
	  </div>
	  </form>	
	</div>
