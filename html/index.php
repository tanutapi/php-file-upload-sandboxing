<html>
  <head>
    <title>File upload demo</title>
    <style>
      h3 {
        color: red;
      }
      label {
        font-weight: bold;
      }
    </style>
  </head>
  <body>
    <h1>EGCO627 Web Application Penetration Testing</h1>
    <h2>File Upload</h2>
    <h3>Sandboxing Technique by <u>Tanut Apiwong</u> & <u>Nartdanai Muangniyom</u></h3>
    <p>This file was served with Apache HTTP Server from /var/www/html</p>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
      <label>Any file type are accepted</label><br>
      <input type="file" name="upload">
      <button type="submit" name="submit" value="submit">Upload to Server</button>
    </form>
    <hr>

    <h4>Files in the database</h4>
    <?php
      $mysqli = new mysqli("database_server", "webapp", "qwerty", "webapp");
      if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
      }

      // Create uploads table if it is not exist
      if (!$mysqli->query("SELECT 1 FROM `uploads`")) {
        $mysqli->query("CREATE TABLE IF NOT EXISTS `webapp`.`uploads` ( `id` INT NOT NULL AUTO_INCREMENT , `uuid` VARCHAR(64) NOT NULL , `filename` VARCHAR(128) NOT NULL , `mime` VARCHAR(64) NOT NULL , `size` INT NOT NULL , `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`), UNIQUE (`uuid`(64))) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;");
      }

      if ($result = $mysqli->query("SELECT `id`, `uuid`, `filename` FROM `uploads`")) {
        echo "<ul>\n";
        if ($result->num_rows == 0) {
          echo "<li>No file in the database</li>\n";
        }
        while ($upload = $result->fetch_array()) {
          echo "<li><a href='getfile.php?id=".$upload["uuid"]."'>".$upload["filename"]."</a></li>\n";
        }
        echo "</ul>\n";
      }
      $mysqli->close();
    ?>

    <h4>Files in the sandbox (/uploads)</h4>
    <?php
      if ($handle = opendir('/uploads')) {
        echo "<ul>\n";
        $cnt = 0;
        while (false !== ($entry = readdir($handle))) {
          if (substr($entry, 0, 1) != ".") {
            echo "<li>$entry</li>\n";
            $cnt++;
          }
        }
        if ($cnt == 0) {
          echo "<li>No file in the directory</li>\n";
        }
        echo "</ul>\n";
        closedir($handle);
      }
    ?>
  </body>
</html>