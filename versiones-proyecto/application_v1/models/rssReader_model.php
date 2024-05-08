<?php
require_once("../db/mariaDB.php");
class rssReaderModel
{
	private $db;
	private $items;

	public function __construct()
	{
		$this->db = MariaDBConnection::connect();
		$this->items = array();
	}

    // Método modificado para soportar paginación:
		public function get_items($offset, $limit) {
        $sql = "SELECT * FROM feed ORDER BY date DESC LIMIT $limit OFFSET $offset;";
        $query = $this->db->query($sql);
        while ($rows = $query->fetch_assoc()) {
            $this->items[] = $rows;
        }
      return $this->items;
		}

    // Método nuevo para obtener el total de registros:
    public function get_total_items() {
        $sql = "SELECT COUNT(*) as total FROM feed;";
        $result = $this->db->query($sql);
        $data = $result->fetch_assoc();
        return $data['total'];
    }

	// Método nuevo para obtener el total de registros para una busqueda por texto:
	public function get_total_items_by_search($text) {
        $sql = "SELECT COUNT(*) as total FROM feed WHERE (title LIKE '%" . $text . "%' OR description LIKE '%" . $text . "%');";
        $result = $this->db->query($sql);
        $data = $result->fetch_assoc();
        return $data['total'];
    }

	// Buscar las noticias/artículos de la DB:
	public function search_items($text, $offset, $limit) {
		$sql = "SELECT * FROM feed WHERE (title LIKE '%" . $text . "%' OR description LIKE '%" . $text . "%') ORDER BY date DESC LIMIT $limit OFFSET $offset;";
		$query = $this->db->query($sql);
		while ($rows = $query->fetch_assoc()) {
			$this->items[] = $rows;
		}
		return $this->items;
	}

	// Buscar las noticias/artículos de la DB de una categoría:
	public function search_items_by_category($category, $offset, $limit) {
    $sql = "SELECT * FROM feed WHERE categories LIKE '%" . $category . "%' ORDER BY date DESC LIMIT $limit OFFSET $offset;";
    $this->items = [];
    $query = $this->db->query($sql);
    while ($rows = $query->fetch_assoc()) {
        $this->items[] = $rows;
    }
    return $this->items;
	}

	//Método Nuevo para Obtener el Total de Artículos por Categoría
	public function get_total_items_by_category($category) {
    $sql = "SELECT COUNT(*) as total FROM feed WHERE categories LIKE '%" . $category . "%';";
    $result = $this->db->query($sql);
    $data = $result->fetch_assoc();
    return $data['total'];
	}

	public function search_items_and_sort($text, $selectOption, $category, $offset, $limit) {
		$sql = '';
		if (!$text && !$category) {
			$sql = "SELECT * FROM feed ";
		} else {
			$sql = "SELECT * FROM feed WHERE (title LIKE '%" . $text . "%' OR
			description LIKE '%" . $text . "%') ";
		}

		if ($category && $category !== '') {
			$sql = $sql . 'AND categories LIKE ' . "'%{$category}%'" . $selectOption . " LIMIT $limit OFFSET $offset;";
		} else {
			$sql = $sql . $selectOption . " LIMIT $limit OFFSET $offset;";
		}
		$query = $this->db->query($sql);
		while ($rows = $query->fetch_assoc()) {
			$this->items[] = $rows;
		}
		return $this->items;
	}

	public function get_categories() {
		$sql = "SELECT categories FROM feed;";
		$query = $this->db->query($sql);
		while ($rows = $query->fetch_assoc()) {
			$this->items[] = $rows;
		}
		return $this->items;
	}

	// Almacena en la BD los items:
	public function set_item($title, $date, $description, $permalink, $categories, $image) {
		$sql = "INSERT INTO feed (title, date, description, permalink, categories, image)
							VALUES ('" . $title . "', '" . $date . "', '" . $description . "', '" .
							$permalink . "', '" . $categories . "', '" . $image . "')";
		if ($this->db->query($sql)) {
			return true;
		}
		return false;
	}

	// Elimina los items dentro de la BD:
	public function delete_items() {
		$sql = "DELETE FROM feed";
		if ($this->db->query($sql)) {
			return true;
		}
		return false;
	}
        
        public function get_items_by_category_first_letter($letter) {
        $sql = "SELECT * FROM feed WHERE LEFT(categories, 1) = '$letter' ORDER BY date DESC;";
  
        $query = $this->db->query($sql);
        while ($rows = $query->fetch_assoc()) {
        $this->items[] = $rows;
        }
        return $this->items;
 }
        
}