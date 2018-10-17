<?php
if(isset($_ENV["PHP_ENV"])) {
  print "in: ";
  define("DB_SERVER", getenv("DB_SERVER"));
  define("DB_USER", getenv("DB_USER"));
  define("DB_PASS", getenv("DB_PASS"));
  define("DB_NAME", getenv("DB_NAME"));
}else {
  print "out";
  define("DB_SERVER", "127.0.0.1");
  define("DB_USER", "root");
  define("DB_PASS", "");
  define("DB_NAME", "reesa");
}
?>