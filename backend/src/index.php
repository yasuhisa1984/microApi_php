<?php

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

// CORS対応
$app->add(function (Request $request, $handler) {
    $response = $handler->handle($request);
    return $response->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization');
});

// ルーティングの読み込み
(require __DIR__ . '/routes.php')($app);


// OpenAPIのエンドポイント
$app->get('/openapi', function (Request $request, Response $response) {
    // OpenAPIの定義ファイルのパスを指定
    $openapiFile = __DIR__ . '/openapi.yaml';

    // ファイルが存在するか確認
    if (!file_exists($openapiFile)) {
        // ファイルが見つからない場合は404を返す
        $response->getBody()->write('OpenAPI definition not found.');
        return $response->withStatus(404);
    }

    // OpenAPIファイルの内容を読み込む
    $yamlContent = file_get_contents($openapiFile);

    // YAMLをJSONに変換
    try {
        $openapiArray = yaml_parse($yamlContent);
        $jsonContent = json_encode($openapiArray, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } catch (Exception $e) {
        $response->getBody()->write('Failed to parse OpenAPI YAML: ' . $e->getMessage());
        return $response->withStatus(500);
    }

    // Content-Typeをapplication/jsonに設定してJSON形式で返す
    $response->getBody()->write($jsonContent);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
