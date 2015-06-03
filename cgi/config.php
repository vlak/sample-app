<?php

global $db_config;

$host = getenv('DB_PORT_3306_TCP_ADDR');
if (empty($host)) $host = 'localhost';

$port = getenv('DB_PORT_3306_TCP_PORT');
if (empty($port)) $port = '3306';

$username = getenv('DB_ENV_MYSQL_USER');
if (empty($username)) $username = 'root';

$password = getenv('DB_ENV_MYSQL_PASSWORD');
if (empty($password)) $password = 'admin';


// DB configuration settings
$db_config = array(
  'host' => $host,
  'port' => $port,
  'username' => $username,
  'password' => $password,
  'db_name' => 'sample-app',
);

//var_dump($db_config);
//var_dump($_ENV);