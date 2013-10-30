<?php

namespace Cekurte\Util;

use Silex\Application;

/**
 * Base Object
 *
 * @author João Paulo Cercal <sistemas@cekurte.com>
 * @version 1.0
 */
abstract class CekurteObject
{
    /**
     * @var Application
     */
    protected $app;

    public function __construct()
    {
        global $app;

        $this->app = &$app;
    }

    /**
     * Recupera uma instância da aplicação
     *
     * @return Application
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * Recupera uma instância da sessão
     *
     * @return \Symfony\Component\HttpFoundation\Session\Session
     */
    public function getSession()
    {
        $app = $this->getApp();

        return $app['session'];
    }
}