<?php

$session = $_POST["session"];
$data = $_POST["data"];

file_put_contents("sessions/{$session}", json_encode($data));

?>OK