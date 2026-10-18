<?php
// config/config.php

// __DIR__ devuelve la ruta física exacta de la carpeta donde está ESTE archivo:
// Por ejemplo: "C:/xampp/htdocs/miweb/config"

// Con dirname() subimos un nivel hacia la carpeta raíz del proyecto:
define('RUTA', dirname(__DIR__)); 

// Ahora RUTA vale exactamente: "C:/xampp/htdocs/miweb" (sin barra al final)