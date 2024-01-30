<?php

use Illuminate\Database\Capsule\Manager as Capsule;

include './vendor/autoload.php';


try {
    Dotenv\Dotenv::createUnsafeImmutable(__DIR__ )->load();

    $capsule = new Capsule;

    $capsule->addConnection([
        'driver' => 'mysql',
        'host' => getenv('DB_HOST'),
        'database' => getenv('DB_NAME'),
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'port' => getenv('DB_PORT'),
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ]);

    $capsule->setAsGlobal();

    $capsule->bootEloquent();
} catch (\Exception $exception){
    echo json_encode([
        "success" => false,
        "error" => 500,
        "data" => [
            "message" => $exception->getMessage()
        ]
    ]);
    die;
}


$controllerName = $methodName = null;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_REQUEST = json_decode(file_get_contents("php://input"), true);
}

$controllerName = "App\\Controllers\\".ucfirst($_REQUEST['controller'] ?? '');
$methodName = $_REQUEST['method'] ?? '';

if(!$controllerName || !$methodName) {
    echo json_encode([
        'code' => 500,
        'data' => [
            'message' => 'Wrong parameters'
        ]
    ]);
    die;
}

$controller = new $controllerName();

return $controller->$methodName();