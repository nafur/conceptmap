<?php

function toCSV($data) {
	$s = "\"Time\";\"\";\"Action\";\"Source\";\"Destination\";\"from\";\"to\"\n";
	foreach ($data as $d) {
		$d[2] = utf8_decode($d[2]);
		$d[4] = utf8_decode($d[4]);
		if ($d[0] == "connect") {
			$s .= "\"{$d[1]}\";\"ms\";\"Connecting\";\"{$d[2]}\";\"{$d[4]}\"\n";
		} else if ($d[0] == "detach") {
			$s .= "\"{$d[1]}\";\"ms\";\"Disconnecting\";\"{$d[2]}\";\"{$d[4]}\"\n";
		} else if ($d[0] == "rename") {
			$d[6] = utf8_decode($d[6]);
			$d[7] = utf8_decode($d[7]);
			$s .= "\"{$d[1]}\";\"ms\";\"Renaming\";\"{$d[2]}\";\"{$d[4]}\";\"{$d[6]}\";\"{$d[7]}\"\n";
		}
	}
	return $s;
}
function loadAsCSV($filename) {
	$data = json_decode(file_get_contents($filename));
	return toCSV($data);
}
function startPre() {
	print("<html>\n<head>\n<meta charset=\"utf8\" />\n</head>\n<body>\n<pre>\n");
}
function stopPre() {
	print("</pre>\n</body>\n</html>\n");
}


if (!isset($_GET["type"])) die("no type given.");
$type = $_GET["type"];
if (!isset($_GET["folder"])) die("no folder given.");
$folder = $_GET["folder"];
if (strpos($folder, "/")) die("nice try...");
$download = isset($_GET["download"]);

if ($type === "single") {
	$file = $_GET["session"];
	$s = loadAsCSV($folder . "/" . base64_encode($file));
	if ($download) {
		header("Content-Type: application/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=\"" . $file . ".csv\"");
		print($s);
		exit();
	} else {
		startPre();
		print($s);
		stopPre();
	}
} else if ($type === "group") {
	$experiment = $_GET["experiment"];
	$tmpfile = tempnam(sys_get_temp_dir(), base64_encode($experiment));
	$tmpfile = "dots/tmp_" . base64_encode($experiment);
	$zip = new ZipArchive();
	if ($zip->open($tmpfile, ZIPARCHIVE::CREATE) !== true) {
		die("failed creating zip file.");
	}
	foreach (scandir($folder) as $file) {
		if (preg_match("/(.*)-(.*)/", base64_decode($file), $m)) {
			if ($m[1] == $experiment) {
				$zip->addFile("dots/{$file}", "{$m[2]}.dot");
				$zip->addFromString("{$m[2]}.csv", loadAsCSV("{$folder}/{$file}"));
			}
		}
	}
	$zip->close();
	header("Content-type: application/zip"); 
	header("Content-Disposition: attachment; filename=\"{$experiment}.{$folder}.zip\""); 
	readfile($tmpfile);
	unlink($tmpfile);
	
} else if ($type === "dot") {
	$session = $_GET["session"];
	$session_filename = base64_encode($session);
	if ($download) {
		header("Content-Type: application.dot; charset=utf-8");
		header("Content-Disposition: attachment; filename=\"" . $session . ".dot\"");
		print(file_get_contents("dots/{$session_filename}"));
		exit();
	}
	startPre();
	readfile("dots/{$session_filename}");
	stopPre();
}
