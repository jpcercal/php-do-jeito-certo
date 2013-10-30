<?php

namespace Cekurte\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Cekurte\Model\SexoModel;
use Cekurte\Model\AgendaModel;

class AgendaController extends CekurteController
{
    public function indexAction(Request $request)
    {
        $contatos = new AgendaModel();

        $this->getSession()->clear();

        return $this->render('Agenda/index.html.twig', array(
            'contatos' => $contatos->getAll(),
            'messages' => $this->getSession()->has('messages') ? $this->getSession()->get('messages') : array()
        ));
    }

    public function createAction(Request $request)
    {
        if ($request->getMethod() === 'POST') {

            $agenda = new AgendaModel();

            if ($agenda->save($request->request->all()) !== false) {

                $this->getSession()->set('messages', array('Cadastrado com sucesso!'));

                return $this->getApp()->redirect($this->generateUrl('cekurte.agenda.index'));
            }
        }

        $sexo = new SexoModel();

        return $this->render('Agenda/create.html.twig', array(
            'sexo'     => $sexo->getAll(),
            'messages' => $this->getSession()->has('messages') ? $this->getSession()->get('messages') : array(),
        ));
    }

    public function retrieveAction(Request $request)
    {
        $agenda = new AgendaModel();

        var_dump($agenda->get($request->get('id')));
    }

    public function updateAction(Request $request)
    {

    }

    public function deleteAction(Request $request)
    {

    }
}
