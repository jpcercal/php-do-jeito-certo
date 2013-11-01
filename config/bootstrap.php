<?php

use Silex\Application;

use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\FacebookServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\SessionServiceProvider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application();

// -----------------------------------------------------------------
// Configura alguns parametros da aplicação

$parameters = require_once 'parameters.php';

$app['debug'] = $parameters['debug'];

Request::enableHttpMethodParameterOverride();

date_default_timezone_set($parameters['date']['timezone']);

define('APP_PATH',        realpath(__DIR__  . '/../'));
define('APP_PATH_CONFIG', realpath(APP_PATH . '/config/'));
define('APP_PATH_CACHE',  realpath(APP_PATH . '/cache/'));
define('APP_PATH_LOG',    realpath(APP_PATH . '/log/'));
define('APP_PATH_DOCS',   realpath(APP_PATH . '/docs/'));
define('APP_PATH_SRC',    realpath(APP_PATH . '/src/'));
define('APP_PATH_VENDOR', realpath(APP_PATH . '/vendor/'));
define('APP_PATH_WEB',    realpath(APP_PATH . '/web/'));

define('APP_NAME',  $parameters['name']);
define('APP_DEBUG', $parameters['debug']);

// -----------------------------------------------------------------
// Registra e configura os Serviços

$app->register(new SessionServiceProvider());

$app->register(new UrlGeneratorServiceProvider());

$app->register(new DoctrineServiceProvider(),   require_once 'doctrine.php');

$app->register(new TwigServiceProvider(),       require_once 'twig.php');

$app->register(new MonologServiceProvider(),    require_once 'monolog.php');

// -----------------------------------------------------------------
// Configura o manipulador de erros

/*
$app->error(function(\Exception $e, $code) use ($app) {
    if (!$app['debug']) {
        return $app['twig']->render("errors/$code.twig", array(
            'error' => $e->getMessage()
        ));
    }
});
*/

// -----------------------------------------------------------------
// Cria as rotas da aplicação

$app->mount('/', new Cekurte\Provider\CekurteControllerProvider('\\Cekurte\\Controller\\AgendaController'));

// -----------------------------------------------------------------
// Inicia a aplicação

return $app;