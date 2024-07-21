<?php

header("Content-Type: application/json");

register_shutdown_function(function () {
    var_dump(error_get_last());
    die();
});

spl_autoload_register(function ($class) {
    $patch = str_replace("\\", "/", $class.".php");

    if (file_exists($patch)) {
        require_once $patch;
    }

});

$action = $_GET["act"];
$method = $_GET["method"];
$class = "app\\controllers\\" . ucfirst($action) . "Controller";
$controller = new $class();
$response = $controller->$method($_REQUEST);
echo json_encode(['success' => true, 'rows' => $response], JSON_UNESCAPED_UNICODE);