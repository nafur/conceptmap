<?php
	if (isset($_SERVER['PHP_AUTH_DIGEST'])) {
		list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':' , base64_decode(substr($_SERVER['PHP_AUTH_DIGEST'], 6)));
	}
	$passwords = Array(  
		"rina" => "foobar",
		"nafur" => "abc"
	);
	if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($passwords[$_SERVER['PHP_AUTH_USER']]) || $passwords[$_SERVER['PHP_AUTH_USER']] != $_SERVER['PHP_AUTH_PW']) {
		header('WWW-Authenticate: Basic realm="conceptmap admin"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'Please authenticate!';
		$admin = false;
	} else $admin = true;
?>