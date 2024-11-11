<?php

declare(strict_types=1);

$container['assetService'] = static function (Pimple\Container $container): App\Service\AssetService {
    return new App\Service\AssetService($container['db']);
};

$container['categoryService'] = static function (Pimple\Container $container): App\Service\CategoryService {
    return new App\Service\CategoryService($container['db']);
};

$container['officeService'] = static function (Pimple\Container $container): App\Service\OfficeService {
    return new App\Service\OfficeService($container['db']);
};

$container['roleService'] = static function (Pimple\Container $container): App\Service\RoleService {
    return new App\Service\RoleService($container['db']);
};

$container['statusService'] = static function (Pimple\Container $container): App\Service\StatusService {
    return new App\Service\StatusService($container['db']);
};

$container['userService'] = static function (Pimple\Container $container): App\Service\UserService {
    return new App\Service\UserService($container['db']);
};

$container['userProfileService'] = static function (Pimple\Container $container): App\Service\UserProfileService {
    return new App\Service\UserProfileService($container['db']);
};

$container['authService'] = static function (Pimple\Container $container): App\Service\AuthService {
    return new App\Service\AuthService($container['db']);
};

$container['locationService'] = static function (Pimple\Container $container): App\Service\LocationService {
    return new App\Service\LocationService($container['db']);
};
