<?php
define("SERVER", 'localhost');
define("USER", 'root');
define("PASSWORD", '');
define("DB", 'film_loc');

$conn = new mysqli(SERVER, USER, PASSWORD, DB);
if (!$conn)
    die('Failed to connect to database: NO INTERNET');
