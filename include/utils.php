<?php

function loadData($file) {
	if (file_exists($file)) {
		return json_decode(file_get_contents($file));
	} else {
		return Array();
	}
}

?>