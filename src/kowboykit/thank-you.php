<html>
<head>
	<title>Thank You!</title>
	<?php
	if (isset($_GET["event"])) { $type = $_GET["event"]; } else { $type = ""; }
	switch($type) {
		Case "":
			$basedir = $_SERVER['DOCUMENT_ROOT'] . '/../data/';
			$lander = $_GET["l"];
			$lander = preg_replace('/\D/', '', $lander);
			$data = $basedir . $lander . '.dat';
			$datalocation = file_get_contents($data);
			$landerdata = file_get_contents($basedir . $datalocation . '.dat');
			$landerdata = json_decode($landerdata);

			$pixels = $landerdata->{'pixel_package'};
			$fire_pixel = "";
			foreach ($pixels as $pixel) {
				if ($pixel->{'type'} == 2) {
					$content = $pixel->{'content'};
					$fire_pixel = "{$fire_pixel}\r\n{$content}";
				}
			}


			$replace = "##npprice##";
			if (isset($_GET["amount"])) { $amount = $_GET["amount"]; } else { $amount = 5.00; }
			$data = "&url={$_SERVER['HTTP_HOST']}&cd[currency]=USD&cd[value]=" . $amount;
			$fire_pixel = str_replace($replace, $data, $fire_pixel);

			echo $fire_pixel . "\r\n";
		break;

		Case "lead":

			$basedir = $_SERVER['DOCUMENT_ROOT'] . '/../data/';
			$lander = $_GET["l"];
			$lander = preg_replace('/\D/', '', $lander);
			$data = $basedir . $lander . '.dat';
			$datalocation = file_get_contents($data);
			$landerdata = file_get_contents($basedir . $datalocation . '.dat');
			$landerdata = json_decode($landerdata);

			$pixels = $landerdata->{'pixel_package'};
			$fire_pixel = "";
			foreach ($pixels as $pixel) {
				if ($pixel->{'type'} == 3) {
					$content = $pixel->{'content'};
					$fire_pixel = "{$fire_pixel}\r\n{$content}";
				}
			}

			echo $fire_pixel . "\r\n";

		break;
	}
	?>
</head>
<body>
	Thank You!
</body>
</html>
