<?php

$session = $_POST["session"];
$data = $_POST["data"];

$session_filename = base64_encode($session);

if (isset($_POST["finish"])) {
	file_put_contents("finished/{$session_filename}", json_encode($data));
	unlink("sessions/{$session_filename}");
} else {
	file_put_contents("sessions/{$session_filename}", json_encode($data));
}

?>OK