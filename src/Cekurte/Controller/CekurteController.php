<?php

namespace Cekurte\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Cekurte\Util\CekurteObject;

/**
 * Base Controller
 *
 * @author João Paulo Cercal <sistemas@cekurte.com>
 * @version 1.0
 */
abstract class CekurteController extends CekurteObject
{
    /**
     * Cria uma URL
     *
     * @param  string $route
     * @return string
     */
    public function generateUrl($route)
    {
        $app = $this->getApp();

        return $app['url_generator']->generate($route);
    }

    /**
     * Renderiza uma view utilizando o Template Engine Twig
     *
     * @param  string $view
     * @param  array $params
     *
     * @return string
     */
    public function render($view, array $params = array())
    {
        $calledClass = explode('\\', get_called_class());

        $view = sprintf('%s/%s/%s',
            $calledClass[0],
            'View',
            $view
        );

        return $this->app['twig']->render($view, $params);
    }

    /**
     * Resposta via json
     *
     * @param  array  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function json(array $response)
    {
        return new Response(json_encode($response), 200, array(
            'content-type' => 'application/json'
        ));
    }
}