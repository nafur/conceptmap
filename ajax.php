<?php

$session = $_POST["session"];
$data = $_POST["data"];

if (isset($_POST["finish"])) {
	file_put_contents("finished/{$session}", json_encode($data));
	unlink("sessions/{$session}");
} else {
	file_put_contents("sessions/{$session}", json_encode($data));
}

?>OK