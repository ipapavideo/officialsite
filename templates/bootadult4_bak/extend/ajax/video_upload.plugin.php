<?php
defined('_VALID') or die('Restricted Access!');
function ajax_plugin_video_upload()
{
	$data = array('error' => '', 'message' => '', 'status' => 0);
	file_put_contents(TMP_DIR.'/logs/get.txt', var_export($_GET, true));
	file_put_contents(TMP_DIR.'/logs/post.txt', var_export($_POST, true));
	file_put_contents(TMP_DIR.'/logs/files.txt', var_export($_FILES, true));
	file_put_contents(TMP_DIR.'/logs/request.txt', var_export($_REQUEST, true));
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
  		
  		$chunking	= VCfg::get('video.chunking');
  		$chunk		= (isset($_POST['chunk'])) ? (int) $_POST['chunk'] : 0;
  		$chunks		= (isset($_POST['chunks'])) ? (int) $_POST['chunks'] : 0;
  		$filename	= ($chunking) ? $_POST['name'] : $_FILES['file']['name'];
  		$filename	= VFile::safe($filename);
  		$ext		= VFile::ext($filename);
  		$extensions	= explode(',', VCfg::get('video.allowed_extensions'));
  		
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
  		
  		$secret		= substr(md5(VCfg::get('secret')), -5);
  		$dst		= TMP_DIR.'/uploads/'.$unique_id.'_'.$secret.'.'.$ext;
  		
  		if ($chunking) {
  			$tmp	= $dst.'.part';  		
  			$out 	= @fopen($tmp, $chunk == 0 ? "wb" : "ab");
  			if ($out) {
				// Read binary input stream and append it to temp file
				$in = @fopen($_FILES['file']['tmp_name'], "rb");

				if ($in) {
					while ($buff = fread($in, 4096))
					fwrite($out, $buff);
				} else {
					$data['error'] 	= 108;
					$data['msg']	= 'Failed to open input chunk!';
					
					return json_encode($data);
				}

				@fclose($in);
				@fclose($out);
				@unlink($_FILES['file']['tmp_name']);  			
  			} else {
				$data['error'] 	= 107;
				$data['msg']	= 'Failed to write chunked out path!';
			
				return json_encode($data);
  			}
  			
  			if (!$chunks or ($chunk == $chunks-1)) {
  				file_put_contents(TMP_DIR.'/uploads/test.txt', $dst.' - '.$tmp);
  				
  				if (!rename($tmp, $dst)) {
					$data['error'] 	= 109;
					$data['msg']	= 'Failed to move uploaded file (chunking)!';
			
					return json_encode($data);
  				}
  			}
  		} else {  		
  			if (!move_uploaded_file($_FILES['file']['tmp_name'], $dst)) {
				$data['error'] 	= 105;
				$data['msg']	= 'Failed to move uploaded file!';
			
				return json_encode($data);
  			}
  		}
  		
        $info   	= TMP_DIR.'/uploads/'.$unique_id.'_'.$secret;
        if (!file_put_contents($info, $filename."\n".$ext)) {
			$data['error'] 	= 106;
			$data['msg']	= 'Failed to write data file!';
			
			return json_encode($data);
		}
		
		$data['status'] = 1;
		
		return json_encode($data);
	} else {
		$data['error']	= 110;
		$data['msg']	= 'No unique identifier set!';
		
		return json_encode($data);
	}
}
