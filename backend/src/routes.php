<?php

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app) {
    // サンプルのGETエンドポイント
    $app->get('/api/hello', function (Request $request, Response $response) {
        $data = ['message' => 'Hello, World! this is test app'];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    });
};
