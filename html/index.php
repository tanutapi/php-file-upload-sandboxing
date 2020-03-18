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
    <h1>File Upload</h1>
    <h2>EGCO627 Web Application Penetration Testing</h2>
    <h3>Sandboxing Technique by <u>Tanut Apiwong</u> & <u>Nartdanai</u></h3>
    <p>This file was served with Apache HTTP Server from /var/www/html</p>
    <form action="" method="POST" enctype="multipart/form-data">
      <label>Any file type are accepted</label><br>
      <input type="file" name="upload">
      <button type="submit" name="submit">Upload to Server</button>
    </form>
    <hr>

    <h4>Files in the database</h4>
    <?php
      $mysqli = new mysqli("database_server", "webapp", "qwerty", "webapp");
      if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
      }
      if ($result = $mysqli->query("SELECT `id`, `filename` FROM `uploads`")) {
        echo $result->num_rows;
        echo "<ul>\n";
        if ($result->num_rows == 0) {
          echo "<li>No file in the database</li>\n";
        }
        while ($upload = $result->fetch_array()) {

        }
        echo "</ul>\n";
      } else {
        echo "No table in the database! Please upload one.";
      }
      $mysqli->close();
    ?>

    <h4>Files in the sandbox (/uploads)</h4>
    <?php
      if ($handle = opendir('/uploads')) {
        echo "<ul>\n";
        while (false !== ($entry = readdir($handle))) {
          if ($entry != "." && $entry != "..") {
            echo "<li>$entry</li>\n";
          }
        }
        echo "</ul>\n";
        closedir($handle);
      }
    ?>
  </body>
</html>