<?php
if (!isset($_COOKIE['urls'])) {
    die;
}


function almacenarNoticias($urls) {
    require_once("rss_storage.php");
    
    // Procesa cada URL
    foreach ($urls as $url) {
        rss_storage(trim($url));
    }
}

// Verifica si se ha solicitado la actualización de noticias
if (isset($_GET['actualizar']) && $_GET['actualizar'] == 'true') {
    $urls = $_COOKIE['urls']; // Se guardan las URL.
    $urls = str_replace('|', PHP_EOL, $urls);
    $urls = explode(PHP_EOL, $urls);
    
    almacenarNoticias($urls); // Almacenar las noticias
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

require_once("../models/rssReader_model.php");
$feed = new rssReaderModel();
$items = $feed->get_items();
unset($feed);

if (!$items) {
    echo "<p class='msg-title-noticias'>No hay noticias por mostrar</p>";
    echo "<p class='msg-body-noticias'>Añade nuevos feeds desde la pestaña correspondiente</p>";
    die;
} else {
    // Si no hay un error se llama a la vista:
    require_once('../views/rss_reader.php');
}
?>
/*
	if (!isset($_COOKIE['urls'])) {
		die;
	}
	$urls = $_COOKIE['urls']; // Se guardan las url de la cookie.

	require_once("rss_delete.php"); // Se elimina la base de datos.
	require_once("rss_storage.php");

	$urls = str_replace('|', PHP_EOL, $urls);
	$urls = explode(PHP_EOL, $urls);
	require_once("cookies.php"); // Se genera de nuevo la cookie.

	foreach ($urls as $url) {
		rss_storage(trim($url));
	}

	require_once("rss_reader.php");
*/
