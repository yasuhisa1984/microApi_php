<?php

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app) {
    // サンプルのGETエンドポイント
    $app->get('/hello', function (Request $request, Response $response) {
        $response->getBody()->write('Hello, World!');
        return $response->withHeader('Content-Type', 'text/plain');
    });

    // OpenAPIの仕様書を返すエンドポイント
    $app->get('/openapi', function (Request $request, Response $response) {
        $spec = file_get_contents(__DIR__ . '/openapi.yaml');
        $response->getBody()->write($spec);
        return $response->withHeader('Content-Type', 'application/yaml');
    });
};
