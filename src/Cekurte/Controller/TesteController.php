<?php

namespace Cekurte\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TesteController extends CekurteController
{
	public function indexAction(Request $request)
    {
        return new Response('teste');
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