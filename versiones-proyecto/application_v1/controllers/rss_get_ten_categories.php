<?php
// Se obtienen los datos del modelo:
require_once("../models/rssReader_model.php");
$feed = new rssReaderModel();

// Obtener los primeros diez elementos con categoría:
$firstTenCategories = $feed->get_ten_categories();
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

	// Si no hay un error, se llama a la vista:
	require_once('../views/rss_categories_reader.php');
}
