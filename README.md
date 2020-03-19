# PHP file upload with Sandboxing Technique #

This approach will save the uploaded files into the folder outside the Apache path. With this method, the HTTP server will never parse the uploaded file as a scripting language. The uploaded file will be renamed to a unique string and other meta-data, such as MIME, file size, filename, will be saved in the database.

Retrieving file back is done by the getfile.php. It will set the headers and return the file content to the user.

## Running with docker-compose ##
`docker-compose up`
Access the webapp at http://localhost, the debuging phpmyadmin are running at http://localhost:8080

