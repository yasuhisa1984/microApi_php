<?php
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// ルーティングの設定
(require __DIR__ . '/routes.php')($app);

// エラーハンドリングを有効にする
$app->addErrorMiddleware(true, true, true);

$app->run();
