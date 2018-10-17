<?php

if(isset($_ENV["PHP_ENV"])) {
  define("DB_SERVER", $_ENV["DB_SERVER"]);
  define("DB_USER", $_ENV["DB_USER"]);
  define("DB_PASS", $_ENV["DB_PASS"]);
  define("DB_NAME", $_ENV["DB_NAME"]);
}else {
  define("DB_SERVER", "127.0.0.1");
  define("DB_USER", "root");
  define("DB_PASS", "");
  define("DB_NAME", "reesa");
}
?>
