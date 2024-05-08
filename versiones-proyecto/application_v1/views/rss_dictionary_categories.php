<?php
// Aquí se accesa a los items de la base de datos para imprimirlos en pantalla.
foreach ($items as $item) {
    $title = $item['title'];
    $description = $item['description'];
    $date = $item['date'];
    $link = $item['permalink'];
    $categories = $item['categories'];

    echo "<div class='card w-125'>
            <div class='card-body'>
                <h5 class='card-title'>$title</h5>
                <p class='card-text'>$description</p>
                <div class='small text-muted'>$date</div>
                <div class='small text-muted'>$categories</div>
                <a href='$link' class='btn btn-primary'>Read more</a>
            </div>
        </div>";

}
?>
