<?php

/**
 * PHPUnit Autoloader for GDImage Library
 * @author José Luis Quintana <quintana.io>
 */

date_default_timezone_set('America/Lima');

function loader($class) {
  $class = strtolower($class);
  $file = "src/gimage/$class.php";

  if (file_exists($file)) {
    require $file;
  }
}

spl_autoload_register('loader');
