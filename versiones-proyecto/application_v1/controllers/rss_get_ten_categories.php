<?php
// Se obtienen los datos del modelo:
require_once("../models/rssReader_model.php");
$feed = new rssReaderModel();

// Obtener los primeros diez elementos con categoría:
$firstTenCategories = $feed->get_first_ten_categories();
unset($feed);

if (!$firstTenCategories) {
	echo "<h6>Sin categorías...</h6>";
	die;
} else {
	$arrayCategories = array();
	foreach ($firstTenCategories as $item) {
		if ($item["categories"]) {
			array_push($arrayCategories, ucwords($item["categories"]));
		}
	}
	$arrayCategories = array_unique($arrayCategories);
	sort($arrayCategories);

	// Mostrar el enlace "Mostrar todas las categorías":
	echo '<a href="rss_get_categories">Mostrar todas las categorías</a>';

	// Si no hay un error, se llama a la vista:
	require_once('../views/rss_categories_reader.php');
}
