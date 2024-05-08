<?php
require_once("../models/rssReader_model.php");
$feed = new rssReaderModel();

$pagina_actual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$registros_por_pagina = 10;

$total_registros = $feed->get_total_items();
$total_paginas = ceil($total_registros / $registros_por_pagina);
$offset = ($pagina_actual - 1) * $registros_por_pagina;

$items = $feed->get_items($offset, $registros_por_pagina);

if (!$items) {
    echo "<h1>No hay noticias que mostrar</h1>";
    echo "<h3>¡Intenta añadir nuevos Feeds de tus sitios favoritos!</h3>";
    die;
} else {
    require_once('../views/rss_reader.php');
    // Agregar controles de paginación aquí

    /*
    echo "<div class='pagination'>";
    for ($i = 1; $i <= $total_paginas; $i++) {
        echo "<a href='#' onclick='loadPhp(\"controllers/rss_reader.php?page=$i\"); return false;'>$i</a> ";
    }
    echo "</div>";
    */
    
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
?>
