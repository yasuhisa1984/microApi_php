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
    $app->get('/api/goodbye', function (Request $request, Response $response) {
        $data = ['message' => 'Goodbye, see you again!'];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // データベース接続とcustomerテーブルデータの取得
    $app->get('/api/customers', function (Request $request, Response $response) {
        $dsn = 'mysql:host=db;port=3306;dbname=sample';
        $username = 'app';
        $password = 'pass1234';

        try {
            $pdo = new PDO($dsn, $username, $password);
            $statement = $pdo->query('SELECT * FROM customer');
            $customers = [];
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $customers[] = $row;
            }
            $pdo = null; // 切断

            $response->getBody()->write(json_encode($customers));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (PDOException $e) {
            $error = [
                'error' => true,
                'message' => $e->getMessage(),
            ];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    });
};
