<?php

$session = $_POST["session"];
$data = $_POST["data"];

$session_filename = base64_encode($session);

if (isset($_POST["asdot"])) {
	
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
	
	file_put_contents("dots/{$session_filename}", $s);
	
	//exec("dot -Tpng -O dots/{$session_filename}.dot");
	
} else {
	if (isset($_POST["finish"])) {
		file_put_contents("finished/{$session_filename}", json_encode($data));
		unlink("sessions/{$session_filename}");
	} else {
		file_put_contents("sessions/{$session_filename}", json_encode($data));
	}
}

?>OK