<?php
	// Aquí se desarrolla la lógica para buscar los artículos del RSS en la base de datos.
	if (empty($_POST['searchtext'])) {
		die;
	}
	$text = $_POST['searchtext'];

	// Se obtienen los datos del modelo:
	require_once("../models/rssReader_model.php");
	$feed = new rssReaderModel();

	$pagina_actual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$registros_por_pagina = 10;
	$total_registros = $feed->get_total_items_by_search($text);
	$total_paginas = ceil($total_registros / $registros_por_pagina);
	$offset = ($pagina_actual - 1) * $registros_por_pagina;

	$items = $feed->search_items($text, $offset, $registros_por_pagina);

	if (!$items) {
		echo "<h1>No tenemos noticias que mostrar</h1>";
		echo "<h3>Parece ser que no hemos conseguido encontrar lo que querias.</h3>";
		die;
	} else {
		// Si no hay un error se llama a la vista:
		require_once('../views/rss_reader.php');

		echo '<nav aria-label="Page navigation example">';
		echo '  <ul class="pagination">';
		echo '    <!-- Botón "Anterior" -->';
		echo '    <li class="page-item ' . (($pagina_actual <= 1) ? 'disabled' : '') . '">';
		echo '      <a class="page-link" href="#" onclick=\'loadPhp("controllers/rss_search.php?searchtext='.$text.'&page=' . ($pagina_actual - 1) . '"); return false;\' aria-label="Previous">';
		echo '        <span aria-hidden="true">&laquo;</span>';
		echo '      </a>';
		echo '    </li>';
		
		echo '    <!-- Enlaces de páginas -->';
		for ($i = 1; $i <= $total_paginas; $i++) {
			echo '      <li class="page-item ' . (($i == $pagina_actual) ? 'active' : '') . '">';
			echo '        <a class="page-link" href="#" onclick=\'loadPhp("controllers/rss_search.php?searchtext='.$text.'&page=' . $i . '"); return false;\'>' . $i . '</a>';
			echo '      </li>';
		}
		
		echo '    <!-- Botón "Siguiente" -->';
		echo '    <li class="page-item ' . (($pagina_actual >= $total_paginas) ? 'disabled' : '') . '">';
		echo '      <a class="page-link" href="#" onclick=\'loadPhp("controllers/rss_search.php?searchtext='.$text.'&page=' . ($pagina_actual + 1) . '"); return false;\' aria-label="Next">';
		echo '        <span aria-hidden="true">&raquo;</span>';
		echo '      </a>';
		echo '    </li>';
		echo '  </ul>';
		echo '</nav>';
	}

