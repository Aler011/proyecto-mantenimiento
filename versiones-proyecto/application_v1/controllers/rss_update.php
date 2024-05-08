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
$pagina_actual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$registros_por_pagina = 10;

$total_registros = $feed->get_total_items();
$total_paginas = ceil($total_registros / $registros_por_pagina);
$offset = ($pagina_actual - 1) * $registros_por_pagina; // Podrías poner un límite por defecto
// Llamar al método get_items con los parámetros adecuados
$items = $feed->get_items($offset, $registros_por_pagina);
unset($feed);

if (!$items) {
    echo "<p class='msg-title-noticias'>No hay noticias por mostrar</p>";
    echo "<p class='msg-body-noticias'>Añade nuevos feeds desde la pestaña correspondiente</p>";
    die;
} else {
    // Si no hay un error se llama a la vista:
    require_once('../views/rss_reader.php');
	echo '<nav aria-label="Page navigation example">';
    echo '  <ul class="pagination">';
    echo '    <!-- Botón "Anterior" -->';
    echo '    <li class="page-item ' . (($pagina_actual <= 1) ? 'disabled' : '') . '">';
    echo '      <a class="page-link" href="#" onclick=\'loadPhp("controllers/rss_reader.php?page=' . ($pagina_actual - 1) . '"); return false;\' aria-label="Previous">';
    echo '        <span aria-hidden="true">&laquo;</span>';
    echo '      </a>';
    echo '    </li>';
    
    echo '    <!-- Enlaces de páginas -->';
    for ($i = 1; $i <= $total_paginas; $i++) {
        echo '      <li class="page-item ' . (($i == $pagina_actual) ? 'active' : '') . '">';
        echo '        <a class="page-link" href="#" onclick=\'loadPhp("controllers/rss_reader.php?page=' . $i . '"); return false;\'>' . $i . '</a>';
        echo '      </li>';
    }
    
    echo '    <!-- Botón "Siguiente" -->';
    echo '    <li class="page-item ' . (($pagina_actual >= $total_paginas) ? 'disabled' : '') . '">';
    echo '      <a class="page-link" href="#" onclick=\'loadPhp("controllers/rss_reader.php?page=' . ($pagina_actual + 1) . '"); return false;\' aria-label="Next">';
    echo '        <span aria-hidden="true">&raquo;</span>';
    echo '      </a>';
    echo '    </li>';
    echo '  </ul>';
    echo '</nav>';
}
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
?>

