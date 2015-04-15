<?php

function dump($data) {
	foreach ($data as $d) {
		if ($d[0] == "connect") {
			print("{$d[1]} ms: Connecting {$d[2]} -> {$d[4]}\n");
		} else if ($d[0] == "detach") {
			print("{$d[1]} ms: Disconnecting {$d[2]} -> {$d[4]}\n");
		} else if ($d[0] == "rename") {
			print("{$d[1]} ms: Renaming {$d[2]} -> {$d[4]} from \"{$d[6]}\" to \"{$d[7]}\"\n");
		}
	}
}

	$file = $_GET["file"];
	$data = json_decode(file_get_contents("finished/{$file}"));
	if (isset($_GET["download"])) {
		header("Content-Type: text");
		header("Content-Disposition: attachment; filename=\"" . base64_decode($file) . "\"");
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