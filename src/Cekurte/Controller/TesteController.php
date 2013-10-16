<?php

namespace Cekurte\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Cekurte\Model\TesteModel;

class TesteController extends CekurteController
{
	public function indexAction(Request $request)
    {
        $contatos = new TesteModel();

        return $this->render('Teste/index.html.twig', array(
            'contatos' => $contatos->getAll(),
        ));
    }

    public function naoConcordoAction(Request $request)
    {
        return $this->render('Teste/nao-concordo.html.twig', array(
            'param1' => 'value1',
        ));
    }

    public function jsonAction(Request $request)
    {
        return $this->json(array(
            'param1' => 'value1',
        ));
    }
}