<?php
$experiments = Array(
	"Strömungsmechanik / Blutkreislauf" => Array(
		"Blut",
		"Serienschaltung",
		"Blutkreislauf",
		"Herz",
		"Paraffinöl",
		"Parallelschaltung",
		"Strömungsmechanik",
		"Aorta",
		"Kolbenpumpe",
		"Strömung",
		"Druck",
		"Windkessel",
		"Verschlussventil",
		"Blutgefäße",
		"Ventilklappe",
		"Rohre",
		"Herzklappen",
		"Modell",
	),
	"Elektrische Leitung / Ionenleitung" => Array(
		"Elektrische \n Stromstärke",
		"Leitungseigenschaften",
		"Intrazelluläre \n Flüssigkeiten",
		"geometrische \n Faktoren",
		"Elektrische \n Spannung",
		"Ionenkanäle",
		"Extrazelluläre \n Flüssigkeiten",
		"Ohmscher \n Widerstand",
		"Zellmembran",
		"Stromkreis",
		"Diode",
		"Elektrolyt",
		"menschlicher Körper",
	),
	"Demo" => Array(
		"Echsen",
		"Land",
		"Reptilien",
		"Eier",
	),
);
$cssconfig = Array(
	"Strömungsmechanik / Blutkreislauf" => Array(
		"height" => 32,
	),
	"Elektrische Leitung / Ionenleitung" => Array(
		"height" => 48,
	),
	"Demo" => Array(
		"height" => 32,
	),
	"" => Array(),
);
$maxexp = 0;
foreach ($experiments as $key => $val) $maxexp = max($maxexp, count($val));

if (isset($_GET["experiment"])) {
	$experiment = $experiments[$_GET["experiment"]];
	$experiment_name = $_GET["experiment"];
} else {
	$experiment = Array();
	$experiment_name = "";
}
if (isset($_GET["session"])) {
	$session = $_GET["session"];
} else if (isset($_GET["newsession"])) {
	$session = $_GET["newsession"] . "_" . time();
} else {
	$session = "";
}

$session_filename = base64_encode("{$experiment_name}-{$session}");
$css = $cssconfig[$experiment_name];

if (isset($_GET["restore"])) {
	copy("finished/{$session_filename}", "sessions/{$session_filename}");
	$doLayout = 1;
}

?>