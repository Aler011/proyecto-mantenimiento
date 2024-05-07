<?php
if ($_GET['searchBox'] !== '' && $_GET['sortSelect'] !== '') {
	$text = $_GET['searchBox'];
	$selectOption = $_GET['sortSelect'];
} elseif ($_GET['sortSelect'] !== '') {
	$text = '';
	$selectOption = $_GET['sortSelect'];
} else {
	die;
}

$category = '';
if ($_GET['category']) {
	$category = $_GET['category'];
}

//se valida que tipo de opccion selecciono el usuario
if ($selectOption == 1) {
	$selectOption = "ORDER BY date DESC";
} elseif ($selectOption == 2) {
	$selectOption = "ORDER BY title ASC";
} elseif ($selectOption == 3) {
	$selectOption = "ORDER BY description ASC";
} elseif ($selectOption == 4) {
	$selectOption = "ORDER BY date ASC";
}
// Se obtienen los datos del modelo:
require_once("../models/rssReader_model.php");
$feed = new rssReaderModel();

$pagina_actual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$registros_por_pagina = 10;
$total_registros = $feed->get_total_items_by_search($text);
$total_paginas = ceil($total_registros / $registros_por_pagina);
$offset = ($pagina_actual - 1) * $registros_por_pagina;

$items = $feed->search_items_and_sort($text, $selectOption, $category, $offset, $registros_por_pagina);
unset($feed);

if (!$items) {
	echo "<h1>No tenemos noticias que mostrarte</h1>";
	echo "<h3>Parece ser que no hemos conseguido encontrar lo que querias.</h3>";
	die;
} else {
	// Si no hay un error se llama a la vista:
	require_once('../views/rss_reader.php');

	echo '<nav aria-label="Page navigation example">';
	echo '  <ul class="pagination">';
	echo '    <!-- Botón "Anterior" -->';
	echo '    <li class="page-item ' . (($pagina_actual <= 1) ? 'disabled' : '') . '">';
	echo '      <a class="page-link" href="#" onclick=\'loadPhp("controllers/rss_sort.php?searchBox='.$text.'&sortSelect='.$selectOption.'&category='.$category.'&page=' . ($pagina_actual - 1) . '"); return false;\' aria-label="Previous">';
	echo '        <span aria-hidden="true">&laquo;</span>';
	echo '      </a>';
	echo '    </li>';
	
	echo '    <!-- Enlaces de páginas -->';
	for ($i = 1; $i <= $total_paginas; $i++) {
		echo '      <li class="page-item ' . (($i == $pagina_actual) ? 'active' : '') . '">';
		echo '        <a class="page-link" href="#" onclick=\'loadPhp("controllers/rss_sort.php?searchBox='.$text.'&sortSelect='.$selectOption.'&category='.$category.'&page=' . $i . '"); return false;\'>' . $i . '</a>';
		echo '      </li>';
	}
	
	echo '    <!-- Botón "Siguiente" -->';
	echo '    <li class="page-item ' . (($pagina_actual >= $total_paginas) ? 'disabled' : '') . '">';
	echo '      <a class="page-link" href="#" onclick=\'loadPhp("controllers/rss_sort.php?searchBox='.$text.'&sortSelect='.$selectOption.'&category='.$category.'&page=' . ($pagina_actual + 1) . '"); return false;\' aria-label="Next">';
	echo '        <span aria-hidden="true">&raquo;</span>';
	echo '      </a>';
	echo '    </li>';
	echo '  </ul>';
	echo '</nav>';
}

