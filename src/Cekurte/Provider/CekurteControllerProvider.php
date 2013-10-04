<?php

namespace Cekurte\Provider;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Provedor de Rotas da Aplicação
 *
 * @author João Paulo Cercal <sistemas@cekurte.com>
 * @version 1.0
 */
class CekurteControllerProvider implements ControllerProviderInterface
{
    /**
     * Sufixo de um método que deverá ser mapeado nas rotas da aplicação
     */
    const ACTION_SUFFIX = 'action';

    /**
     * Nome do controller, incluindo o namespace \\Cekurte\\Controller\\TesteController
     *
     * @var string
     */
    protected $controllerName;

    /**
     * Cria o mapeamento de "actions" um controller
     *
     * @param string $controllerName Exemplo: \\Cekurte\\Controller\\TesteController
     */
    public function __construct($controllerName)
    {
        $this->setControllerName($controllerName);
    }

    /**
     * Recupera uma instância de um Controller
     *
     * @param  Application $app
     *
     * @return Closure
     */
    protected function shareController(Application $app)
    {
        $controllerName = $this->getControllerName();

        $routeName = $this->getRouteNameByController();

        return $app[$routeName] = $app->share(function() use ($app, $controllerName) {
            return new $controllerName($app);
        });
    }

    /**
     * Connect
     *
     * @param  Application $app
     *
     * @return \Silex\ControllerCollection
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $this->shareController($app);

        $this->setControllerName('\\Cekurte\\Controller\\TesteController');

        $methods = $this->getMethodsFromController();

        if (!empty($methods)) {

            $routeName = $this->getRouteNameByController();

            foreach ($methods as $method) {

                $route = $this->getRouteByAction($method);

                $controllers
                    ->match(sprintf('/%s/', $route), function (Request $request) use ($app, $method, $routeName) {
                        return $app[$routeName]->{$method}($request);
                    })
                    ->bind(sprintf('%s.%s', 'hotsite', $route))
                    ->method('GET|POST')
                ;
            }
        }

        return $controllers;
    }

    /**
     * Configura o nome do controller que será mapeado
     *
     * @param string $controllerName
     */
    protected function setControllerName($controllerName)
    {
        $this->controllerName = $controllerName;
    }

    /**
     * Recupera o nome do controller
     *
     * @return string
     */
    protected function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * Recupera as "actions" de um controller
     *
     * @return array
     */
    public function getMethodsFromController()
    {
        $methods = get_class_methods($this->getControllerName());

        $actions = array();

        if (!empty($methods)) {

            foreach ($methods as $method) {

                if (strtolower(substr($method, strlen($method) - strlen(self::ACTION_SUFFIX))) === self::ACTION_SUFFIX) {
                    $actions[] = $method;
                }
            }
        }

        return $actions;
    }

    /**
     * Recupera o nome de uma rota com base na assinatura de um método (action) de um controller.
     *
     * @param  string $action
     * @return string
     */
    public function getRouteByAction($action)
    {
        if (empty($action)) {
            throw new Exception('Nenhuma action foi informada para gerar o roteamento.');
        }

        $actionSuffix = ucfirst(self::ACTION_SUFFIX);

        if (strpos($action, $actionSuffix) === false) {
            throw new Exception('Esta action não possuí o prefixo "Action", sendo assim, não pode ser roteada.');
        }

        return strtolower(preg_replace('/([A-Z])+/', '-$1', str_replace($actionSuffix, '', $action)));
    }

    /**
     * Recupera de identificação dado a uma rota com base no nome de um controller
     *
     * @return string
     */
    public function getRouteNameByController()
    {
        $controllerName = explode('\\', $this->getControllerName());

        if (empty($controllerName)) {
            throw new Exception('Não foi possível recuperar o nome do controller.');
        }

        return sprintf('%s.%s', 'cekurte', str_replace('controller', '', strtolower(end($controllerName))));
    }
}