<?php
	session_start();

	if (!isset($_COOKIE["KKUID"])) {
		$cookie = md5(uniqid("KK",1));
		setcookie("KKUID", $cookie, time() + (10 * 365 * 24 * 60 * 60), "/");
	}

    ini_set('display_errors', 1); // set to 0 for production version
    error_reporting(E_ALL);
	// Get Lander Name

	$url= $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
	if ( strpos($url,'?') != 0 ){
		$url=substr($url,0,strpos($url,'?'));
	}

	if ( strpos($url,'index.php') != 0 ){
		$url=substr($url,0,strpos($url,'index.php'));
	}

	$url = str_replace("www.", "", $url);
	$zurl = str_replace("/" , "=" , $url);
	$basepath = $_SERVER['DOCUMENT_ROOT'] . '/../data/';
	$file = $basepath . $zurl . '.dat';
	$zfile = $file;

	if (!file_exists($zfile)) {

		$link = "https://www.kowboykit.com/admin/add-lander.php?ref=" . $url;
		header('Location: ' . $link, true, 301);
		exit();

	}

	$lander_info = file_get_contents($file);
	$lander_info = json_decode($lander_info);
	$lid = $lander_info->{'lander_id'};
	$key = $lander_info->{'lander_key'};
	$protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';


	$offers = $lander_info->{'offer_package'};
	$random = rand(0,100);
	$currentpercent = 0;
	foreach($offers as $offer) {
		$weight = 100 * $offer->{'weight'};
		if ($currentpercent <= $random && $random <= ($currentpercent + $weight)) {
			$texts = $offer->{'text'};
			$textname = $offer->{'textname'};
			$images = $offer->{'images'};
			$imagesname = $offer->{'imagesname'};
			$linktemp = $offer->{'links'};
			$linksname = $offer->{'linksname'};
			$offerid = $offer->{'id'};
		}
		$currentpercent = $currentpercent + $weight;
	}

	$variant_id = 0;
	$variants = $lander_info->{'variants_package'};
	$random = rand(0,100);
	$currentpercent = 0;
	foreach($variants as $variant) {
		$weight = $variant->{'weight'};
		if ($currentpercent <= $random && $random <= ($currentpercent + $weight)) {
			$variant_id = $variant->{'id'};
			$variant_location = $variant->{'location'};
		}
		$currentpercent = $currentpercent + $weight;
	}

	$i = 0;
	$image = array();
	foreach($images as $img) {
		$image[$imagesname[$i]] = $protocol . "://{$_SERVER["HTTP_HOST"]}/images/kk/" . $img;
		$i++;
	}
	$i = 0;
	$text = array();
	foreach($texts as $t) {
		$text[$textname[$i]] = $t;
		$i++;
	}

	//Get and sanitize querystring data
	if (isset($_GET['s1'])) { $s1= $_GET['s1']; } else { $s1 = '';}
	$s1= preg_replace("/[^A-Za-z0-9 ]/", '', $s1);
	if (isset($_GET['s4'])) { 	$s4= $_GET['s4']; } else { $s4 = '';}
	$s4= preg_replace("/[^A-Za-z0-9 ]/", '', $s4);
	if (isset($_GET['s3'])) { 	$s3= $_GET['s3']; } else { $s3 = '';}
	$s3= preg_replace("/[^A-Za-z0-9 ]/", '', $s3);

	// Retrieve Lander info

	function getOS() {

		$user_agent     =   $_SERVER['HTTP_USER_AGENT'];

		$os_platform    =   "Unknown OS Platform";

		$os_array       =   array(
								'/windows nt 10/i'     =>  '1',
								'/windows nt 6.3/i'     =>  '2',
								'/windows nt 6.2/i'     =>  '3',
								'/windows nt 6.1/i'     =>  '4',
								'/windows nt 6.0/i'     =>  '5',
								'/windows nt 5.2/i'     =>  '6',
								'/windows nt 5.1/i'     =>  '7',
								'/windows xp/i'         =>  '8',
								'/windows nt 5.0/i'     =>  '9',
								'/windows me/i'         =>  '10',
								'/win98/i'              =>  '11',
								'/win95/i'              =>  '12',
								'/win16/i'              =>  '13',
								'/macintosh|mac os x/i' =>  '14',
								'/mac_powerpc/i'        =>  '15',
								'/linux/i'              =>  '16',
								'/ubuntu/i'             =>  '17',
								'/iphone/i'             =>  '18',
								'/ipod/i'               =>  '19',
								'/ipad/i'               =>  '20',
								'/android/i'            =>  '21',
								'/blackberry/i'         =>  '22',
								'/webos/i'              =>  '23'
							);

		foreach ($os_array as $regex => $value) {

			if (preg_match($regex, $user_agent)) {
				$os_platform    =   $value;
			}

		}

		return $os_platform;

	}

	function getBrowser() {

		$user_agent     =   $_SERVER['HTTP_USER_AGENT'];

		$browser        =   "Unknown Browser";

		$browser_array  =   array(
								'/msie/i'       =>  '1',
								'/firefox/i'    =>  '2',
								'/safari/i'     =>  '3',
								'/chrome/i'     =>  '4',
								'/edge/i'       =>  '5',
								'/opera/i'      =>  '6',
								'/netscape/i'   =>  '7',
								'/maxthon/i'    =>  '8',
								'/konqueror/i'  =>  '9',
								'/mobile/i'     =>  '10'
							);

		foreach ($browser_array as $regex => $value) {

			if (preg_match($regex, $user_agent)) {
				$browser    =   $value;
			}

		}

		return $browser;

	}


	$user_os        =   getOS();
	$user_browser   =   getBrowser();
	$safe = 0;

	if( !isset($_SESSION["sesh"]) ){
		$sesh=0;
	} else {
		$sesh=1;
	}

	if (isset($_SERVER['HTTP_REFERER'])) { $referer = $_SERVER['HTTP_REFERER']; } else { $referer = ''; }
	if (isset($_COOKIE["KKUID"])) {
		$cookie = $_COOKIE["KKUID"];
	}
	$da = array('URL'=> $url ,
			  'lander'=> $lid ,
              'ip'=> $_SERVER['REMOTE_ADDR'] ,
              'referer'=> $referer ,
			  'offer'=> $offerid,
              'browser'=> $user_browser ,
              'os'=> $user_os ,
              'session'=> $sesh ,
              'variant'=> $variant_id ,
              's1'=> $s1 ,
              's3'=> $s3 ,
              's4'=> $s4,
              'key' => $key);

	$data = http_build_query($da);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://kowboykit.com/api/click/track/in/");
	curl_setopt($ch,CURLOPT_POST,1);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,15);
	$output = curl_exec($ch);
	if(curl_errno($ch)){
		$error = 1;
	}
	curl_close($ch);

	$data = json_decode($output);
	$isin = $data->{'offergood'};
	$clickid = $data->{'clickid'};
	$link = array();
	$linkcount = count($linktemp);

	for ($i=0; $i<$linkcount; $i++) {
		$templink = $protocol . "://" . $_SERVER["SERVER_NAME"] . "/exit.php?l=" . $lid . "&v=" . $variant_id . "&s1=" . $s1 . "&s2=" . $clickid . "&s3=" . $s3 . "&s4=" . $s4 . "&link=" . $i . "&o=" . $offerid;
		$link[$linksname[$i]] = $templink;
	}

	$_SESSION["sesh"] = 1;

	$pixels = $lander_info->{'pixel_package'};
	$fire_pixel = "";
	foreach ($pixels as $pixel) {
		if ($pixel->{'type'} == 0) {
			$content = $pixel->{'content'};
			$fire_pixel = "{$fire_pixel}\r\n{$content}";
		}
	}
	echo $fire_pixel;

	if ($variant_id !=0) {
		require_once($variant_location);
		exit();
	}

?>
