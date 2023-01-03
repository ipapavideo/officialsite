<html>
<head>
</head>
<body>
<?php if ($this->url): echo $this->url; endif; ?>
<form method="post" action="<?php echo REL_URL; ?>/add_channel.php">
Name:
<input name="name" type="text" value="<?php echo $this->name; ?>" style="width: 200px;"><br><br>
Thumb:
<input name="thumb_url" type="text" value="<?php echo $this->thumb_url; ?>" style="width: 700px;"><br><br>
Logo:
<input name="logo_url" type="text" value="<?php echo $this->logo_url; ?>" style="width: 700px;"><br><br>
<button name="submit" type="submit">Submit</button>
</form>
</body>
</html>