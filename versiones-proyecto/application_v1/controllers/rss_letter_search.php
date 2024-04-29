<?php
	if ($_GET['letter'] !== '') {
	// Se obtiene el parámetro de la categoría:
	$parameter = $_GET['letter'];
} else {
	die;
}

	// Se obtienen los datos del modelo:
	require_once("../models/rssReader_model.php");
	$feed = new rssReaderModel();
	$items = $feed->get_items_by_category_first_letter($parameter);
	unset($feed);

	if (!$items) {
		echo "<h1>No tenemos noticias que mostrarte</h1>";
		echo "<h3>Parece ser que no hemos conseguido encontrar lo que querias.</h3>";
		die;
	} else {
		// Si no hay un error se llama a la vista:
		require_once('../views/rss_dictionary_categories.php');
	}