<?php

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Symfony\Component\Yaml\Yaml;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

// CORS対応


// ルーティングの読み込み
(require __DIR__ . '/routes.php')($app);



// OpenAPIのエンドポイント
$app->get('/openapi', function (Request $request, Response $response) {
    $openapiFile = __DIR__ . '/openapi.yaml';

    if (!file_exists($openapiFile)) {
        $response->getBody()->write('OpenAPI定義が見つかりません。');
        return $response->withStatus(404);
    }

    try {
        // SymfonyのYAMLパーサーを使用してパース
        $yamlContent = file_get_contents($openapiFile);
        $openapiArray = Yaml::parse($yamlContent);
        $jsonContent = json_encode($openapiArray, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        var_dump($jsonContent);
    } catch (Exception $e) {
        $response->getBody()->write('OpenAPI YAMLの解析に失敗しました: ' . $e->getMessage());
        return $response->withStatus(500);
    }

    return $response->withHeader('Content-Type', 'application/json')->write($jsonContent);
});

$app->run();
