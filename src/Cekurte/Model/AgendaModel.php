<?php

namespace Cekurte\Model;

use Cekurte\Model\CekurteModel;

/**
 * Camada Model do Design Pattern MVC
 *
 * @author João Paulo Cercal <sistemas@cekurte.com>
 * @author Adan Felipe Medeiros <adanfm@gmail.com>
 */
class AgendaModel extends CekurteModel
{
    /**
     * O nome da tabela no banco de dados
     *
     * @var string
     */
    protected $tableName = 'agenda';

    /**
     * Recupera todos os registros presentes na base de dados.
     *
     * @return array
     */
    public function getAll()
    {
        // Recupera uma instância da classe "Doctrine\DBAL\Connection"
        $dbal = $this->getDatabase();

        // Escreve um comando SQL que será executado
        $sql = "SELECT * FROM $this->tableName";

        // Executa o comando SQL presente na variável "$sql"
        // e retorna os resultados em um vetor (array)
        return $dbal->query($sql)->fetchAll();
    }

    /**
     * Recupera um único registro da base de dados com base em um "ID" (identificador)
     *
     * @param int $id
     *
     * @return array
     */
    public function getContato( $id )
    {
        // Recupera uma instância da classe "Doctrine\DBAL\Connection"
        $dbal = $this->getDatabase();

        // Escreve um comando SQL que será executado
        $sql = "SELECT * from $this->tableName WHERE id = $id";

        // Executa o comando SQL presente na variável "$sql"
        // e retorna o resultado em um vetor (array)
        return $dbal->query( $sql )->fetch();
    }

    /**
     * Se os dados forem validados, então: Cria e Atualiza
     * os registros presentes na base de dados.
     *
     * Para atualizar os registros será necessário que haja
     * uma chave do vetor de dados nomeada como "id" e o seu
     * valor deverá conter a chave primária da linha que deverá
     * ser atualizada na base de dados.
     *
     * @param array $dados
     *
     * @return array|boolean
     */
    public function save(array $dados)
    {
        // Cria uma variável para armazenar os erros
        $error = array();

        // Verifica se um e-mail é valido, um e-mail valido deve ser composto por:
        // usuario@dominio.com
        if (filter_var($dados['email'], FILTER_VALIDATE_EMAIL) === false) {

            // Caso o e-mail não siga os padrões mencionados acima, uma mensagem
            // de erro será adicionada ao vetor de errors.
            $error[] = 'Este email não é valido!';
        }

        // Verifica se o nome foi preenchido
        if (empty($dados['nome'])) {

            // Caso o nome não tenha sido preenchido no formulário, uma mensagem
            // de erro será adicionada ao vetor de errors.
            $error[] = 'O nome é obrigatorio!';
        }

        // Recupera uma instância da classe "Doctrine\DBAL\Connection"
        $dbal = $this->getDatabase();

        // Se estiver presente no array "$dados" uma chave chamada "id",
        // e esta chave possuir algum valor diferente de vazio, então:
        // o sistema irá entender que o usuário deseja atualizar um registro
        // presente na base de dados. Do contrário, o sistema irá entender
        // que o usuário deseja realizar a inserção de um contato na base de dados.
        if (isset($dados['id']) and !empty($dados['id'])) {

            // Solicita que o banco de dados ATUALIZE um registro
            // + $this->tableName           : "agenda" (é a propriedade que definimos no começo da classe)
            // + dados                      : os dados fornecidos pelo usuário ao preencher o formulário
            // array('id' => $dados['id'])  : o nome da chave primária e o seu valor
            //
            // Isso nos permite trabalhar com multiplos bancos de dados,
            // DBAL (Database Abstract Layer) - Camada de Banco de dados Abstrata
            $result = $dbal->update($this->tableName, $dados, array(
                'id' => $dados['id']
            ));

        } else {

            // Solicita que o banco de dados CADASTRE um registro
            // + $this->tableName           : "agenda" (é a propriedade que definimos no começo da classe)
            // + dados                      : os dados fornecidos pelo usuário ao preencher o formulário
            //
            // Isso nos permite trabalhar com multiplos bancos de dados,
            // DBAL (Database Abstract Layer) - Camada de Banco de dados Abstrata
            $result = $dbal->insert($this->tableName, $dados);
        }

        // Caso o registro não possa ser CRIADO ou ATUALIZADO,
        // uma mensagem de erro será adicionada ao vetor de errors.
        if($result == false) {
            $error[] = 'Problemas ao inserir o contato!';
        }

        // Caso não exista nenhum valor na variável "$error" então retorne TRUE,
        // do contrário, retorne os errors ocorridos...
        return empty($error) ? true : $error;
    }

    /**
     * Remove um registro da base de dados com base em um "ID" (identificador)
     *
     * @param int $id
     *
     * @return array
     */
    public function delete( $id )
    {
        // Recupera uma instância da classe "Doctrine\DBAL\Connection"
        // e executa o método "delete", informando o nome da tabela e
        // qual o "ID" (identificador) do registro que deverá ser removido
        return $this->getDatabase()->delete($this->tableName, array(
            'id' => $id
        ));
    }
}
