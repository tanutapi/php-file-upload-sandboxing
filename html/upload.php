<?php

if (!isset($_POST["submit"]) OR !isset($_FILES["upload"]) OR !isset($_FILES["upload"]["name"]) OR empty($_FILES["upload"]["name"])) {
  die("no file submited");
}

$uuid = bin2hex(random_bytes(32));

$mysqli = new mysqli("database_server", "webapp", "qwerty", "webapp");
if ($mysqli->connect_errno) {
  printf("Connect failed: %s\n", $mysqli->connect_error);
  exit();
}

$source_filename = basename($_FILES["upload"]["name"]);
$target_filename = $uuid;
$target_path = "/uploads/".$uuid;
if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_path)) {
  $filesize = filesize($target_path);
  $mime = mime_content_type($target_path);
  $mysqli->query("INSERT INTO `uploads` (`uuid`, `filename`, `mime`, `size`) VALUES ('$uuid', '$source_filename', '$mime', $filesize)");
}

$mysqli->close();

header("Location: /");
?>