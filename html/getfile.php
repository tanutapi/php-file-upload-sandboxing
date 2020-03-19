<?php

if (!isset($_GET["id"])) {
  http_response_code(404);
  die();
}

$uuid = $_GET["id"];

$mysqli = new mysqli("database_server", "webapp", "qwerty", "webapp");
if ($mysqli->connect_errno) {
  http_response_code(500);
  die();
}

$uuid = $mysqli->real_escape_string($uuid);

if ($result = $mysqli->query("SELECT * from `uploads` WHERE `uuid`='".$uuid."'")) {
  if ($file = $result->fetch_array()) {
    header("Content-Description: File Transfer");
    header("Content-Type: ".$file["mime"]);
    header("Content-Disposition: attachment; filename=\"".$file["filename"]."\"");
    header("Expires: 0");
    header("Cache-Control: must-revalidate");
    header("Pragma: public");
    header("Content-Length: ".$file["size"]);
    readfile("/uploads/".$file["uuid"]);
  } else {
    http_response_code(404);
    die();
  }
}
?>