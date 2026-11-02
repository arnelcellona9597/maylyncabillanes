<?php
// Local dev router (php -S localhost:8765 router.php): mirrors the .htaccess blocks.
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (preg_match('#^/(\.|src/|router\.php|deploy)#', $path)) {
    http_response_code(404);
    exit('Not found');
}
return false;
