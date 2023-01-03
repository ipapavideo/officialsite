<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_model_browse.js'; ?>
        	  <div class="model-filters-container" style="display: none;">
        		<div class="model-filter-col">
        		  <span class="filter-label"><?php echo __('gender'); ?>:</span>
        		  <div class="btn-group">
        			<button id="filter-gender" type="button" class="btn btn-menu btn-xs btn-filter dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        			  <?php if (isset($this->genders[$this->gender])): echo __($this->gender); else: echo __('all'); endif; ?> <span class="caret"></span>
        			</button>
        			<ul class="dropdown-menu">
        			  <li<?php if ($this->gender == 'all'): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'gender', 'all'); ?>"><?php echo __('all'); ?></a></li>
        			  <?php foreach ($this->genders as $name => $id): ?>
        			  <li<?php if ($this->gender == $name): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'gender', $name); ?>"><?php echo __($name); ?></a></li>
        			  <?php endforeach; ?>
        			</ul>
        		  </div>
        		</div>
        		<div class="model-filter-col">
        		  <span class="filter-label"><?php echo __('ethnicity'); ?>:</span>
        		  <div class="btn-group">
        			<button id="filter-ethnicity" type="button" class="btn btn-menu btn-xs btn-filter dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        			  <?php if (isset($this->ethnicities[$this->ethnicity])): echo __($this->ethnicity); else: echo __('all'); endif; ?> <span class="caret"></span>
        			</button>
        			<ul class="dropdown-menu">
        			  <li<?php if ($this->ethnicity == 'all'): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'ethnicity', 'all'); ?>"><?php echo __('all'); ?></a></li>
        			  <?php foreach ($this->ethnicities as $name => $id): ?>
        			  <li<?php if ($this->ethnicity == $name): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'ethnicity', $name); ?>"><?php echo __($name); ?></a></li>
        			  <?php endforeach; ?>
        			</ul>
        		  </div>
        		</div>
        		<div class="model-filter-col">
        		  <span class="filter-label"><?php echo __('hair-color'); ?>:</span>
        		  <div class="btn-group">
        			<button id="filter-hair_color" type="button" class="btn btn-menu btn-xs btn-filter dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        			  <?php if (isset($this->hair_colors[$this->hair_color])): echo __($this->hair_color); else: echo __('all'); endif; ?> <span class="caret"></span>
        			</button>
        			<ul class="dropdown-menu">
        			  <li<?php if ($this->hair_color == 'all'): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'hair', 'all'); ?>"><?php echo __('all'); ?></a></li>
        			  <?php foreach ($this->hair_colors as $name => $id): ?>
        			  <li<?php if ($this->hair_color == $name): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'hair', $name); ?>"><?php echo __($name); ?></a></li>
        			  <?php endforeach; ?>
        			</ul>
        		  </div>
        		</div>
        		<div class="model-filter-col">
        		  <span class="filter-label"><?php echo __('eye-color'); ?>:</span>
        		  <div class="btn-group">
        			<button id="filter-eye_color" type="button" class="btn btn-menu btn-xs btn-filter dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        			  <?php if (isset($this->eye_colors[$this->eye_color])): echo __($this->eye_color); else: echo __('all'); endif; ?> <span class="caret"></span>
        			</button>
        			<ul class="dropdown-menu">
        			  <li<?php if ($this->eye_color == 'all'): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'eyes', 'all'); ?>"><?php echo __('all'); ?></a></li>
        			  <?php foreach ($this->eye_colors as $name => $id): ?>
        			  <li<?php if ($this->eye_color == $name): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'eyes', $name); ?>"><?php echo __($name); ?></a></li>
        			  <?php endforeach; ?>
        			</ul>
        		  </div>
        		</div>
        		<div class="model-filter-col">
        		  <span class="filter-label"><?php echo __('bust-type'); ?>:</span>
        		  <div class="btn-group">
        			<button id="filter-bust_natural" type="button" class="btn btn-menu btn-xs btn-filter dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        			  <?php if (isset($this->bust_naturals[$this->bust_natural])): echo __($this->bust_natural); else: echo __('all'); endif; ?> <span class="caret"></span>
        			</button>
        			<ul class="dropdown-menu">
        			  <li<?php if ($this->bust_type == 'all'): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'bust', 'all'); ?>"><?php echo __('all'); ?></a></li>
        			  <?php foreach ($this->bust_types as $name => $id): ?>
        			  <li<?php if ($this->bust_type == $name): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'bust', $name); ?>"><?php echo __($name); ?></a></li>
        			  <?php endforeach; ?>
        			</ul>
        		  </div>
        		</div>
        		<div class="model-filter-col">
        		  <span class="filter-label"><?php echo __('bust-size'); ?>:</span>
        		  <div class="btn-group">
        			<button id="filter-bust_size" type="button" class="btn btn-menu btn-xs btn-filter dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        			  <?php if (isset($this->bust_sizes[$this->bust_size])): echo __($this->bust_size); else: echo __('all'); endif; ?> <span class="caret"></span>
        			</button>
        			<ul class="dropdown-menu">
        			  <li<?php if ($this->bust_size == 'all'): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'cup', 'all'); ?>"><?php echo __('all'); ?></a></li>
        			  <?php foreach ($this->bust_sizes as $name => $id): ?>
        			  <li<?php if ($this->bust_size == $name): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'cup', $name); ?>"><?php echo __($name); ?></a></li>
        			  <?php endforeach; ?>
        			</ul>
        		  </div>
        		</div>
        		<div class="model-filter-col">
        		  <span class="filter-label"><?php echo __('has-piercings'); ?>:</span>
        		  <div class="btn-group">
        			<button id="filter-piercing" type="button" class="btn btn-menu btn-xs btn-filter dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        			  <?php echo __($this->piercings); ?> <span class="caret"></span>
        			</button>
        			<ul class="dropdown-menu">
        			  <li<?php if ($this->piercings == 'all'): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'piercings', 'all'); ?>"><?php echo __('all'); ?></a></li>
        			  <li<?php if ($this->piercings == 'yes'): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'piercings', 'yes'); ?>"><?php echo __('yes'); ?></a></li>
        			  <li<?php if ($this->piercings == 'no'): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'piercings', 'no'); ?>"><?php echo __('no'); ?></a></li>
        			</ul>
        		  </div>
        		</div>
        		<div class="model-filter-col">
        		  <span class="filter-label"><?php echo __('has-tattoos'); ?>:</span>
        		  <div class="btn-group">
        			<button id="filter-tattoo" type="button" class="btn btn-menu btn-xs btn-filter dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        			  <?php echo __($this->tattoos); ?> <span class="caret"></span>
        			</button>
        			<ul class="dropdown-menu">
        			  <li<?php if ($this->tattoos == 'all'): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'tattoos', 'all'); ?>"><?php echo __('all'); ?></a></li>
        			  <li<?php if ($this->tattoos == 'yes'): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'tattoos', 'yes'); ?>"><?php echo __('yes'); ?></a></li>
        			  <li<?php if ($this->tattoos == 'no'): echo ' class="active"'; endif; ?>><a href="<?php echo build_search_url($this->query, $this->order, false, 'tattoos', 'no'); ?>"><?php echo __('no'); ?></a></li>
        			</ul>
        		  </div>
        		</div>
        		<div class="model-filter-col">
        		  <span class="filter-label"><?php echo __('age-range'); ?>:</span>
        		  <div class="btn-group">        			
        			<a href="<?php echo build_search_url($this->query, $this->order, false, 'age', 'RANGE'); ?>" id="age-range" style="display: none;"><?php echo __('age-range'); ?></a>
        			<input type="text" id="age" name="age" data-slider-min="18" data-slider-max="99" data-slider-step="10" data-slider-value="[18,99]" data-slider-orientation="horizontal" data-slider-selection="none" data-slider-tooltip="show">
        		  </div>
        		</div>
        		<div class="clearfix"></div>
        	  </div>
