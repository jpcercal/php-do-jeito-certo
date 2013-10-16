<?php

namespace Cekurte\Model;

use Silex\Application;

/**
 * Agenda Model
 *
 * @author João Paulo Cercal <sistemas@cekurte.com>
 * @version 1.0
 */
class AgendaModel extends CekurteModel
{
	private $tableName = 'agenda';

	public function get($id)
	{
		$sql = sprintf(
			'SELECT * FROM %s WHERE id = %s',
			$this->tableName,
			filter_var($id, FILTER_SANITIZE_NUMBER_INT)
		);

		$exec = $this->getDatabase()->query($sql);

	 	return $exec->fetch();
	}

	public function getAll()
	{
		$sql = sprintf(
            'SELECT * FROM %s ORDER BY id ASC',
            $this->tableName
        );

		$exec = $this->getDatabase()->query($sql);

	 	return $exec->fetchAll();
	}

	public function delete( $id )
	{
		return $this->getDatabase()->delete($this->tableName, array('id' => $id));
	}

	public function save(array $contato)
	{
		$contato = array(
            'nome'       => filter_var($contato['nome'],     FILTER_SANITIZE_STRING),
            'telefone'   => filter_var($contato['telefone'], FILTER_SANITIZE_STRING),
            'sexo_sigla' => filter_var($contato['sexo'],     FILTER_SANITIZE_STRING),
            'email' 	 => filter_var($contato['email'],    FILTER_SANITIZE_STRING),
        );

        $errors = array();

        if ($contato['nome'] === false) {
        	$errors['nome'] = 'O campo nome é obrigatório!';
        }

        if ($contato['telefone'] === false) {
        	$errors['telefone'] = 'O campo nome é obrigatório!';
        }

        if ($contato['sexo_sigla'] === false) {
        	$errors['sexo_sigla'] = 'O campo nome é obrigatório!';
        }

        if ($contato['sexo_sigla'] === false) {
        	$errors['sexo_sigla'] = 'O campo nome é obrigatório!';
        }

        if (filter_var($contato['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors['sexo_sigla'] = 'O campo e-mail não é um e-mail válido!';
        }

        if (!empty($errors)) {

        	$this->getSession()->clear();

            $this->getSession()->set('messages', $errors);

            return false;
        }

		if (array_key_exists('id', $contato)) {
			return $this->getDatabase()->update($this->tableName, $contato);
		} else {
			return $this->getDatabase()->insert($this->tableName, $contato);
		}
	}
}