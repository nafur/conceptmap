<?php
$states = Array(
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
	"Modell"
);

function column($id) {
	return $id % 6;
}
function row($id) {
	return floor($id / 6);
}

?>