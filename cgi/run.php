<?php

session_start();
include_once('common.php');

db_init();

date_default_timezone_set("Asia/Kolkata");

$size = $_POST['size'];

for ($i = 0; $i < $size; $i++) {
  // add record
  insert_row('samples',
    array(
	  'value' => rand(1, 10000),
	  'created_at' => date('Y-m-d H:i:s'),
    )
  );
  // sleep for a rand number of seconds
  //sleep(rand(1, 3));
  sleep(1);
}

redirect('/index.php');
