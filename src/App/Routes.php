<?php

declare(strict_types=1);

use App\Middleware\AuthMiddleware;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

return static function (App $app) {

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
    $app->get('/category/{categoryId}', "{$asset}getByCategory");
    $app->put('/{id}', "{$asset}update");
    $app->delete('/{id}', "{$asset}delete");
    $app->patch('/{id}/transfer/{locationId}', "{$asset}transfer");
  });

  // --------------- Category Routes ---------------- //
  $app->group('/categories', function ($app) {
    $category = 'App\Controller\CategoryController:';

    $app->get('', "{$category}getAll");
    $app->get('/stats', "{$category}getAllWithExtraInfo");
    $app->post('', "{$category}create");
    $app->get('/{id}', "{$category}getOne");
    $app->put('/{id}', "{$category}update");
    $app->delete('/{id}', "{$category}delete");
    $app->patch('/{id}/block', "{$category}toggleBlock");
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


  // --------------- Auth Routes ---------------- //
  $app->group('/auth', function ($app) {
    $auth = 'App\Controller\AuthController:';

    $app->post('/login', "{$auth}login");
    $app->post('/register', "{$auth}register");
    $app->post('/logout', "{$auth}logout")->add(new AuthMiddleware());
  });


  // --------------- Location Routes ---------------- //
  $app->group('/locations', function ($app) {
    $location = 'App\Controller\LocationController:';

    $app->get('', "{$location}getAll");
    $app->post('', "{$location}create");
    $app->get('/{id}', "{$location}getOne");
    $app->put('/{id}', "{$location}update");
    $app->delete('/{id}', "{$location}delete");
    $app->patch('/{id}/block', "{$location}toggleBlock");
  });


  // --------------- Vendor Routes ---------------- //
  $app->group('/vendors', function ($app) {
    $vendor = 'App\Controller\VendorController:';

    $app->get('', "{$vendor}getAll");
    $app->post('', "{$vendor}create");
    $app->get('/{id}', "{$vendor}getOne");
    $app->put('/{id}', "{$vendor}update");
    $app->delete('/{id}', "{$vendor}delete");
  });


  // --------------- Asset Item Routes ---------------- //
  $app->group('/asset-items', function ($app) {
    $assetItem = 'App\Controller\AssetItemController:';

    $app->get('', "{$assetItem}getAll");
    $app->get('/category/{categoryId}', "{$assetItem}getAllByCategory");
    $app->post('', "{$assetItem}create");
    $app->get('/{id}', "{$assetItem}getOne");
    $app->put('/{id}', "{$assetItem}update");
    $app->delete('/{id}', "{$assetItem}delete");
  });

  return $app;
};
