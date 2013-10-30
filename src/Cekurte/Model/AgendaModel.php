<?php

namespace Cekurte\Model;

use Cekurte\Model\CekurteModel;

class AgendaModel extends CekurteModel
{
    /**
     * @var string
     */
    protected $tableName = 'agenda';

    public function getAll()
    {
        $dbal = $this->getDatabase();

        $sql = "SELECT * FROM $this->tableName";

        return $dbal->query($sql)->fetchAll();
    }

    public function save( array $dados )
    {
        $error = array();

        if (filter_var($dados['email'], FILTER_VALIDATE_EMAIL) === false) {
            $error[] = 'Este email não é valido!';
        }

        if( empty($dados['nome']) ){
            $error[] = 'O nome é obrigatorio!';
        }

        $dbal = $this->getDatabase();
        if( array_key_exists('id', $dados) )
            $result = $dbal->update($this->tableName,$dados,
                array('id' => $dados['id'])
            );
        else
            $result = $dbal->insert($this->tableName,$dados);

        if( $result == false )
            $error[] = 'Problemas ao inserir o contato!';

        return empty($error) ? true : $error;
    }

    public function getContato( $id )
    {
        $dbal = $this->getDatabase();

        $sql = "SELECT * from $this->tableName WHERE id = $id";

        return $dbal->query( $sql )->fetch();
    }

    public function delete( $id )
    {
        return $this->getDatabase()->delete($this->tableName,
            array('id' => $id)
        );
    }
}







