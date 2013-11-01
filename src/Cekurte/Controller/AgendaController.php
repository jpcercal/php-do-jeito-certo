<?php

namespace Cekurte\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Cekurte\Model\AgendaModel;

/**
 * Camada Controller do Design Pattern MVC
 *
 * @author João Paulo Cercal <sistemas@cekurte.com>
 * @author Adan Felipe Medeiros <adanfm@gmail.com>
 */
class AgendaController extends CekurteController
{
    /**
     * Método responsável por renderizar a página inicial (RETRIEVE)
     *
     * A pagina inicial irá realizar a listagem de todos os contatos
     * da nossa agenda.
     *
     * @return string
     */
    public function indexAction()
    {
        // Instancia um objeto do tipo AgendaModel
        // Este objeto será utilizado para realizar
        // operações no Modelo (banco de dados)...
        $agendaModel = new AgendaModel();

        // Carrega as mensagens presente no objeto da sessão $_SESSION
        $messages =   $this->getSession()->get('messages');

        // Limpa os dados da sessão
        $this->getSession()->clear();

        // Renderiza o arquivo "Agenda/index.html.twig" e passa para ele
        // as seguintes variáveis:
        // + itens: contendo todos os contatos vindos do banco de dados
        // + messages: contendo todas as mensagens vindas da sessão
        return $this->render(
            'Agenda/index.html.twig',array(
                'itens'     =>  $agendaModel->getAll(),
                'messages'  =>  $messages
            )
        );
    }

    /**
     * Método responsável por renderizar a página de criação (CREATE)
     *
     * Exibirá um formulário para que o usuário possa cadastrar um novo contato
     * e quando ele submeter o formulário, solicita para que o modelo (Model)
     * persista as informações na base de dados.
     *
     * @param  Request os dados que vieram da requisição
     *
     * @return string
     */
    public function createAction(Request $request)
    {
        // Se o formulário foi submetido a requisição será do tipo "POST", então:
        if ($request->getMethod() === 'POST') {

            // Instancia um objeto do tipo AgendaModel
            // Este objeto será utilizado para realizar
            // operações no Modelo (banco de dados)...
            $agendaModel = new AgendaModel();

            // Repassa os dados preenchidos pelo usuário no formulário de cadastro
            // para o método "save" presente na classe "AgendaModel" e armazena
            // o resultado na variável "$result".
            $result = $agendaModel->save($request->request->all());

            // Se retornar true, significa que a informação foi CADASTRADA no banco de dados...
            if ($result === true) {

                // Armazena na sessão uma mensagem "Cadastrado com sucesso!"...
                $this->getSession()->set('messages', array('Cadastrado com sucesso!'));

            } else {

                // Armazena na sessão as mensagens de erro ocorridas durante a validação dos dados...
                $this->getSession()->set('messages', $result);

            }

            // Redireciona o usuário para a página inicial...
            return $this->getApp()->redirect(
                $this->generateUrl('cekurte.agenda.index')
            );

        } else {

            // Mostra o formulário de cadastro e não preenche nenhum dos campos
            return $this->render('Agenda/create.html.twig', array(
                'contato' => array(
                    'nome'          => '',
                    'email'         => '',
                    'telefone'      => '',
                    'sexo_sigla'    => '',
                    'id'            => '',
                ),
            ));
        }

    }

    /**
     * Método responsável por renderizar a página de edição (UPDATE)
     *
     * Exibirá um formulário para que o usuário possa atualizar um contato
     * já existente na base de dados, e quando ele submeter o formulário,
     * solicita para que o modelo (Model) persista as informações na base de dados.
     *
     * @param  Request os dados que vieram da requisição
     *
     * @return string
     */
    public function updateAction( Request $request )
    {
        // Instancia um objeto do tipo AgendaModel
        // Este objeto será utilizado para realizar
        // operações no Modelo (banco de dados)...
        $agendaModel = new AgendaModel();

        // Se o formulário foi submetido a requisição será do tipo "POST", então:
        if ($request->getMethod() === 'POST') {

            // Repassa os dados preenchidos pelo usuário no formulário de cadastro
            // para o método "save" presente na classe "AgendaModel" e armazena
            // o resultado na variável "$result".
            $result = $agendaModel->save($request->request->all());

            // Se retornar true, significa que a informação foi ATUALIZADA no banco de dados...
            if ($result === true) {

                // Armazena na sessão uma mensagem "Atualizado com sucesso!"...
                $this->getSession()->set('messages', array('Atualizado com sucesso!'));

            } else {

                // Armazena na sessão as mensagens de erro ocorridas durante a validação dos dados...
                $this->getSession()->set('messages', $result);

            }

            // Redireciona o usuário para a página inicial...
            return $this->getApp()->redirect(
                $this->generateUrl('cekurte.agenda.index')
            );

        } else {

            // Armazena na variável "$id" o Identificador do recurso que deverá
            // ser buscado na base de dados.
            $id = (int) $request->get('id');

            // Solicita para que o modelo localize a coluna que identifica a
            // chave primária da tabela "agenda" através do ID
            $contato = $agendaModel->getContato( $id );

            // Renderiza o formulário de cadastro, preenchido com as informações
            // fornecidas pelo modelo (Model).
            return $this->render('Agenda/create.html.twig',array(
                'contato'   =>  $contato
            ));
        }
    }

    /**
     * Método responsável por remover um registro da base de dados (DELETE)
     *
     * @param  Request os dados que vieram da requisição
     *
     * @return string
     */
    public function deleteAction(Request $request)
    {
        // Instancia um objeto do tipo AgendaModel
        // Este objeto será utilizado para realizar
        // operações no Modelo (banco de dados)...
        $agendaModel = new AgendaModel();

        // Solicita para que o modelo (Model) remova da base de dados
        // o recurso identificado pelo "ID" fornecido pelo usuário
        // ao clicar no botão remover presente na listagem de contato "index".
        $agendaModel->delete( $request->get('id') );

        // Redireciona o usuário para a página inicial...
        return $this->getApp()->redirect(
            $this->generateUrl('cekurte.agenda.index')
        );
    }
}














