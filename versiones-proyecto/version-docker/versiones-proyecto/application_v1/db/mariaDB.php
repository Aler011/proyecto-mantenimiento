<?php

class MariaDBConnection {
  public static function connect() {
    // Read environment variables for a more secure approach
    $host = getenv('MARIADB_HOST') ?: 'mariadb';
    $username = getenv('MARIADB_USER') ?: 'root';
    $password = getenv('MARIADB_PASSWORD') ?: 'hola';
    $database = getenv('MARIADB_DATABASE') ?: 'rssFeed';

    $connection = new mysqli($host, $username, $password, $database);

    if ($connection->connect_error) {
      die("Connection failed: " . $connection->connect_error);
    }

    // Set character encoding to UTF-8 for proper handling of characters
    $connection->query("SET NAMES 'utf8'");

    return $connection;
  }
}
