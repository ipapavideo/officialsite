<?php defined('_VALID') or die('Restricted Access!'); $icons = array('recent' => 'calendar', 'popular' => 'line-chart'); ?>
<div class="row mt-2">
  <div class="col-12 col-md-7 text-center text-md-left">
    <div class="h4"><?php echo e($this->title); ?></div>
  </div>
  <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-end pb-1">
    <div class="btn-toolbar" role="toolbar">
      <div class="btn-group ml-2" role="group">
        <div class="dropdown">
          <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="model-video-order-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-<?php echo $icons[$this->order]; ?>"></i> <?php echo $this->orders[$this->order];  ?>
          </button>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="model-video-order-menu">
            <?php foreach ($this->orders as $order => $name): $active = ($order == $this->order) ? ' active'  : '';?>
            <a href="<?php echo build_url($this->model['slug'], $order, 'comments/'); ?>" class="dropdown-item<?php echo $active; ?>"><i class="fa fa-<?php echo $icons[$order]; ?>"></i> <?php echo e($name); ?></a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $allow_comment = VCfg::get('model.allow_comment'); $this->poster_id = $this->user_id; $this->content_id = $this->model_id; $this->ctype = 'model'; if ($allow_comment == '2' or ($allow_comment == '1' and $this->user_id)): ?>
<?php echo $this->fetch('_comment_post'); $this->allow_comment = true; else: $this->allow_comment = false; ?>
<div class="p-3 w-100 text-center">
  <div class="alert alert-warning"><?php echo __('comment-login', array('<a href="'.REL_URL.LANG.'/user/login/" class="login"><span>'.__('login').'</span></a>', '<a href="'.REL_URL.LANG.'/user/signup/"><span>'.__('signup').'</span></a>')); ?></div>
</div>
<?php endif; echo p('comments', $this->comments, $this->comments_total, $this->model_id, 'model', 0, $this->allow_comment); ?>
