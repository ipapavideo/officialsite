<?php defined('_VALID') or die('Restricted Access!'); $this->_js[] = '_premium_redirect.js'; ?>
      <div id="content">
        <h1><?php echo __('redirect-title', e($this->gateway)); ?></h1>
		<div class="content">
		  <div class="none text-center"><?php echo __('redirect-help'); ?></div>
		  <?php echo $this->form; ?>
		  <div class="text-center">
		  <button type="submit" class="btn btn-submit btn-lg"><?php echo __('redirect'); ?></button>
		  </div>
          </form>		  
		</div>
	  </div>
