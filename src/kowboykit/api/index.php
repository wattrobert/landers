<?php
parse_str(file_get_contents("php://input"), $data);

$step = "";
if (isset($data['action'])) { $step = $data['action']; }

switch ($step) {

	Case "":

		$landerdata =  $data['lander_data'];
		$landerdecode = json_decode($landerdata);
		$key = $landerdecode->{'lander_key'};


		$basepath = $_SERVER['DOCUMENT_ROOT'] . '/../data/';
		$subbasepath = $_SERVER['DOCUMENT_ROOT'] . '/../';
		$error=0;

		$url = $landerdecode->{"URL"};
		$lid = $landerdecode->{"lander_id"};
		$url = str_replace("/" , "=" , $url);

		// Check folder and lander existence

		if (!file_exists($basepath)) {
			mkdir($basepath, 0777, true);
		}

		if (!is_dir($basepath)) {
			$errortext = "Kowboy Kit requires write access to {$subbasepath}.";
			$error=1;
		}

		$file = $basepath . $url . '.dat';
		if (file_exists($file)) {
			$lander_info = file_get_contents($file);
			$lander_info = json_decode($lander_info);
			$l_key = $lander_info->{'lander_key'};
			if ($l_key != $key) { die(); }
		}

		if (!file_exists($file)) {
			if (!is_dir($basepath) or !is_writable($basepath)) {
				$errortext= "Kowboy Kit requires write access to {$basepath}.";
				$error=1;
			}
			$txt = $landerdata;
			file_put_contents($file, $txt);
			chmod($file, 0664);
		} else {
			unlink($file);
			$txt = $landerdata;
			file_put_contents($file, $txt);
			chmod($file, 0664);
		}
		$file = $basepath . $lid . '.dat';
		if (!file_exists($file)) {
			if (!is_dir($basepath) or !is_writable($basepath)) {
				$errortext= "Kowboy Kit requires write access to {$basepath}.";
				$error=1;
			}
			file_put_contents($file, $url);
			chmod($file, 0664);
		} else {
			unlink($file);
			$txt = $landerdata;
			file_put_contents($file, $url);
			chmod($file, 0664);
		}

		// Get Resources
		function downloadImage($url,$filename){
			$ierror = 0;
			$ierrortext = "";
			if (!file_exists($filename)) {
				$result = parse_url($url);
				$ch = curl_init ($url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
				curl_setopt($ch, CURLOPT_REFERER, $result['scheme'].'://'.$result['host']);
				curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0');
				$raw = curl_exec($ch);
				curl_close ($ch);
				if($raw){
					$basepath = $_SERVER['DOCUMENT_ROOT'] . "/images/kk/";
					if (!is_dir($basepath) or !is_writable($basepath)) {
						$ierrortext= "Kowboy Kit requires write access to {$basepath}.";
						$ierror=1;
					}
					unlink($filename);
					file_put_contents($filename, $raw);
					chmod($filename, 0664);
				}
				if(!$raw){
					unlink($filename);
					$ierrortext= "Kowboy Kit could not connect to image resource.";
					$ierror=1;
				}
			}
			return [$ierror, $ierrortext];
		}

		if ($error == 0) {
			$offers = $landerdecode->{'offer_package'};
			foreach($offers as $offer) {
				$images = $offer->{'images'};
				foreach($images as $image) {
					$iurl = "https://kowboykit.com/u-images/" . $image;
					$iresource = $_SERVER['DOCUMENT_ROOT'] . "/images/kk/" . $image;
					if (!file_exists($iresource && $error == 0)) {
						$terror = downloadImage($iurl, $iresource);
						$error = $terror[0];
						$errortext = $terror[1];
					}
				}
			}
		}

		$response = json_encode(array("error" => $error, "errormessage" => $errortext));
		echo $response;

	break;

	Case "DELETE":

		$lid = $data['lid'];
		$url = $data['URL'];
		$key = $data['key'];

		$url = str_replace("/" , "=" , $url);

		$basepath = $_SERVER['DOCUMENT_ROOT'] . '/../data/';
		$file = $basepath . $url . '.dat';

		$lander_info = file_get_contents($file);
		$lander_info = json_decode($lander_info);
		$l_key = $lander_info->{'lander_key'};

		if ($key == $l_key) {
			$basepath = $_SERVER['DOCUMENT_ROOT'] . '/../data/';

			$file = $basepath . $url . '.dat';
			if (file_exists($file)) { unlink($file); } else {  }

			$file = $basepath . $lid . ".dat";
			if (file_exists($file)) { unlink($file); } else {  }
		}

		$data = json_encode(["Lander" => $lid, "URL" => $url, "Key" => $key]);

	break;

}
?>