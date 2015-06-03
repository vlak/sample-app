<?php

include_once('config.php');
global $con;

function db_init() {
  global $db_config;
  global $con;
  static $initialized = FALSE;

  if ($initialized) return;
  $con = mysql_connect($db_config['host'].':'.$db_config['port'], $db_config['username'], $db_config['password']);
  if (!$con) {
    die('Could not connect: ' . mysql_error());
  }
  //var_dump($db_config);
  //echo "-- db name: ".$db_config['db_name']."<br/>";
  mysql_select_db($db_config['db_name'], $con) or trigger_error(mysql_error()." in selecting ".$db_config['db_name']);
  $initialized = TRUE;
}

function db_close() {
  global $con;

  if ($con) mysql_close($con);
  $initialized = FALSE;
}

function get_rows($table, $where = NULL, $order = NULL) {
  global $con;

  $sql = "SELECT * FROM " . $table;
  if (isset($where)) {
    $sql .= " WHERE ";
    $first = TRUE;
    foreach ($where as $k => $v) {
      if (!$first) $sql .= " AND ";
      $sql .= $k." = '".$v."'";
      if ($first) $first = FALSE;
    }
  }
  if (isset($order)) {
    $sql .= " ".$order;
  }
  //echo $sql;
  $data = array();
  $result = mysql_query($sql, $con) or trigger_error(mysql_error()." in ".$sql);
  if (mysql_num_rows($result) == 1) {
    $data[] = mysql_fetch_array($result, MYSQL_ASSOC);
  }
  else {
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
      $data[] = $row;
    }
  }
  mysql_free_result($result);
  return $data;
}

function update_row($table, $obj) {
  global $con;

  date_default_timezone_set('Asia/Calcutta');
  $sql  = "UPDATE ".$table;
  $sql .= " SET ";
  foreach ($obj as $k => $v) {
    //$sql .= rtrim(implode(",", array_keys($obj)), ",");
    $sql .= $k."='".$v."',";
  }
  $sql = rtrim($sql, ",");
  $sql .= " WHERE id = '".$obj['id']."'";
  //echo $sql;
  $result = mysql_query($sql, $con);
  //mysql_free_result($result);
}

function insert_row($table, $obj) {
  global $con;

  date_default_timezone_set('Asia/Calcutta');
  $sql  = "INSERT INTO ".$table." (";
  $sql .= rtrim(implode(",", array_keys($obj)), ",");
  $sql = rtrim($sql, ",");
  $sql .= ") VALUES(";
  foreach ($obj as $k => $v) {
    $sql .= "'".$v."',";
  }
  $sql = rtrim($sql, ",");
  $sql .= ")";

  echo $sql;
  $result = mysql_query($sql, $con);
}

function delete_row($table, $where = NULL) {
  global $con;

  $sql = "DELETE FROM " . $table;
  if (isset($where)) {
    $sql .= " WHERE ";
    $first = TRUE;
    foreach ($where as $k => $v) {
      if (!$first) $sql .= " AND ";
      $sql .= $k." = '".$v."'";
      if ($first) $first = FALSE;
    }
  }

  //echo $sql;
  $result = mysql_query($sql, $con);
}

function redirect($url, $permanent = false) {
  if (headers_sent() === false) {
    $url = "http://".$_SERVER['HTTP_HOST'].$url;
    header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
  }

  exit();
}

?>