<?php
	$i = 0;
	$lastElement = end($items);
	// Aquí se accesa a los items de la base de datos para imprimirlos en pantalla.
	foreach ($items as $item) {
		$title = $item['title'];
		$description = $item['description'];
		$date = $item['date'];
		$link = $item['permalink'];
		$image = $item['image'];
		$categories = $item['categories'];

		if ($i == 0) {
			if ($item == $lastElement) {
				echo "<div class='col-lg-6'>";
			} else {
				echo "<div class='card-group'>";
			}
		}

		echo "
		<div class='card mb-4'>
			<div style='overflow: hidden; width: 100%; padding-top: 70%; position: relative;'>
				<img class='card-img-top' src='{$image}' alt='Image New' style='position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;' />
			</div>
			<div class='card-body'>
				<div class='small text-muted'>{$date}</div>
				<a href='{$link}'><h2 class='card-title cut-title h4'>{$title}</h2></a>
				<p class='card-text cut-text'>{$description}</p>";
				if ($categories) {
					echo "<div class='d-flex justify-content-center'><a onclick='searchCategory(\"{$categories}\");'><div class='btn badge bg-primary bg-gradient mb-2' style='width: 200px;'>{$categories}</div></a></div>";
				}
		echo "
			</div>
			<div class='card-footer bg-transparent border-top-0'>
				<div class='d-flex justify-content-center'><a class='btn btn-primary' href='{$link}' style='width: 100%;'>Leer más...</a></div>
			</div>
		</div>";
		if ($i == 1) {
			echo '</div>';
			$i = 0;
		} else {
			$i++;
		}
	}
	unset($arr_ctgs);
