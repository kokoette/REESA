<?php
if(isset($_ENV["PHP_ENV"])) {
  $dbserver = getenv("DB_SERVER");
  $dbuser = getenv("DB_USER");
  $dbpass = getenv("DB_PASS");
  $dbname = getenv("DB_NAME");

  define("DB_SERVER", $dbserver);
  define("DB_USER", $dbuser);
  define("DB_PASS", $dbpass);
  define("DB_NAME", $dbname);
}else {
  define("DB_SERVER", "127.0.0.1");
  define("DB_USER", "root");
  define("DB_PASS", "");
  define("DB_NAME", "reesa");
}
?>