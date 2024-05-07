<?php
// Validar si se recibió el parámetro de categoría
if (empty($_GET['category'])) {
    die("Categoría no especificada.");
}

// Parámetros de categoría y paginación
$parameter = $_GET['category'];
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 10;  // Puedes ajustar este valor según tus preferencias

// Cargar el modelo
require_once("../models/rssReader_model.php");
$feed = new rssReaderModel();

// Calcular el número total de registros y páginas
$total_records = $feed->get_total_items_by_category($parameter);
$total_pages = ceil($total_records / $records_per_page);

// Calcular el desplazamiento para la consulta
$offset = ($page - 1) * $records_per_page;

// Obtener los artículos filtrados por categoría con paginación
$items = $feed->search_items_by_category($parameter, $offset, $records_per_page);
unset($feed);

// Comprobar si hay artículos
if (!$items) {
    echo "<h1>No tenemos noticias que mostrarte</h1>";
    echo "<h3>Parece ser que no hemos conseguido encontrar lo que querias.</h3>";
    die;
} else {
    // Incluir la vista para mostrar los artículos
    require_once('../views/rss_reader.php');

    // Generar controles de paginación
    /*
    echo "<div class='pagination'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='rss_search_category.php?category=$parameter&page=$i'>$i</a> ";
    }
    echo "</div>";
    */

    echo '<nav aria-label="Page navigation example">';
    echo '  <ul class="pagination">';
    echo '    <!-- Botón "Anterior" -->';
    echo '    <li class="page-item ' . (($page <= 1) ? 'disabled' : '') . '">';
    echo '      <a class="page-link" href="#" onclick=\'loadPhp("controllers/rss_search_category.php?category='.$parameter.'&page=' . ($page - 1) . '"); return false;\' aria-label="Previous">';
    echo '        <span aria-hidden="true">&laquo;</span>';
    echo '      </a>';
    echo '    </li>';
    
    echo '    <!-- Enlaces de páginas -->';
    for ($i = 1; $i <= $total_pages; $i++) {
        echo '      <li class="page-item ' . (($i == $page) ? 'active' : '') . '">';
        echo '        <a class="page-link" href="#" onclick=\'loadPhp("controllers/rss_search_category.php?category='.$parameter.'&page=' . $i . '"); return false;\'>' . $i . '</a>';
        echo '      </li>';
    }
    
    echo '    <!-- Botón "Siguiente" -->';
    echo '    <li class="page-item ' . (($page >= $total_pages) ? 'disabled' : '') . '">';
    echo '      <a class="page-link" href="#" onclick=\'loadPhp("controllers/rss_search_category.php?category='.$parameter.'&page=' . ($page + 1) . '"); return false;\' aria-label="Next">';
    echo '        <span aria-hidden="true">&raquo;</span>';
    echo '      </a>';
    echo '    </li>';
    echo '  </ul>';
    echo '</nav>';


}
?>