<?php

namespace Cekurte\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Cekurte\Model\AgendaModel;

class AgendaController extends CekurteController
{
    public function indexAction()
    {

        $agendaModel = new AgendaModel();

        $messages   =   $this->getSession()->get('messages');

        $this->getSession()->clear();

        return $this->render(
            'Agenda/index.html.twig',array(
                'itens'     =>  $agendaModel->getAll(),
                'messages'  =>  $messages
            )
        );
    }

    public function createAction(Request $request)
    {
        if ($request->getMethod() === 'POST') {

            $agendaModel = new AgendaModel();

            $result = $agendaModel->save($request->request->all());

            if( $result === true ){

                $this->getSession()
                     ->set('messages', array('Cadastrado com sucesso!'));
            }else{
                $this->getSession()
                     ->set('messages', $result);
            }

            return $this->getApp()->redirect(
                $this->generateUrl('cekurte.agenda.index')
            );

        }else{
            return $this->render('Agenda/create.html.twig', array());
        }

    }

    public function editAction( Request $request )
    {
        $agendaModel    =   new AgendaModel();

        if( $request->getMethod() === 'POST' ){

            $result = $agendaModel->save($request->request->all());

            if( $result === true ){

                $this->getSession()
                     ->set('messages', array('Atualizado com sucesso!'));
            }else{
                $this->getSession()
                     ->set('messages', $result);
            }

            return $this->getApp()->redirect(
                $this->generateUrl('cekurte.agenda.index')
            );
        }else{

            $id = (int) $request->get('id');

            $contato = $agendaModel->getContato( $id );

            return $this->render('Agenda/create.html.twig',array(
                'contato'   =>  $contato
            ));
        }
    }

    public function deleteAction( Request $request )
    {
        $agendaModel = new AgendaModel();

        $agendaModel->delete( $request->get('id') );

        return $this->getApp()->redirect(
            $this->generateUrl('cekurte.agenda.index')
        );
    }
}














