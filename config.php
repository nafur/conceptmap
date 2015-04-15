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
		"Elektrische Stromstärke",
		"Leitungseigenschaften",
		"Intrazelluläre Flüssigkeiten",
		"Länge und Querschnittsfläche",
		"Elektrische Spannung",
		"Ionenkanäle",
		"Extrazelluläre Flüssigkeiten",
		"Ohmscher Widerstand",
		"Biologische Membran",
		"Zusammensetzung",
		"Diode",
		"Elektrolyt",
		"Leiter",
	),
);
$cssconfig = Array(
	"Strömungsmechanik / Blutkreislauf" => Array(
		"height" => 32,
	),
	"Elektrische Leitung / Ionenleitung" => Array(
		"height" => 48,
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
?>