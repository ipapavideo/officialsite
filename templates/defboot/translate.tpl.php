<html>
<head>
</head>
<body>
<form method="post" action="<?php echo CUR_URL; ?>" style="width: 100%; padding-bottom: 50px;">
<?php foreach ($this->translations as $index => $translation): ?>
<div style="width: 100%;">
  <div style="float: left; padding: 5px;"><input name="ids[]" type="checkbox" value="<?php echo $translation['trans_id']; ?>"></div>
  <div style="width: 3%; float: left; padding: 4px;"><?php echo $index; ?></div>
  <div style="width: 3%; float: left; padding: 5px;"><strong><?php echo $translation['trans_id']; ?></strong></div>
  <div style="width: 20%; float: left; padding: 5px;"><strong><?php echo $translation['name']; ?></strong></div>
  <div style="width: 60%; float: left; padding: 5px; border-bottom: 1px solid grey;"><?php echo $translation['trans']; ?></div>
  <div style="clear: both;"></div>
</div>
<?php endforeach; ?>
<input name="move" type="submit" value="MOVE">
</form>
</body>
</html>
