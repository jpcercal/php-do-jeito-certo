<?php

namespace Cekurte\Model;

use Silex\Application;
use Cekurte\Util\CekurteObject;

/**
 * Base Model
 *
 * @author João Paulo Cercal <sistemas@cekurte.com>
 * @version 1.0
 */
abstract class CekurteModel extends CekurteObject
{
    /**
     * Recupera uma instância do banco de dados
     *
     * @return \Doctrine\DBAL\Connection
     */
    protected function getDatabase()
    {
        $app = $this->getApp();

        return $app['db'];
    }
}