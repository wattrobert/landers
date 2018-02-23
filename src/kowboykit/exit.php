<?php

//ini_set('display_errors', 1); // set to 0 for production version
//error_reporting(E_ALL);

if ($_GET['l']) {

	// FORMAT QUERYSTRINGS

	$lander = $_GET["l"];
	$lander = preg_replace('/\D/', '', $lander);
	$link = $_GET["link"];
	$link = preg_replace('/\D/', '', $link);
	$offerid = $_GET["o"];
	$offerid = preg_replace('/\D/', '', $offerid);
	$variant= $_GET['v'];
	$variant= preg_replace('/\D/', '', $variant);


	$s1= $_GET['s1'];
	$s1= preg_replace("/[^A-Za-z0-9 ]/", '', $s1);
	$s2= $_GET['s2'];
	$s2= preg_replace("/[^A-Za-z0-9 ]/", '', $s2);
	$s3= $_GET['s3'];
	$s3= preg_replace("/[^A-Za-z0-9 ]/", '', $s3);
	$s4= $_GET['s4'];
	$s4= preg_replace("/[^A-Za-z0-9 ]/", '', $s4);

	$ip= $_SERVER['REMOTE_ADDR'];

	// GET BROWSER AND OS INFO

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

	// GET LANDER INFO

	$basedir = $_SERVER['DOCUMENT_ROOT'] . '/../data/';
	$file = $basedir . $lander . '.dat';
	$datalocation = $basedir . file_get_contents($file) . '.dat';
	$landerdata = file_get_contents($datalocation);
	$landerdata = json_decode($landerdata);
	$masking = $landerdata->{'masking'};
	$key = $landerdata->{'lander_key'};

	// REPORT

	$da = array('lander'=> $lander,
                'ip'=> $_SERVER['REMOTE_ADDR'],
                'referer'=> $referer,
                'safe'=> "0",
			    'offer'=> $offerid,
                'browser'=> $user_browser,
                'os'=> $user_os,
                'session'=> $sesh,
                'variant'=> $variant,
                's1'=> $s1,
                's2'=> $s2,
                's3'=> $s3,
                's4'=> $s4,
                'key' => $key);

	$data = http_build_query($da);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://kowboykit.com/api/click/track/exit/");
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

	$offers = $landerdata->{'offer_package'};
	foreach ($offers as $offer) {
		if ($offer->{'id'} == $offerid) {
			$olink = $offer->{'links'}[$link];
			$subtag = $offer->{'subtag'};
			$prgt = $offer->{'programtype'};
			$first_in_link = $offer->{'first_in_link'};
			$leading_char = $offer->{'leading_char'};
			$show_one = $offer->{'show_one'};
		}
	}

	//FORMAT LINKCODE AND REDIRECT

	if ($first_in_link) {
		$first = "";
	} else {
		$first = $leading_char . $subtag . $show_one . "=";
	}

	$link = $first . $s1 . "&" . $subtag . "2=" . $s2 . "&" . $subtag . "3=" . $s3 . "&" . $subtag . "4=" . $s4;
	$link = $olink . $link;

	if ($masking == '0') {

		header('Location: ' . $link, true, 301);
		exit();

	} else {

		$pixels = $landerdata->{'pixel_package'};
		$fire_pixel = "";
		foreach ($pixels as $pixel) {
			if ($pixel->{'type'} == 1) {
				$content = $pixel->{'content'};
				$fire_pixel = "{$fire_pixel}\r\n{$content}";
			}
		}

		echo "<html><head><meta name='robots' content='none'><title>Redirect</title>" . $fire_pixel . "</head><body><h3></h3><script>window.location.href='" . $link . "'</script></body></html>";
	}

}




?>