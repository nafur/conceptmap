<?php

$session = $_GET["session"];

$session_filename = base64_encode($session);

header("Content-Type: application.dot");
header("Content-Disposition: attachment; filename=\"" . $session . ".dot\"");

print(file_get_contents("dots/{$session_filename}.dot"));
