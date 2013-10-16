<?php

namespace Cekurte\Model;

use Silex\Application;

/**
 * Sexo Model
 *
 * @author João Paulo Cercal <sistemas@cekurte.com>
 * @version 1.0
 */
class SexoModel extends CekurteModel
{
    private $tableName = 'sexo';

    public function getAll()
    {
        $sql = sprintf(
            'SELECT * FROM %s ORDER BY sigla ASC',
            $this->tableName
        );

        $exec = $this->getDatabase()->query($sql);

        return $exec->fetchAll();
    }
}