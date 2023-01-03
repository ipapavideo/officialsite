<?php
defined('_VALID') or die('Restricted Access!');
function ajax_plugin_photo_upload()
{
	$data = array('error' => '', 'message' => '', 'status' => 0);
    if (isset($_GET['id'])) {
  		$unique_id	= VF::factory('filter')->get('id', 'STRING', 'GET');
  		if (!ctype_digit($unique_id)) {
			$data['error'] 	= 100;
			$data['msg']	= 'Invalid unique identifier!';
			
			return json_encode($data);
  		}
  		
  		if (empty($_FILES) or !isset($_FILES['file'])) {
			$data['error'] 	= 101;
			$data['msg']	= 'No file was uploaded!';
			
			return json_encode($data);
  		}
  		
  		if ($_FILES['file']['error']) {
			$data['error'] 	= 102;
			$data['msg']	= $_FILES['file']['error'];
			
			return json_encode($data);
  		}
  		
  		set_time_limit(2*3600);
  		
  		$filename	= VFile::safe($_FILES['file']['name']);
  		$ext		= VFile::ext($filename);
  		$extensions	= explode(',', VCfg::get('photo.allowed_extensions'));
  		
  		if (!in_array($ext, $extensions)) {
			$data['error'] 	= 103;
			$data['msg']	= 'Invalid extension! Allowed extensions: '.implode(', ', $extensions).'.';
			
			return json_encode($data);
  		}
  		
  		if (!is_uploaded_file($_FILES['file']['tmp_name'])) {
			$data['error'] 	= 104;
			$data['msg']	= 'File is not a valid uploaded file!';
			
			return json_encode($data);
  		}
  		
  		$number		= VSession::get('files')+1;
  		$secret		= substr(md5(VCfg::get('secret')), -5);
  		$dst		= TMP_DIR.'/uploads/'.$unique_id.'_'.$secret.'.'.$number.'.'.$ext;
  		if (!move_uploaded_file($_FILES['file']['tmp_name'], $dst)) {
			$data['error'] 	= 105;
			$data['msg']	= 'Failed to move uploaded file!';
			
			return json_encode($data);
  		}
  		
        $info   	= TMP_DIR.'/uploads/'.$unique_id.'_'.$number.'_'.$secret;
        if (!file_put_contents($info, $filename."\n".$ext)) {
			$data['error'] 	= 106;
			$data['msg']	= 'Failed to write data file!';
			
			return json_encode($data);
		}
		
		VSession::set('files', $number);
		
		$data['status'] = 1;
		
		return json_encode($data);
	} else {
		$data['error']	= 110;
		$data['msg']	= 'No unique identifier set!';
		
		return json_encode($data);
	}
}
