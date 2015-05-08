<?php

function dump($data) {
	print("\"Time\";\"\";\"Action\";\"Source\";\"Destination\";\"from\";\"to\"\n");
	foreach ($data as $d) {
		$d[2] = utf8_decode($d[2]);
		$d[4] = utf8_decode($d[4]);
		if ($d[0] == "connect") {
			print("\"{$d[1]}\";\"ms\";\"Connecting\";\"{$d[2]}\";\"{$d[4]}\"\n");
		} else if ($d[0] == "detach") {
			print("\"{$d[1]}\";\"ms\";\"Disconnecting\";\"{$d[2]}\";\"{$d[4]}\"\n");
		} else if ($d[0] == "rename") {
			$d[6] = utf8_decode($d[6]);
			$d[7] = utf8_decode($d[7]);
			print("\"{$d[1]}\";\"ms\";\"Renaming\";\"{$d[2]}\";\"{$d[4]}\";\"{$d[6]}\";\"{$d[7]}\"\n");
		}
	}
}

	$folder = $_GET["folder"];
	if (strpos($folder, "/") !== FALSE) die("nope.");
	$file = $_GET["file"];
	$data = json_decode(file_get_contents($folder . "/" . base64_encode($file)));
	if (isset($_GET["download"])) {
		header("Content-Type: application/csv");
		header("Content-Disposition: attachment; filename=\"" . $file . ".csv\"");
		dump($data);
		exit();
	}
?>
<html>
<head>
	<meta charset="utf8" />
</head>
<body>
<pre>
<?php
	dump($data);
?>
</pre>
</body>
</html>