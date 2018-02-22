<?php
	session_start();
	if (!isset($_COOKIE["KKUID"])) {
		$cookie = md5(uniqid("KK",1));
		setcookie("KKUID", $cookie, time() + (10 * 365 * 24 * 60 * 60), "/");
	}
	ini_set('display_errors', 1); // set to 0 for production version
	error_reporting(E_ALL);
	// Get Lander Name
	$url= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
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
	$LanderID = file_get_contents($file);
	$file = $basepath . $LanderID . '-pixel.dat';
	$trackingpixels = file_get_contents($file);
	$file = $basepath . $LanderID . '-oid.dat';
	$OfferID = file_get_contents($file);

	$file = $basepath . $LanderID . '-textcount.dat';
	$textcount = file_get_contents($file);
	$file = $basepath . $LanderID . '-linkcount.dat';
	$linkcount = file_get_contents($file);
	$file = $basepath . $LanderID . '-imagecount.dat';
	$imagecount = file_get_contents($file);


	$text = array();
	$images = array();

	for ($i=0; $i<$textcount; $i++) {
		$file = $basepath . $LanderID . "-text-{$i}.dat";
		$temptext = file_get_contents($file);
		array_push($text, $temptext);
	}

	for ($i=0; $i<$imagecount; $i++) {
		$file = $basepath . $LanderID . "-img-{$i}.dat";
		$tempimage = file_get_contents($file);
		$tempimage = "https://kowboykit.com/u-images/". $tempimage;
		array_push($images, $tempimage);
	}

	//Get and sanitize querystring data
	if (isset($_GET['s1'])) { $s1= $_GET['s1']; } else { $s1 = '';}
	$s1= preg_replace("/[^A-Za-z0-9 ]/", '', $s1);
	if (isset($_GET['s4'])) { 	$s4= $_GET['s4']; } else { $s4 = '';}
	$s4= preg_replace("/[^A-Za-z0-9 ]/", '', $s4);
	if (isset($_GET['s3'])) { 	$s3= $_GET['s3']; } else { $s3 = '';}
	$s3= preg_replace("/[^A-Za-z0-9 ]/", '', $s3);

	// Retrieve Lander info
	$ch = curl_init();


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
              'ip'=> $_SERVER['REMOTE_ADDR'] ,
              'referer'=> $referer ,
              'safe'=> 1 ,
              'browser'=> $user_browser ,
              'os'=> $user_os ,
              'session'=> $sesh ,
              'cookie'=> $cookie ,
              's1'=> $s1 ,
              's3'=> $s3 ,
              's4'=> $s4);

	$data = http_build_query($da);
	curl_setopt($ch, CURLOPT_URL, "https://kowboykit.com/json/lander-json.php");
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

	if (!file_exists($zfile)) {

		$link = "https://www.kowboykit.com/admin/add-lander.php?ref=" . $url;
		header('Location: ' . $link, true, 301);
		exit();

	}
	$protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';

	$step1link = $protocol . "://" . $_SERVER["SERVER_NAME"] . "/exit.php?s1=" . $s1 . "&l=" . $LanderID . "&s2=" . $clickid . "&s3=" . $s3 . "&s4=" . $s4;

	$links = array();
	for ($i=0; $i<$linkcount; $i++) {
		$templink = $protocol . "://" . $_SERVER["SERVER_NAME"] . "/exit.php?s1=" . $s1 . "&l=" . $LanderID . "&s2=" . $clickid . "&s3=" . $s3 . "&s4=" . $s4 . "&link=" . $i;
		array_push($links, $templink);
	}

	$_SESSION["sesh"] = 1;

	echo $trackingpixels;

?>
