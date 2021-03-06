<?php

use App\Validation\Validator;
use SlimSession\Helper;
use Valitron\Validator as V;

/**
 * Composer autoload
 */
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Dot env configuration
 */
try {
	(new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
	//
}

/**
 * Valitron Library
 */
V::langDir(__DIR__.'/../resources/lang/valitron'); // always set langDir before lang.
V::lang(getenv('VALIDATOR_LANG'));

/**
 * Configuration to default time zone
 */
date_default_timezone_set(getenv('SET_TIME_LOCATE'));

/**
 * App Init
 */
require_once __DIR__ . '/../config/app.php';

/**
 * Get container
 */
$container = $app->getContainer();

/**
 * Whoops configuration
 */
$whoopsGuard = new \Zeuxisoo\Whoops\Provider\Slim\WhoopsGuard();
$whoopsGuard->setApp($app);
$whoopsGuard->setRequest($container['request']);
$whoopsGuard->setHandlers([]);
$whoopsGuard->install();

/**
 * Registering Globally Session Helpers
 */
$container['session'] = function () {
	return new Helper;
};

/**
 * CSRF support
 *
 * @param $container
 *
 * @return Slim\Csrf\Guard
 */
$container['csrf'] = function ($container) {
	$guard = new Slim\Csrf\Guard();
	$guard->setFailureCallable(function ($request, $response, $next) use ($container){
		$body = new \Slim\Http\Body(fopen('php://temp', 'r+'));
		$body->write( $container->view->fetch('errors/csrf.twig') );
		return $response->withStatus( 400 )
		                ->withHeader( 'Content-Type', 'text/html' )
		                ->withBody( $body );
	});

	return $guard;
};

/**
 * Middleware
 */
require_once __DIR__ . '/../config/middleware.php';

/**
 * Auth support
 * @param $container
 *
 * @return \App\Auth\Auth
 */
$container['auth'] = function ($container) {
	return new \App\Auth\Auth($container);
};

/**
 * Flash messages
 *
 * @return \Slim\Flash\Messages
 */
$container['flash'] = function () {
	return new \Slim\Flash\Messages;
};

/**
 * Custom Not Found handler
 *
 * @param $container
 *
 * @return \App\Handlers\NotFoundHandler
 */
$container['notFoundHandler'] = function ($container) {
	return new  \App\Handlers\NotFoundHandler($container->view);
};

/**
 * Eloquent configuration
 */
require_once __DIR__ . '/../config/database.php';

/**
 * Validation
 *
 * @param $container
 *
 * @return Validator
 */
$container['validator'] = function ($container) {
	return new Validator($container);
};

/**
 * Twig configuration
 * @param $container
 *
 * @return Twig
 */
require_once __DIR__ . '/../config/view.php';

/*
 * Routes
 */
require_once __DIR__ . '/../config/routes.php';