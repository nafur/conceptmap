<?php

$session = $_REQUEST["session"];
$data = $_POST["data"];

$session_filename = base64_encode($session);

function exportToDot($data) {
	$s = "digraph g {\n";
	foreach ($data as $k => $d) {
		list($from,$to) = split("###", $k);
		$from = str_replace("\"", "\\\"", $from);
		$to = str_replace("\"", "\\\"", $to);
		$d = str_replace("\"", "\\\"", $d);
		$s .= "\t\"{$from}\" -> \"{$to}\" [label=\"{$d}\"];\n";
	}
	$s .= "\tlabelloc = \"t\";\n";
	$s .= "\tlabel = \"{$session}\";\n";
	$s .= "}\n";
	return $s;
}

if (isset($_POST["asdot"])) {
	
	$s = exportToDot($data);
	file_put_contents("dots/{$session_filename}", $s);
	
	//exec("dot -Tpng -O dots/{$session_filename}.dot");
} else if (isset($_POST["todot"])) {
	$map = Array();
	foreach ($data as $d) {
		if ($d[0] == "connect") $map["{$d[2]}###{$d[4]}"] = "";
		else if ($d[0] == "rename") $map["{$d[2]}###{$d[4]}"] = $d[7];
		else if ($d[0] == "detach") unset($map["{$d[2]}###{$d[4]}"]);
	}
	$s = exportToDot($map);
	file_put_contents("dots/{$session_filename}", $s);
} else if (isset($_GET["rebuilddot"])) {
	$data = json_decode(file_get_contents("{$_REQUEST["folder"]}/{$session_filename}", $s));
	$map = Array();
	foreach ($data as $d) {
		if ($d[0] == "connect") $map["{$d[2]}###{$d[4]}"] = "";
		else if ($d[0] == "rename") $map["{$d[2]}###{$d[4]}"] = $d[7];
		else if ($d[0] == "detach") unset($map["{$d[2]}###{$d[4]}"]);
	}
	$s = exportToDot($map);
	file_put_contents("dots/{$session_filename}", $s);
} else {
	if (isset($_POST["finish"])) {
		file_put_contents("finished/{$session_filename}", json_encode($data));
		unlink("sessions/{$session_filename}");
	} else {
		file_put_contents("sessions/{$session_filename}", json_encode($data));
	}
}

?>OK