<?php

declare(strict_types=1);

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\App;

return static function (App $app) {

  $authMiddleware = function (Request $request, RequestHandler $handler): Response {
    $jwt = $request->getHeaderLine('Authorization');

    if (empty($jwt)) {
      throw new Exception('JWT Token required.', 400);
    }

    try {
      $key = new Key('7w8&^7af9*!o%j#)b$#k*p2w#q9@s1z&3n1!&y^vq36znm7!%h', 'HS256');
      $decoded = JWT::decode($jwt, $key);
    } catch (Exception) {
      throw new Exception('Forbidden: you are not authorized.', 403);
    }

    $parsedBody = $request->getParsedBody() ?: [];
    $parsedBody['decoded'] = $decoded;
    $request = $request->withParsedBody($parsedBody);

    return $handler->handle($request);
  };

  // --------------- Home Routes ---------------- //
  $homeController = 'App\Controller\Home:';

  $app->get('/', "{$homeController}api");
  $app->get('/swagger-ui', "{$homeController}swagger");
  $app->get('/api', "{$homeController}getHelp");
  $app->get('/status', "{$homeController}getStatus");


  // --------------- Asset Routes ---------------- //
  $app->group('/assets', function ($app) {
    $asset = 'App\Controller\AssetController:';

    $app->get('', "{$asset}getAll");
    $app->post('', "{$asset}create");
    $app->get('/{id}', "{$asset}getOne");
    $app->put('/{id}', "{$asset}update");
    $app->delete('/{id}', "{$asset}delete");
  });


  // --------------- Category Routes ---------------- //
  $app->group('/categories', function ($app) {
    $category = 'App\Controller\CategoryController:';

    $app->get('', "{$category}getAll");
    $app->post('', "{$category}create");
    $app->get('/{id}', "{$category}getOne");
    $app->put('/{id}', "{$category}update");
    $app->delete('/{id}', "{$category}delete");
  });


  // --------------- Office Routes ---------------- //
  $app->group('/offices', function ($app) {
    $office = 'App\Controller\OfficeController:';

    $app->get('', "{$office}getAll");
    $app->post('', "{$office}create");
    $app->get('/{id}', "{$office}getOne");
    $app->put('/{id}', "{$office}update");
    $app->delete('/{id}', "{$office}delete");
  });


  // --------------- Role Routes ---------------- //
  $app->group('/roles', function ($app) {
    $role = 'App\Controller\RoleController:';

    $app->get('', "{$role}getAll");
    $app->post('', "{$role}create");
    $app->get('/{id}', "{$role}getOne");
    $app->put('/{id}', "{$role}update");
    $app->delete('/{id}', "{$role}delete");
  });


  // --------------- Status Routes ---------------- //
  $app->group('/statuses', function ($app) {
    $status = 'App\Controller\StatusController:';

    $app->get('', "{$status}getAll");
    $app->post('', "{$status}create");
    $app->get('/{id}', "{$status}getOne");
    $app->put('/{id}', "{$status}update");
    $app->delete('/{id}', "{$status}delete");
  });


  // --------------- User Routes ---------------- //
  $app->group('/users', function ($app) {
    $user = 'App\Controller\UserController:';

    $app->get('', "{$user}getAll");
    $app->post('', "{$user}create");
    $app->get('/{id}', "{$user}getOne");
    $app->put('/{id}', "{$user}update");
    $app->delete('/{id}', "{$user}delete");
  });


  // --------------- UserProfile Routes ---------------- //
  $app->group('/user-profiles', function ($app) {
    $userProfile = 'App\Controller\UserProfileController:';

    $app->get('', "{$userProfile}getAll");
    $app->post('', "{$userProfile}create");
    $app->get('/{id}', "{$userProfile}getOne");
    $app->put('/{id}', "{$userProfile}update");
    $app->delete('/{id}', "{$userProfile}delete");
  });

  return $app;
};
